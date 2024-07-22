<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;

class AboutPageController extends Controller
{
    public function editAboutPage()
    {
        $about = AboutPage::first();
        return view('Dashboard.GeneralSetting.aboutPage', compact('about'));
    }

    // Method to update the existing row

    public function updateAboutPage(Request $request)
    {
        // Define validation rules
        $rules = [
            'about_ar' => 'nullable|string',
            'about_en' => 'nullable|string',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Update or create the sponsor page data
            $about = AboutPage::first() ?? new AboutPage();

            $about->about_ar = $request->about_ar;
            $about->about_en = $request->about_en;

            // Save the about page
            $about->save();

            Toastr::success(__('About Section Updated Successfully'), __('Success'));
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error(__('An error occurred. Try Again'), __('Error'));
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
}
