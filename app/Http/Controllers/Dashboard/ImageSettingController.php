<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ImageSetting;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;

class ImageSettingController extends Controller
{

    public function editImageSetting()
    {
        $images = ImageSetting::first();
        return view('Dashboard.ImageSetting.imageSetting', compact('images'));
    }

    // Method to update the existing row

    public function updateImageSetting(Request $request)
    {
        // Define validation rules
        $rules = [
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'main_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'login_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'register_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'all_program_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Update or create the sponsor page data
            $imageSetting = ImageSetting::first() ?? new ImageSetting();


            if ($request->hasFile('favicon')) {
                $favicon = time() . '01.' . $request->favicon->getClientOriginalExtension();
                $request->favicon->move(public_path('images'), $favicon);
                if ($imageSetting->favicon && file_exists(public_path('images/' . $imageSetting->favicon))) {
                    unlink(public_path('images/' . $imageSetting->favicon));
                }
                $imageSetting->favicon = $favicon;
            }

            if ($request->hasFile('main_logo')) {
                $main_logo = time() . '02.' . $request->main_logo->getClientOriginalExtension();
                $request->main_logo->move(public_path('images'), $main_logo);
                if ($imageSetting->main_logo && file_exists(public_path('images/' . $imageSetting->main_logo))) {
                    unlink(public_path('images/' . $imageSetting->main_logo));
                }
                $imageSetting->main_logo = $main_logo;
            }
            if ($request->hasFile('login_image')) {
                $login_image = time() . '03.' . $request->login_image->getClientOriginalExtension();
                $request->login_image->move(public_path('images'), $login_image);
                if ($imageSetting->login_image && file_exists(public_path('images/' . $imageSetting->login_image))) {
                    unlink(public_path('images/' . $imageSetting->login_image));
                }
                $imageSetting->login_image = $login_image;
            }
            if ($request->hasFile('register_image')) {
                $register_image = time() . '04.' . $request->register_image->getClientOriginalExtension();
                $request->register_image->move(public_path('images'), $register_image);
                if ($imageSetting->register_image && file_exists(public_path('images/' . $imageSetting->register_image))) {
                    unlink(public_path('images/' . $imageSetting->register_image));
                }
                $imageSetting->register_image = $register_image;
            }

            if ($request->hasFile('all_program_image')) {
                $all_program_image = time() . '05.' . $request->all_program_image->getClientOriginalExtension();
                $request->all_program_image->move(public_path('images'), $all_program_image);
                if ($imageSetting->all_program_image && file_exists(public_path('images/' . $imageSetting->all_program_image))) {
                    unlink(public_path('images/' . $imageSetting->all_program_image));
                }
                $imageSetting->all_program_image = $all_program_image;
            }

            // Save the imageSetting page
            $imageSetting->save();

            toastr()->success(__('Image Setting Section Updated Successfully'), __('Success'));
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error(__('An error occurred. Try Again'), __('Error'));
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
}
