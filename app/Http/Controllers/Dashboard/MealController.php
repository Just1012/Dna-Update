<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Meal;
use Illuminate\Http\Request;
use App\Http\Requests\MealRequest;
use App\Http\Controllers\Controller;
use App\Models\Duration;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MealController extends Controller
{
    public function index()
    {
        $data = Meal::all();
        return view('Dashboard.Meal.index', compact('data'));
    }

    public function addMeal()
    {
        return view('Dashboard.Meal.addMeal');
    }

    public function storeMeal(MealRequest $mealRequest)
    {
        try {

            $requestData = $mealRequest->all();
            Meal::create($requestData);

            Toastr::success(__('Meal Created Successfully'), __('Success'));

            return redirect()->route('meal.index');
        } catch (\Throwable $th) {
            Toastr::error(__('Try Again'), __('Error'));
            return redirect()->back();
        }
    }

    public function editMeal(Meal $id)
    {
        return view('Dashboard.Meal.editMeal', compact('id'));
    }

    public function updateMeal(MealRequest $mealRequest, $id)
    {
        try {

            $meal = Meal::findOrFail($id);
            $requestData = $mealRequest->validated();

            $meal->update($requestData);

            Toastr::success(__('Meal Updated Successfully'), __('Success'));

            return redirect()->route('meal.index');
        } catch (\Throwable $th) {
            Toastr::error(__('Try Again'), __('Error'));
            return redirect()->back();
        }
    }


    public function archiveMeal(Meal $id)
    {
        try {
            $id->delete(); // Soft delete the meal

            Toastr::success(__('Meal Archived Successfully'), __('Success'));

            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            Toastr::error(__('Meal Not Found'), __('Error'));
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(__('Something went wrong. Please try again.'), __('Error'));
            return redirect()->back();
        }
    }

    public function archiveMealList()
    {
        $data = Meal::onlyTrashed()->get();
        return view('Dashboard.Meal.archiveMealList', compact('data'));
    }

    public function restoreMeal($id)
    {
        try {
            Meal::withTrashed()
            ->where('id',$id)
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

}
