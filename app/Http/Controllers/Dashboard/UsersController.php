<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function admins()
    {
        $type = 1;
        $page_title = "Admins";
        return view('users.list', compact('type', 'page_title'));
    }
    public function customers()
    {
        $type = 2;
        $page_title = "Customers";
        return view('users.list', compact('type', 'page_title'));
    }

    public function staff()
    {
        $type = 3;
        $page_title = "Staff";
        return view('users.list', compact('type', 'page_title'));
    }

    public function dataTable($type)
    {
        $user = User::where('role_id', $type)->get();
        return response()->json([
            'data' => $user,
            'message' => 'found data'
        ]);
    }

    public function addUser()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function storeUser(UserRequest $userRequest)
    {
        try {
            $requestData = $userRequest->all();

            // Check if an image file was uploaded
            if ($userRequest->hasFile('image')) {
                $imageName = time() . '.' . $userRequest->image->getClientOriginalExtension();
                $userRequest->image->move(public_path('images'), $imageName);
                $requestData['image'] = $imageName;
            }

            // Hash password if it's set in the request
            if (isset($requestData['password'])) {
                $requestData['password'] = bcrypt($requestData['password']);
            }

            // Create the user with the requestData
            User::create($requestData);

            Toastr::success(__('User Created Successfully'), __('Success'));
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(__('Try Again'), __('Error'));
            return redirect()->route('admins.list');
        }
    }

    public function editUser(User $id)
    {
        if ($id->id == 1) {
            return redirect()->back();
        }
        $roles = Role::all();
        return view('users.edit', compact('id', 'roles'));
    }

    public function updateUser(Request $request, $id)
    {
        try {
            // Retrieve the user by ID
            $user = User::findOrFail($id);

            if ($id == 1) {
                Toastr::error('Admin cannot be updated.', 'Error');
                return redirect()->back();
            }

            // Validation rules
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'nullable|string|max:15|unique:users,phone,' . $user->id,
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'role_id' => 'required|exists:roles,id',
            ], [
                'name.required' => 'The name field is required.',
                'name.string' => 'The name must be a string.',
                'name.max' => 'The name may not be greater than 255 characters.',
                'phone.string' => 'The phone number must be a string.',
                'phone.max' => 'The phone number may not be greater than 15 characters.',
                'phone.unique' => 'The phone number has already been taken.',
                'image.image' => 'The file must be an image.',
                'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg.',
                'image.max' => 'The image may not be greater than 2MB.',
                'role_id.required' => 'The role field is required.',
                'role_id.exists' => 'The selected role does not exist.',
            ]);

            // Update user data
            $user->name = $request->name;
            $user->role_id = $request->role_id;

            // Update phone if provided
            if ($request->filled('phone')) {
                $user->phone = $request->phone;
            }

            // Handle file upload
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('images'), $imageName);

                // Delete old image if it exists
                if ($user->image && file_exists(public_path('images/' . $user->image))) {
                    unlink(public_path('images/' . $user->image));
                }
                $user->image = $imageName;
            }

            // Hash password if it's provided in the request
            if (!empty($request->password)) {
                $user->password = bcrypt($request->password);
            }

            $user->save();

            Toastr::success('Profile updated successfully', 'Success');
            return redirect()->back();
        } catch (ValidationException $e) {
            foreach ($e->errors() as $error) {
                Toastr::error($error[0], 'Error');
            }
            return redirect()->back()->withErrors($e->errors());
        } catch (\Throwable $th) {
            Toastr::error('Sorry, please try again.', 'Error');
            return redirect()->route('admins.list');
        }
    }
    public function updateStatus(User $user)
    {
        try {

            if ($user->id == 1) {
                return redirect()->back();
            }

            $user->update([
                'status' => $user->status == 0 ? 1 : 0
            ]);

            $successMessage = $user->status == 1 ?
                'تم تفعيل الفئة بنجاح' :
                'تم إلغاء تفعيل الفئة بنجاح';

            return $successMessage;
        } catch (\Throwable $th) {
            return response()->json(['status' => '404']);
        }
    }

    public function profile($id)
    {
        $user = User::findOrFail($id);
        return view('users.profile', compact('user'));
    }

    public function update(Request $request, $id)
    {
        try {
            // $user = auth()->user()->id;
            $user = User::findOrFail($id);

            if ($request->has('name')) {
                // Initial validation for personal details
                $request->validate([
                    'name' => 'required|string|max:255',
                    'phone' => 'nullable|string|max:15|unique:users,phone,' . $user->id,
                    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ], [
                    'name.required' => 'The name field is required.',
                    'name.string' => 'The name must be a string.',
                    'name.max' => 'The name may not be greater than 255 characters.',
                    'phone.string' => 'The phone number must be a string.',
                    'phone.max' => 'The phone number may not be greater than 15 characters.',
                    'phone.unique' => 'The phone number has already been taken.',
                    'image.image' => 'The file must be an image.',
                    'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg.',
                    'image.max' => 'The image may not be greater than 2MB.',
                ]);

                // Update user data
                $user->name = $request->name;

                // Update phone if provided
                if ($request->filled('phone')) {
                    $user->phone = $request->phone;
                }

                // Handle file upload
                if ($request->hasFile('image')) {
                    $imageName = time() . '.' . $request->image->getClientOriginalExtension();
                    $request->image->move(public_path('images'), $imageName);

                    // Delete old image if it exists
                    if ($user->image && file_exists(public_path('images/' . $user->image))) {
                        unlink(public_path('images/' . $user->image));
                    }
                    $user->image = $imageName;
                }

                $user->save();

                Toastr::success('Profile updated successfully', 'Success');
                return redirect()->back();
            }

            if ($request->has('old_password') || $request->has('new_password')) {
                // Initial validation for password change
                $request->validate([
                    'old_password' => 'required|string',
                    'new_password' => 'required|string|min:8|confirmed',
                ], [
                    'old_password.required' => 'The old password is required.',
                    'old_password.string' => 'The old password must be a string.',
                    'new_password.required' => 'The new password is required.',
                    'new_password.string' => 'The new password must be a string.',
                    'new_password.min' => 'The new password must be at least 8 characters.',
                    'new_password.confirmed' => 'The new password confirmation does not match.',
                ]);

                // Custom validation for old password
                if (!Hash::check($request->old_password, $user->password)) {
                    Toastr::error('The old password is incorrect.', 'Error');
                    return redirect()->back()->withErrors(['old_password' => 'The old password is incorrect.']);
                }

                // Update password
                $user->password = Hash::make($request->new_password);
                $user->save();

                Toastr::success('Password updated successfully', 'Success');
                return redirect()->back();
            }

            Toastr::error('No valid data provided', 'Error');
            return redirect()->back();
        } catch (ValidationException $e) {
            foreach ($e->errors() as $error) {
                Toastr::error($error[0], 'Error');
            }
            return redirect()->back()->withErrors($e->errors());
        } catch (\Throwable $error) {
            Toastr::error('Sorry, please try again.', 'Error');
            return redirect()->back();
        }
    }
}
