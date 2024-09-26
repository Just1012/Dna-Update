<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Models\Slider;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SliderController extends Controller
{
    public function index()
    {
        return view('Dashboard.Slider.index');
    }

    public function getSlider()
    {
        $data = Slider::all();
        return response()->json([
            'data' => $data,
            'message' => 'found data'
        ]);
    }

    public function addSlider()
    {
        return view('Dashboard.Slider.addSlider');
    }


    public function storeSlider(SliderRequest $sliderRequest)
    {
        try {

            $requestData = $sliderRequest->all();
            if ($sliderRequest->hasFile('image')) {
                $imageName = time() . '.' . $sliderRequest->image->getClientOriginalExtension();
                $sliderRequest->image->move(public_path('images'), $imageName);
                $requestData['image'] = $imageName;
            }
            Slider::create($requestData);

            toastr()->success(__('Slider Created Successfully'), __('Success'));
            return redirect()->route('slider.index');
        } catch (\Throwable $th) {
            toastr()->error(__('Try Again'), __('Error'));
            return redirect()->route('slider.index');
        }
    }

    public function editSlider(Slider $id)
    {
        return view('Dashboard.Slider.editSlider', compact('id'));
    }

    public function updateSlider(Request $request, $id)
    {
        try {

            $item = Slider::findOrFail($id);
            $requestData = $request->all();

            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('images'), $imageName);

                // Delete old image if it exists
                if ($item->image && file_exists(public_path('images/' . $item->image))) {
                    unlink(public_path('images/' . $item->image));
                }
                $requestData['image'] = $imageName;
            }

            $item->update($requestData);

            toastr()->success(__('Slider Updated Successfully'), __('Success'));

            return redirect()->route('slider.index');
        } catch (\Throwable $th) {
            toastr()->error(__('Try Again'), __('Error'));
            return redirect()->route('slider.index');
        }
    }


    public function deleteSlider($id)
    {
        try {
            $slider = Slider::findOrFail($id);
            $slider->delete();

            toastr()->success(__('Slider Deleted Successfully'), __('Success'));

            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            toastr()->error(__('Slider Not Found'), __('Error'));
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error(__('Something went wrong. Please try again.'), __('Error'));
            return redirect()->back();
        }
    }




}
