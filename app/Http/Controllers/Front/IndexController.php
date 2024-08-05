<?php

namespace App\Http\Controllers\Front;

use Carbon\Carbon;
use App\Models\Otp;
use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Models\Slider;
use App\Models\Address;
use App\Models\Program;
use App\Models\Category;
use App\Models\DaySetting;
use App\Models\orderDayes;
use Illuminate\Http\Request;
use App\Rules\UniqueOrderDay;
use App\Models\Program_Duration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Models\Coupons;
use App\Models\ShippingNote;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class IndexController extends Controller
{
    public function index()
    {
        $data['slider_main'] = Slider::where('type', '=', 1)->get();
        $data['slider_second'] = Slider::where('type', '=', 0)->get();
        $data['programs'] = Program::where('is_featured', 1)->get();

        $categories = Category::where('num_of_parents', 1)->get();

        return view('front_index', compact('data', 'categories'));
    }

    public function getSubCategory($categoryId = null)
    {
        $subCategories =   $this->customIsSet($categoryId)  ?  Category::where('parent_id', $categoryId)->get() : Category::where('num_of_parents', 2)->get();
        return response()->json($subCategories);
    }

    public function getItems($categoryId = null, $subCategoryId = null)
    {
        if ($this->customIsSet($categoryId) && $this->customIsSet($subCategoryId)) {
            $items = Item::where('subCategory_id', $subCategoryId)->where('category_id', $categoryId)->paginate(10);
        } else if ($this->customIsSet($subCategoryId)) {
            $items = Item::where('subCategory_id', $subCategoryId)->paginate(10);
        } else if ($this->customIsSet($categoryId)) {
            $items = Item::where('category_id', $categoryId)->paginate(10);
        } else {
            $items = Item::paginate(10);
        }
        return response()->json($items);
    }


    public function customIsSet($value)
    {
        return !($value  == 'null' || $value == null || $value == '');
    }

    public function allProgram()
    {
        $programs = Program::all();
        return view('FrontEnd.allProgram', compact('programs'));
    }
    public function programDetails($id)
    {
        $programsDetails = Program::with('meals')->find($id);

        if (!$programsDetails) {
            return redirect()->back()->with('error', 'Program not found.');
        }

        $durations = Program_Duration::where('program_id', $id)
            ->with('duration')
            ->selectRaw('duration_id, SUM(price) as price')
            ->groupBy('duration_id')
            ->get();

        return view('FrontEnd.programDetails', compact('programsDetails', 'durations'));
    }
    protected $id_order = 0;
    public function storeProgramMeals(Request $request, $id)
    {
        // Fetch the program
        $program = Program::find($id);
        $userID = auth()->id() ?? 0; // Assuming you are using authentication and want to use the authenticated user ID

        if (!$program) {
            return redirect()->back()->with('error', 'Program not found.');
        }

        // Validate the form data and ensure meals array exists
        $request->validate([
            'meals' => 'required|array',
            'addons' => 'array',
        ]);

        $cart_custom = Session::get('cart_custom') ?? []; // Get cart_custrom or default to empty array

        $this->id_order = 1;


        $cart_custom[$this->id_order] = array(
            'id' => $this->id_order,
            'user_id' => $userID,
            'meals' => $request->meals,
            'addons' => $request->addons,
            'duration_id' => 0,
            'program' => $program,
            'total' => 0,
            'dont_like' => null,
            'allergic' => null,
            'items' => [],
            'all_meals' => null

        );
        Session::put('cart_custom', $cart_custom);

        return redirect()->route('front.programDuration', ['id' => $program->id]);
    }

    public function programDuration()
    {
        $cart = Session::get('cart_custom'); // Get the authenticated user's ID, defaulting to 1 if not authenticated
        // Initialize an array to hold all meals and addons
        if (empty($cart)) {
            return redirect()->back()->with('error', 'No items found in the cart.');
        }

        if (count($cart[1]['meals']) < $cart[1]['program']['min_meals']) {
            Toastr::info('You Must select at least ' . $cart[1]['program']['min_meals'] . ' meals', 'info');
            return redirect()->back();
        }
        // Initialize an array to hold all meals and addons
        $allItems = [];


        if (isset($cart[1])) {
            $meals = $cart[1]['meals'] ?? [];
            $addons = $cart[1]['addons'] ?? [];
            $allItems = array_merge($allItems, $meals, $addons);
        }

        $cart[1]['all_meals'] = $allItems;
        Session::put('cart_custom', $cart);


        // Debugging output


        $lang = app()->getLocale();
        $program = Program::with('menu.Menu.Item1')->find($cart[1]['program']['id']);

        if (!$program) {
            return redirect()->back()->with('error', 'Program not found.');
        }
        // $durations = Program_Duration::where('program_id', $id)
        //     ->whereIn('meal_id', $allItems)
        //     ->with('duration')
        //     ->selectRaw('duration_id, SUM(price) as price')
        //     ->groupBy('duration_id')
        //     ->get();


        // if ($durations->isEmpty()) {
        //     return redirect()->back()->with('error', 'Program durations not found.');
        // }

        // dd($userID);
        return view('FrontEnd.programDuration', compact('program'));
    }

    // public function save_card(Request $request)
    // {
    //     $cart = Session::get('cart_custom');
    //     // Get the authenticated user's ID, defaulting to 1 if not authenticated
    //     // $cart[1]['duration_id'] = $request->duration;
    //     $cart[1]['dont_like'] = $request->dont_like;
    //     $cart[1]['allergic'] = $request->allergic;
    //     $cart[1]['items'] = explode(',', $request->items);
    //     // $durations = Program_Duration::where('program_id', $cart[1]['program']['id'])
    //     //     ->whereIn('meal_id',  $cart[1]['all_meals'])
    //     //     ->with('duration')
    //     //     ->selectRaw('duration_id, SUM(price) as price')
    //     //     ->where('duration_id', '=', $cart[1]['duration_id'])
    //     //     ->groupBy('duration_id')
    //     //     ->first();
    //     // $cart[1]['total'] = $durations->price;
    //     Session::put('cart_custom', $cart);

    //     return redirect()->route('checkout');
    // }

    public function save_card(Request $request)
    {
        try {
            // Validate the request
            $validatedData = $request->validate([
                'dont_like' => 'required|string',
                'allergic' => 'required|string',
                'notes' => 'required|string',
                'items' => 'nullable|string', // Assuming items is a comma-separated string
            ], [
                'dont_like.required' => 'Please specify what you don\'t like.',
                'allergic.required' => 'Please specify any allergies.',
                'notes.required' => 'Please specify any Notes.',
            ]);

            // Retrieve the cart from the session
            $cart = Session::get('cart_custom', []);

            // Update the cart with the new data
            $cart[1]['dont_like'] = $request->dont_like;
            $cart[1]['allergic'] = $request->allergic;
            $cart[1]['notes'] = $request->notes;
            $cart[1]['items'] = explode(',', $request->items);

            // Store the updated cart back in the session
            Session::put('cart_custom', $cart);

            // Redirect to the checkout page
            return redirect()->route('checkout');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Flash the validation error messages using Toastr
            foreach ($e->validator->errors()->all() as $error) {
                Toastr::error($error, __('Error'));
            }

            // Redirect back to the previous page with input
            return redirect()->back()->withInput();
        } catch (\Exception $e) {
            // Flash a general error message using Toastr
            Toastr::error(__('An unexpected error occurred. Please try again.'), __('Error'));

            // Redirect back to the previous page with input
            return redirect()->back()->withInput();
        }
    }
    public function checkout()
    {
        $cart = Session::get('cart_custom'); // Get the authenticated user's ID, defaulting to 1 if not authenticated

        // dd($cart);
        $days = DaySetting::where('status', 0)->get();

        $daysOff = DaySetting::where('status', 1)->pluck('name');

        // Start by adding 3 days to the current date
        $targetDate = Carbon::now()->addDays(3);

        // Get the day name of the target date
        $targetDayName = $targetDate->format('l');

        // Check if the day is in the days off array and adjust if necessary
        while ($daysOff->contains($targetDayName)) {
            $targetDate->addDay();
            $targetDayName = $targetDate->format('l');
        }

        $minDate = $targetDate->format('Y-m-d');

        $governorates = DB::table('shippings')
            ->join('governorates', 'shippings.governorate_id', '=', 'governorates.id')
            ->select(
                'governorates.id as governorate_id',
                'governorates.title_en as governorate_name_en',
                'governorates.title_ar as governorate_name_ar'
            )
            ->where('shippings.status', 1)
            ->groupBy('governorates.id', 'governorates.title_en', 'governorates.title_ar')
            ->get();

            $shipping_notes = ShippingNote::where('status',1)->get();

        // $governorates = DB::table('governorates')->where('status', 1)->get();
        return view('FrontEnd.checkOut', compact('cart', 'days', 'minDate', 'daysOff', 'governorates','shipping_notes'));
    }

    public function getSubTypes($id)
    {
        // $areas = DB::table('areas')->where('status', 1)->where('governorate_id', $id)->get();
        $data = DB::table('shippings')
            ->join('areas', 'shippings.area_id', '=', 'areas.id')
            ->select(
                'areas.*',
            )
            ->where('areas.governorate_id', $id)
            ->where('shippings.status', 1)
            //->groupBy('areas.id', 'areas.area_en', 'areas.area_ar')
            ->get();
        return response()->json($data);
    }

    public function getShippingDetails($governorate_id, $area_id)
    {
        $shipping = DB::table('shippings')
            ->where('governorate_id', $governorate_id)
            ->where('area_id', $area_id)
            ->first();

        return response()->json($shipping);
    }

    public function storeOrder(Request $request)
    {
        DB::beginTransaction();

            $applied_coupon_custom=  session::get('applied_coupon_custom');
            if(isset($applied_coupon_custom)){


            if ($applied_coupon_custom['code']) {
                $value =  $this->increaseCoupons($applied_coupon_custom['code']);
                if ($value == false) {
                    return redirect()->back();
                }
            }
        }
            $cart = Session::get('cart_custom'); // Get the authenticated user's ID, defaulting to 1 if not authenticated
            $startDateString = $request->input('date'); // Get the date from the request
            $daysOff = DaySetting::where('status', 1)->pluck('name'); // Get days off from the database

            $startDate = Carbon::parse($startDateString);
            $endDate = $this->calculateEndDate($startDate, $cart[1]['duration_id'], $daysOff);

            $order = Order::create([
                'user_id' => auth()->user()->id,
                'total' => $cart[1]['total'],
                'program_id' => $cart[1]['program']->id,
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'vulnerability' => $cart[1]['allergic'],
                'duration_id' => $cart[1]['duration_id'],
                'notes' => $cart[1]['notes'],
                'unlike' => $cart[1]['dont_like'],
                'meals_id' => json_encode($cart[1]['all_meals']),
                'items_id' => json_encode($cart[1]['items']),
                'payment_method' => 'cash',
                'final_total' => $applied_coupon_custom['finaltotla']??$cart[1]['total'],
                'coupone_code'=> $applied_coupon_custom['code']??null,
                'coupont_decount'=>$applied_coupon_custom['discountAmount']??null
            ]);

            foreach ($request->address as $key => $address) {
                $address_details = $request->block[$key] . '-' . $request->street[$key] . '-' . $request->avenue[$key] . '-' . $request->house[$key] . '-' . $request->house[$key] . '-' . $request->apartment[$key];
                // dd($address_details);
                $newAddress = Address::create([
                    'governorate_id' => $request->governorates[$key],
                    'area_id' => $request->areas[$key],
                    'address' => $address,
                    'address_details' => $address_details,
                    'user_id' => $order->user_id,
                    'shipping_notes' => $request->shipping_notes[$key],
                ]);

                $order_days = new orderDayes();
                $order_days->order_id = $order->id;
                $order_days->address_id = $newAddress->id;
                if($request->anotherAddress=='yes'){

                if ($order_days) {
                    foreach ($request->days[$key] as $day) {
                        // Check if there's another orderDayes with the same order_id and $day already set to 1
                        $conflictingOrderDay = orderDayes::where('order_id', $order->id)
                            ->where($day, 1)
                            ->first();

                        if ($conflictingOrderDay) {

                            DB::rollBack();

                            Toastr::error(__('Try Again'), __('Error'));

                            return redirect()->back()->withInput();
                        } else {
                            $order_days->$day = 1;
                        }
                    }
                    $order_days->save();
                }
                }else{
                    $order_days->Monday = 1;
                    $order_days->Tuesday = 1;
                    $order_days->Wednesday = 1;
                    $order_days->Thursday = 1;
                    $order_days->Sunday = 1;
                    $order_days->Saturday = 1;
                    $order_days->Friday = 1;

                    $order_days->save();


                }

            }

            DB::commit();
            Session::forget('cart_custom');

            Session::forget('applied_coupon_custom');
            Toastr::success(__('scuccess'), __('success'));
            return redirect()->route('front.index');
            try {
            } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error(__('An error occurred. Please try again.'), __('Error'));
            return redirect()->back()->withInput();
        }
    }


    private function increaseCoupons($code)
    {

        try {
            DB::beginTransaction();

            $coupon = Coupons::
                where('code', '=', $code)
                ->whereColumn('limit_per_user', '>', 'user_get')
                ->lockForUpdate()
                ->first();

            if ($coupon) {
                // Update the user_get field
                $coupon->user_get += 1;
                $coupon->save();

                DB::commit();
                return true;
            } else {
                $this->action_coupone();

                // Coupon does not exist
                DB::rollBack();
                Toastr::error('invalid coupon', 'Error');

                return false;
            }
        } catch (\Throwable $th) {
            $this->action_coupone();
            DB::rollBack();
            Toastr::error('invalid coupon', 'Error');
            return false;
        }
    }

    private function calculateEndDate($startDate, $durationInWeeks, $daysOff)
    {
        // $startDate = $startDate->addDays(3); // Add 3 days to account for the initial closure period
        $daysToAdd = $durationInWeeks * 6; // Convert weeks to days
        $endDate = $startDate->copy();

        while ($daysToAdd > 1) {
            $endDate->addDay();
            $dayName = $endDate->format('l');

            // Skip the day if it's a day off
            if (!$daysOff->contains($dayName)) {
                $daysToAdd--;
            }
        }

        return $endDate;
    }
    public function login(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'phone' => ['required', 'string'],
            'password' => ['required', 'min:8'],
        ]);
        // Determine if the input is an email or phone and adjust rules accordingly
        try {
            // Perform validation
            if ($validator->fails()) {

                // Get all validation error messages
                $errorMessages = $validator->errors()->all();

                // Display each error message with Toastr
                foreach ($errorMessages as $errorMessage) {
                    Toastr::error($errorMessage, 'Error!!');
                }

                return redirect()->back()->withErrors($validator)->withInput();
            }

            $user = User::where('phone', $request->phone)->first();
            if ($user && (!Hash::check($request->password, $user->password))) {
                Toastr::error("invalid password", 'Error');
                return redirect()->back();
            }

            if (!$user) {
                Toastr::error("invalid data", 'Error');
                return redirect()->back();
            }
            Auth::login($user);


            Toastr::success(__('Successfully login User'), __('Success'));
            return redirect()->back();
        } catch (\Throwable $error) {
            Toastr::error("sorry please try again", 'Error');
            return redirect()->back();
        }
    }
    public function register(Request $request)
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
                Toastr::error($errorMessage, 'Error!!');
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

        Toastr::success("You Are Registered successfully", 'Success');
        return redirect()->back();
    }

    public function store_duration(Request $request)
    {
        Session::forget('cart_custom');
        // Fetch the program
        $program2 = Program::find($request->id);
        $userID = auth()->id() ?? 0; // Assuming you are using authentication and want to use the authenticated user ID

        if (!$program2) {
            return redirect()->back()->with('error', 'Program not found.');
        }
        $lang = App::getLocale();

        $cart_custom = Session::get('cart_custom') ?? []; // Get cart_custrom or default to empty array
        $programs_items = Program_Duration::where('program_id', $program2->id)
            ->where('duration_id', $request->duration_id)
            ->with('meal')
            ->get();

        $meals = [];
        $addons = [];
        $mealIds = [];

        foreach ($programs_items as $program) {



            if (!in_array($program->meal['id'], $mealIds)) {
                if ($program->meal['type'] == 1) {
                    $meals[] = [
                        'id' => $program->meal['id'],
                        'title' => $program->meal['title_' . $lang],
                        'calories' => $program->meal['calories_' . $lang],

                        'type' => $program->meal['type'],
                        'price' => $program->price
                    ];
                } else {
                    $addons[] = [
                        'id' => $program->meal['id'],
                        'title' => $program->meal['title_' . $lang],
                        'calories' => $program->meal['calories_' . $lang],
                        'type' => $program->meal['type'],
                        'price' => $program->price

                    ];
                }

                $mealIds[] = $program->meal['id']; // Track processed meal IDs
            }
        }
        $this->id_order = 1;


        $cart_custom[$this->id_order] = array(
            'id' => $this->id_order,
            'user_id' => $userID,
            'meals' => [],
            'addons' => [],
            'duration_id' => $request->duration_id,
            'program' => $program2,
            'total' => 0,
            'dont_like' => null,
            'allergic' => null,
            'items' => [],
            'all_meals' => null

        );
        Session::put('cart_custom', $cart_custom);
        return response()->json([
            'addons' => $addons,
            'meals' => $meals
        ]);
    }
    public function store_items(Request $request)
    {
        $cart = Session::get('cart_custom'); // Get the authenticated user's ID, defaulting to 1 if not authenticated
        //    $cart[1]['program']['min_meals'];


        $allItems = [];
        $cart[1]['meals'] = $request->meals;
        $cart[1]['addons'] = $request->addons;


        if (isset($cart[1])) {
            $meals = $request->meals ?? [];
            $addons = $request->addons ?? [];
            $allItems = array_merge($allItems, $meals, $addons);
        }

        $cart[1]['all_meals'] = $allItems;




        $durations = Program_Duration::where('program_id', $cart[1]['program']['id'])
            ->whereIn('meal_id',  $allItems)
            ->with('duration')
            ->selectRaw('duration_id, SUM(price) as price')
            ->where('duration_id', '=', $cart[1]['duration_id'])
            ->groupBy('duration_id')
            ->first();
        $cart[1]['total'] = $durations->price ?? 0;

        Session::put('cart_custom', $cart);

        return response()->json([
            'a' => $cart[1],
            'aa' =>      $cart[1]['program']['min_meals']
        ]);
    }




    public function apply_copon(Request $request)
    {


            $get_total_price=$this->get_total_price();
            $total=$get_total_price['total'];
            $cart_custrom = Session::get('cart_custom');


            $check = DB::table('coupons')
            ->where('code', $request->couponCode)
            ->where('status', '1')
            ->where('end_date', '>=', date('Y-m-d'))
            ->where('minimum_order', '<=', $total)
            ->whereColumn('limit_per_user', '>', 'user_get')
            ->where(function ($query) use ($cart_custrom) {
                $programId = $cart_custrom[1]['program']['id'];
                $query->whereRaw('JSON_CONTAINS(programs_ids, \'["' . $programId . '"]\')')
                      ->orWhereNull('programs_ids');
            })
            ->first();

            if ($check) {

              $this->action_coupone($check->code,$check->discount,$check->discount_type,$check->maximum_discount);

                return response()->json(['message' => 'valid coupon']);
            } else {
                $this->action_coupone();

                return response()->json(['message' => 'invalid coupon']);
            }
            try {     } catch (\Throwable $th) {

            return response()->json(['message' => 'invalid coupon']);

        }
    }
    public  function get_total_price()
    {
        $cart_custrom = Session::get('cart_custom');
        $totalAllOrders = 0;

            // Check if the order belongs to the user
                // Sum up the total for this order
                $orderTotal = $cart_custrom[1]['total'];
                $cart_custrom[1]['finaltotal'] = $orderTotal;
                Session::put('cart_custrom', $cart_custrom);

                // Add the order total to the overall total



        $data = ['total' => $orderTotal,'finaltotal'=>$orderTotal];

        return $data;
    }






    public function action_coupone($code = null, $discount = null, $discount_type = null, $maximum_discount = null)
    {
        try {


            $data = $this->get_total_price();
            session::forget('applied_coupon_custom');

            if ($code == null && $discount == null && $discount_type == null) {
                session(['applied_coupon_custom' => [
                    'total' => intval($data['total']),
                    'code' => null,
                    'discountAmount' => 0,
                    'finaltotla' => $data['finaltotal'],

                ]]);
                return true;
            } else {

                if ($discount_type == 1) {
                    $result = $this->calcdiscount($data['finaltotal'], $discount, $maximum_discount);

                    session(['applied_coupon_custom' => [
                        'total' => $data['total'],
                        'code' => $code,
                        'discountAmount' =>$result['discountAmount'],
                        'finaltotla' => $result['finaltotal'],
                    ]]);

                    return true;
                } else {
                    $finaltotal = $data['finaltotal'] - $discount;
                    session(['applied_coupon_custom' => [
                        'total' => $data['total'],
                        'code' => $code,
                        'discountAmount' => $discount,
                        'finaltotla' => $finaltotal,

                    ]]);
                    return true;
                }
            }
        } catch (\Throwable $th) {
            session(['applied_coupon_custom' => [
                'total' => $data['total'],
                'code' => null,
                'discountAmount' => 0,
                'finaltotla' => $data['finaltotla'],

            ]]);
            return true;
        }
    }

    public function calcdiscount($total, $discount, $maximum_discount)
    {

        $price_check = $total - ($total * ($discount / 100));
        $price_discount = $total - $price_check;

        if ($price_discount < $maximum_discount) {
            $finaltotal = $price_check;

            $discountAmount = $this->foramt_num($price_discount);
        } else {

            $finaltotal =  $total - $maximum_discount;

            $discountAmount = $this->foramt_num($maximum_discount);

        }

        $result = ['finaltotal' => $finaltotal, 'discountAmount' => $discountAmount];
        return $result;
    }
    public function foramt_num($data)
    {

        $result = round($data, 2);
        $result = number_format($result, 2, '.', '');
        return $result;
    }
}
