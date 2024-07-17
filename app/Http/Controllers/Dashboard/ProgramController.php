<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Menu;
use App\Models\Duration;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Program_Duration;
use App\Http\Controllers\Controller;
use App\Models\Meal;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProgramController extends Controller
{

    public function index()
    {
        $program = Program::with('Menu')->get();
        return view('Dashboard.Program.index');
    }

    public function getProgram()
    {
        $program = Program::with('Menu')->get();
        return response()->json([
            'data' => $program,
            'message' => 'found data'
        ]);
    }

    public function programDetails($id)
    {
        $meal = Meal::all();
        $programDurations = Program_Duration::with(['program', 'meal', 'duration'])->where('program_id', $id)->get();
        return view('Dashboard.Program.program_details', compact('programDurations', 'meal'));
    }

    public function editProgramDetails(Program_Duration $id)
    {
        return view('Dashboard.Program.editProgramMeal', compact('id'));
    }
    public function updateProgramDetails(Request $request, $id)
    {
        try {

            $this->validate($request, [
                'price' => 'required|numeric',
            ]);
            $price = Program_Duration::findOrFail($id);
            $price->price = $request->price;
            $price->save();

            Toastr::success(__('Price Updated Successfully'), __('Success'));

            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(__('Try Again'), __('Error'));
            return redirect()->back();
        }
    }

    public function programMealArchive(Program_Duration $id)
    {
        try {

            $id->delete(); // Soft delete the Menu

            Toastr::success(__('Meal Archived Successfully'), __('Success'));

            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            Toastr::error(__('Program Not Found'), __('Error'));
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(__('Something went wrong. Please try again.'), __('Error'));
            return redirect()->back();
        }
    }


    public function addProgram()
    {
        $menu = Menu::all();
        $meal = Meal::all();
        return view('Dashboard.Program.addProgram', compact('menu', 'meal'));
    }


    public function getDuration()
    {
        $data = Duration::all();
        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }


    public function storeProgram(Request $request)
    {
        $validatedData = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'min_meals' => 'required|integer|min:1',
            'menu_id' => 'required|exists:menus,id',
            'meal_id' => 'required|array',
            'meal_id.*' => 'exists:meals,id',
            'duration_ids' => 'required|array',
            'duration_ids.*' => 'exists:durations,id',
            'price' => 'required|array',
            'price.*' => 'numeric|min:0',
            'is_featured'=>'nullable|in:0,1'
        ]);

        $validatedData['is_featured'] = $request->has('is_featured') ? $request->input('is_featured') : 0;
        // Check for unique meal_id within the same program
        $uniqueMealIds = array_unique($validatedData['meal_id']);
        if (count($uniqueMealIds) != count($validatedData['meal_id'])) {
            Toastr::error(__('Duplicate meals are not allowed within the same program.'), __('Error'));
            return redirect()->back();
        }

        // Handle image upload
        $imageName = $request->hasFile('image') ? time() . '.' . $request->image->getClientOriginalExtension() : null;
        if ($imageName) {
            $request->image->move(public_path('images'), $imageName);
        }


        $program = Program::create([
            'title_ar' => $validatedData['title_ar'],
            'title_en' => $validatedData['title_en'],
            'description_ar' => $validatedData['description_ar'],
            'description_en' => $validatedData['description_en'],
            'min_meals' => $validatedData['min_meals'],
            'menu_id' => $validatedData['menu_id'],
            'image' => $imageName,
            'is_featured'=>$validatedData['is_featured'],
        ]);

        // Calculate how many durations should be assigned per meal
        $count_meal = count($validatedData['meal_id']);
        $count_duration_ids = count($validatedData['duration_ids']);
        $durationsPerMeal = intdiv($count_duration_ids, $count_meal);

        // Assign durations and prices to each meal
        foreach ($validatedData['meal_id'] as $mealIndex => $mealId) {
            $start = $mealIndex * $durationsPerMeal;
            $end = $start + $durationsPerMeal;

            for ($i = $start; $i < $end; $i++) {
                if (!isset($validatedData['duration_ids'][$i])) {
                    break; // Prevent accessing undefined index if counts are off
                }
                Program_Duration::create([
                    'program_id' => $program->id,
                    'meal_id' => $mealId,
                    'duration_id' => $validatedData['duration_ids'][$i],
                    'price' => $validatedData['price'][$i] ?? 0 // Fallback to 0 if no price is defined
                ]);
            }
        }

        Toastr::success(__('Program Created Successfully'), __('Success'));
        return redirect()->route('program.index');
    }

    public function editProgram(Program $id)
    {
        $menu = Menu::all();
        return view('Dashboard.Program.editProgram', compact('menu', 'id'));
    }

    public function updateProgram(Request $request, $id)
    {
        $request->validate([
            'title_en' => 'required|string', // Add validations as needed
            'title_ar' => 'required|string',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'image' => 'nullable|image', // Validate image if present
            'min_meals' => 'required|integer',
            'menu_id' => 'required|exists:menus,id',
            'is_featured' => 'nullable|in:0,1'
            // Ensure the menu ID exists in the menus table
        ]);

        try {
            $program = Program::findOrFail($id);
            $requestData = $request->except('image'); // Exclude image from request data initially

            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('images'), $imageName);

                // Delete old image if it exists
                if ($program->image && file_exists(public_path('images/' . $program->image))) {
                    unlink(public_path('images/' . $program->image));
                }
                $requestData['image'] = $imageName; // Add new image name to request data
            }

            $program->update($requestData);

            Toastr::success(__('Program Updated Successfully'), __('Success'));
            return redirect()->route('program.index'); // Assuming 'program.index' is the correct route
        } catch (\Throwable $th) {
            Toastr::error(__('Error updating program. Please try again.'), __('Error'));
            return redirect()->back()->withInput();
        }
    }


    public function programArchive(Program $id)
    {
        try {

            $id->delete(); // Soft delete the Menu

            Toastr::success(__('Program Archived Successfully'), __('Success'));

            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            Toastr::error(__('Program Not Found'), __('Error'));
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(__('Something went wrong. Please try again.'), __('Error'));
            return redirect()->back();
        }
    }

    public function archiveProgramList()
    {
        return view('Dashboard.Program.programArchive');
    }
    public function getArchiveProgram()
    {
        $program = Program::onlyTrashed()->get();
        return response()->json([
            'data' => $program,
            'message' => 'found data'
        ]);
    }

    public function restoreProgram($id)
    {
        try {
            Program::withTrashed()
                ->where('id', $id)
                ->restore();
            Toastr::success(__('Product Restored Successfully'), __('Success'));

            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            Toastr::error(__('Product Not Found'), __('Error'));
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(__('Something went wrong. Please try again.'), __('Error'));
            return redirect()->back();
        }
    }

    public function programMealArchiveList($id)
    {
        $program = Program::where('id', $id)->get();
        $programDurations = Program_Duration::onlyTrashed()
            ->with(['program', 'meal', 'duration'])
            ->where('program_id', $id)
            ->get();
        return view('Dashboard.Program.programMealArchive', compact('programDurations', 'program'));
    }

    public function restoreProgramMeal($id)
    {
        try {
            Program_Duration::withTrashed()
                ->where('id', $id)
                ->restore();
            Toastr::success(__('Meal Restored Successfully'), __('Success'));

            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            Toastr::error(__('Meal Not Found'), __('Error'));

            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(__('Something went wrong. Please try again.'), __('Error'));
            return redirect()->back();
        }
    }

    public function addSingleMeal(Request $request)
    {
        $programId = $request->program_id;
        $mealId = $request->meal_id;
        $durationIds = $request->duration_ids;
        $prices = $request->price;

        // Check if the meal_id already exists for the given program_id
        $existingRecord = Program_Duration::where('program_id', $programId)
            ->where('meal_id', $mealId)
            ->exists();

        if ($existingRecord) {
            Toastr::error(__('Duplicate meals are not allowed within the same program.'), __('Error'));
            return redirect()->back();
        } else {
            // If the record doesn't exist, create a new one
            foreach ($durationIds as $index => $durationId) {
                $price = $prices[$index] ?? null;
                if ($price) {
                    Program_Duration::create([
                        'meal_id' => $mealId,
                        'program_id' => $programId,
                        'duration_id' => $durationId,
                        'price' => $price,
                    ]);
                }
            }
        }

        Toastr::success(__('Meal Added Successfully'), __('Success'));
        return redirect()->back();
    }

}
