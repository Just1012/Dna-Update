<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Privacy;
use Illuminate\Http\Request;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;

class PrivacyController extends Controller
{
    public function editPrivacy()
    {
        $privacy = Privacy::first();
        return view('Dashboard.GeneralSetting.privacy', compact('privacy'));
    }

    // Method to update the existing row

    public function updatePrivacy(Request $request)
    {
        // Define validation rules
        $rules = [
            'privacy_ar' => 'nullable|string',
            'privacy_en' => 'nullable|string',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Update or create the sponsor page data
            $privacy = Privacy::first() ?? new Privacy();

            $privacy->privacy_ar = $request->privacy_ar;
            $privacy->privacy_en = $request->privacy_en;

            // Save the privacy page
            $privacy->save();

            toastr()->success(__('Privacy Section Updated Successfully'), __('Success'));
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error(__('An error occurred. Try Again'), __('Error'));
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
}
