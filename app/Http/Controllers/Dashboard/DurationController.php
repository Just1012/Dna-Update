<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Duration;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\DurationRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DurationController extends Controller
{
    public function index()
    {
        $data = Duration::all();
        return view('Dashboard.Duration.index', compact('data'));
    }

    public function addDuration()
    {
        return view('Dashboard.Duration.addDuration');
    }

    public function storeDuration(DurationRequest $durationRequest)
    {
        try {

            $requestData = $durationRequest->all();
            Duration::create($requestData);

            toastr()->success(__('Duration Created Successfully'), __('Success'));

            return redirect()->route('duration.index');
        } catch (\Throwable $th) {
            toastr()->error(__('Try Again'), __('Error'));
            return redirect()->back();
        }
    }

    public function editDuration(Duration $id)
    {
        return view('Dashboard.Duration.editDuration', compact('id'));
    }

    public function updateDuration(DurationRequest $durationRequest, $id)
    {
        try {

            $duration = Duration::findOrFail($id);
            $requestData = $durationRequest->validated();

            $duration->update($requestData);

            toastr()->success(__('Duration Updated Successfully'), __('Success'));

            return redirect()->route('duration.index');
        } catch (\Throwable $th) {
            toastr()->error(__('Try Again'), __('Error'));
            return redirect()->back();
        }
    }


    public function archiveDuration(Duration $id)
    {
        try {
            $id->delete(); // Soft delete the Duration

            toastr()->success(__('Duration Archived Successfully'), __('Success'));

            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            toastr()->error(__('Duration Not Found'), __('Error'));
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error(__('Something went wrong. Please try again.'), __('Error'));
            return redirect()->back();
        }
    }

    public function archiveDurationList()
    {
        $data = Duration::onlyTrashed()->get();
        return view('Dashboard.Duration.archiveDurationList', compact('data'));
    }

    public function restoreDuration($id)
{

    try {
        Duration::withTrashed()
        ->where('id',$id)
        ->restore();
        toastr()->success(__('Duration Restored Successfully'), __('Success'));

        return redirect()->back();

    } catch (ModelNotFoundException $exception) {
        toastr()->error(__('Duration Not Found'), __('Error'));
        return redirect()->back();
    } catch (\Throwable $th) {
        toastr()->error(__('Something went wrong. Please try again.'), __('Error'));
        return redirect()->back();
    }
}
}
