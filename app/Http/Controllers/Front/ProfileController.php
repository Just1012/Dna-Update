<?php

namespace App\Http\Controllers\Front;

use Carbon\Carbon;

use App\Models\Item;
use App\Models\Meal;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function index($id)
    {
        $order = Order::with(['User', 'OrderDays.Address', 'Program'])->where('user_id', $id)->get();
        $user = User::findOrFail($id);
        return view('FrontEnd.profile', compact('order', 'user'));
    }

    public function getOrderData($id)
    {
        $order = Order::with(['User', 'OrderDays.Address', 'Program'])->findOrFail($id);

        $date = Carbon::parse($order->created_at)->format('Y-m-d');
        $time = Carbon::parse($order->created_at)->format('h:i A');

        $locale = app()->getLocale();

        $addressDetails = $order->OrderDays->map(function ($day) use ($locale) {
            $governorateName = DB::table('governorates')
                ->where('id', $day->Address->governorate_id)
                ->select('title_' . $locale . ' as title')
                ->first();

            $areaName = DB::table('areas')
                ->where('id', $day->Address->area_id)
                ->select('area_' . $locale . ' as area')
                ->first();

            return [
                'address' => $day->Address->address,
                'governorate' => $governorateName ? $governorateName->title : '',
                'area' => $areaName ? $areaName->area : '',
                'days3' => array_filter([
                    $day->Monday == 1 ? 'Monday' : null,
                    $day->Tuesday == 1 ? 'Tuesday' : null,
                    $day->Wednesday == 1 ? 'Wednesday' : null,
                    $day->Thursday == 1 ? 'Thursday' : null,
                    $day->Friday == 1 ? 'Friday' : null,
                    $day->Saturday == 1 ? 'Saturday' : null,
                    $day->Sunday == 1 ? 'Sunday' : null,
                ])
            ];
        });

        $meals = collect(json_decode($order->meals_id))->map(function ($mealID) {
            $meal = Meal::find($mealID);
            return [
                'name' => $meal->{'title_' . app()->getLocale()},
                'type' => $meal->type
            ];
        });

        $items = collect(json_decode($order->items_id))->map(function ($itemId) {
            $item = Item::find($itemId);
            return [
                'name' => $item->{'title_' . app()->getLocale()},
                'image' => asset('images/' . $item->image)
            ];
        });

        return response()->json([
            'id' => $order->id,
            'date' => $date,
            'time' => $time,
            'payment_status' => $order->payment_method,
            'program_name' => $order->program->{'title_' . app()->getLocale()},
            'total_amount' => $order->total,
            'address_details' => $addressDetails,
            'meals' => $meals,
            'items' => $items,
            'vulnerability' => $order->vulnerability,
            'unlike' => $order->unlike,
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
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
