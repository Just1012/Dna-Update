<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ContactSetting;
use Illuminate\Http\Request;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;

class ContactSettingController extends Controller
{
    public function editContactSetting()
    {
        $contact = ContactSetting::first();
        return view('Dashboard.ContactSetting.contactSetting', compact('contact'));
    }

    // Method to update the existing row

    public function updateContactSetting(Request $request)
    {
        // Define validation rules

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'phone' => 'required|string|max:20',
            'facebook' => 'nullable|url',
            'whatsapp' => 'nullable|string|url',
            'twitter' => 'nullable|url',
            'instagram' => 'nullable|url',
            'snapchat' => 'nullable|url',
            'face_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'whats_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'twitter_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'instagram_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'snapchat_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'phone.required' => 'Phone number is required.',
            'phone.string' => 'Phone number must be a string.',
            'phone.max' => 'Phone number must not exceed 20 characters.',
            'facebook.url' => 'Facebook URL is not valid.',
            'whatsapp.string' => 'WhatsApp number must be a string.',
            'whatsapp.max' => 'WhatsApp number must not exceed 20 characters.',
            'twitter.url' => 'Twitter URL is not valid.',
            'instagram.url' => 'Instagram URL is not valid.',
            'snapchat.url' => 'Snapchat URL is not valid.',
            'face_image.image' => 'Face image must be an image file.',
            'face_image.mimes' => 'Face image must be a file of type: jpeg, png, jpg, gif, svg.',
            'face_image.max' => 'Face image must not exceed 2MB.',
            'whats_image.image' => 'WhatsApp image must be an image file.',
            'whats_image.mimes' => 'WhatsApp image must be a file of type: jpeg, png, jpg, gif, svg.',
            'whats_image.max' => 'WhatsApp image must not exceed 2MB.',
            'twitter_image.image' => 'Twitter image must be an image file.',
            'twitter_image.mimes' => 'Twitter image must be a file of type: jpeg, png, jpg, gif, svg.',
            'twitter_image.max' => 'Twitter image must not exceed 2MB.',
            'instagram_image.image' => 'Instagram image must be an image file.',
            'instagram_image.mimes' => 'Instagram image must be a file of type: jpeg, png, jpg, gif, svg.',
            'instagram_image.max' => 'Instagram image must not exceed 2MB.',
            'snapchat_image.image' => 'Snapchat image must be an image file.',
            'snapchat_image.mimes' => 'Snapchat image must be a file of type: jpeg, png, jpg, gif, svg.',
            'snapchat_image.max' => 'Snapchat image must not exceed 2MB.',

        ]);

        // Validate the request data
        if ($validator->fails()) {

            // Get all validation error messages
            $errorMessages = $validator->errors()->all();

            // Display each error message with Toastr
            foreach ($errorMessages as $errorMessage) {
                Toastr::error($errorMessage, 'Error!!');
            }

            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            // Update or create the contact setting data
            $contact = ContactSetting::first() ?? new ContactSetting();

            // Handle file uploads and updates
            $images = [
                'face_image' => 'face_image',
                'whats_image' => 'whats_image',
                'twitter_image' => 'twitter_image',
                'instagram_image' => 'instagram_image',
                'snapchat_image' => 'snapchat_image',
            ];

            foreach ($images as $key => $value) {
                if ($request->hasFile($key)) {
                    $filename = time() . '_' . $key . '.' . $request->$key->getClientOriginalExtension();
                    $request->$key->move(public_path('images'), $filename);

                    if ($contact->$value && file_exists(public_path('images/' . $contact->$value))) {
                        unlink(public_path('images/' . $contact->$value));
                    }

                    $contact->$value = $filename;
                }
            }

            // Update text fields
            $contact->phone = $request->input('phone');
            $contact->facebook = $request->input('facebook');
            $contact->whatsapp = $request->input('whatsapp');
            $contact->twitter = $request->input('twitter');
            $contact->instagram = $request->input('instagram');
            $contact->snapchat = $request->input('snapchat');

            // Save the updated contact setting
            $contact->save();

            Toastr::success(__('Contact Setting Updated Successfully'), __('Success'));
        } catch (\Exception $e) {
            Toastr::error(__('An error occurred while updating the contact settings: ' . $e->getMessage()), __('Error'));
        }

        return redirect()->back();
    }
}
