<?php

namespace App\Http\Controllers\Front;

use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register()
    {
        return view('FrontEnd.auth.register');
    }

    public function login_view()
    {
        return view('FrontEnd.auth.login');
    }
    public function login(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'phone' => ['required', 'string'],
            'password' => ['required', 'min:8'],
        ]);

        // Determine if the input is an email or phone and adjust rules accordingly


        // Perform validation
        if ($validator->fails()) {

            // Get all validation error messages
            $errorMessages = $validator->errors()->all();

            // Display each error message with Toastr
            foreach ($errorMessages as $errorMessage) {
                toastr()->error($errorMessage, 'Error!!');
            }

            return redirect()->back()->withErrors($validator)->withInput();
        }


            $user = User::where('phone', $request->phone)->first();
            if ($user && (!Hash::check($request->password, $user->password))) {
                toastr()->error("invalid password", 'Error');
                return redirect()->back();
            }


            if (!$user) {
                toastr()->error("invalid data", 'Error');
                return redirect()->back();
            }
            Auth::login($user);

            toastr()->success(__('Successfully login user'), __('Success'));


            return redirect()->route('front.index');
            try {   } catch (\Throwable $error) {
            toastr()->error("sorry please try again", 'Error');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {

        // Base rules for all inputs
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'f_name' => ['required', 'string', 'max:255'],
            'l_name' => ['required', 'string', 'max:255'],

            'phone' => ['required', 'string', 'min:8', 'max:8', 'unique:users,phone'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        // Determine if the input is an email or phone and adjust rules accordingly


        // Perform validation
        if ($validator->fails()) {

            // Get all validation error messages
            $errorMessages = $validator->errors()->all();

            // Display each error message with Toastr
            foreach ($errorMessages as $errorMessage) {
                toastr()->error($errorMessage, 'Error!!');
            }

            return redirect()->back()->withErrors($validator)->withInput();
        }



        $name = $request->f_name . ' ' . $request->l_name;
        // Create user
        $user = User::create([
            'phone' => $request->phone,
            'name' => $name,
            'password' => Hash::make($request->password),
            'role_id' => 2
        ]);
        event(new Registered($user));
        Auth::login($user);
        $otp = random_int(1000, 9999);
        $expires_at = Carbon::now()->addMinutes(10);

        Otp::create([
            'user_id' => $user->id,
            'otp' => $otp,
            'expires_at' => $expires_at
        ]);


        // Generate JWT token
        toastr()->success("User created successfully", 'success');
        return redirect()->route('front.otp.index');
        try {
        } catch (\Throwable $error) {
            toastr()->error("sorry please try again", 'error');
            return redirect()->back();
        }
    }


    public function otp()
    {
        return view('FrontEnd.auth.otp');
    }

    public function verifyOtp(Request $request)
    {
        // Concatenate the OTP parts into a single string
        $otp = $request->input('number_1') . $request->input('number_2') . $request->input('number_3') . $request->input('number_4');

        // Validate that the concatenated OTP is provided
        $request->validate([
            'number_1' => 'required|max:1',
            'number_2' => 'required|max:1',
            'number_3' => 'required|max:1',
            'number_4' => 'required|max:1',
        ]);

        // Check the OTP entry
        $otpEntry = Otp::where('user_id', auth()->user()->id)
            ->where('otp', $otp)
            ->where('expires_at', '>', now())
            ->first();

        // Fetch the user model
        $user = User::find(auth()->user()->id); // Ensure you have included User model at the top

        if (!$otpEntry) {
            toastr()->error("Sorry, OTP verification failed", 'Error');
            return redirect()->back();
        }

        // OTP is valid
        $user->is_verified = true;
        $user->save();

        // Optionally, delete the OTP entry if it should not be reused
        $otpEntry->delete();

        // OTP is valid
        // Here, you might want to update the user status or perform other actions
        toastr()->success('OTP verification successful', 'Success');

        return redirect()->route('front.index');
    }


    //     public function sendOtp(Request $request)
    //     {
    //         $userId = helper::customer_id();
    //         $user = Customer::find($userId);

    //         if (!$user) {
    //             return $this->onError(404, 'User not found');

    //         }

    //         // Generate a four-digit OTP
    //         $otp = random_int(1000, 9999);
    //         $expires_at = now()->addMinutes(10); // Set expiration time

    //         // Create or update existing OTP record
    //         OTP::updateOrCreate(
    //             ['customer_id' => $userId],
    //             ['otp' => $otp, 'expires_at' => $expires_at]
    //         );

    //         // // Send OTP via email or SMS
    //         // Mail::raw("Your OTP is: $otp", function ($message) use ($user) {
    //         //     $message->to($user->email)->subject('Verify Your Account');
    //         // });

    //         return $this->onSuccess(200, 'An OTP has been sent to your sms.', true);


    // }


}
