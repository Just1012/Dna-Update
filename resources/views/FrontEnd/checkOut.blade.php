@extends('layouts.front')
@section('title', trans('messages.checkout'))
@push('css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endpush
@section('content')
    @include('layouts.ex_front.header')
    <style>
        .flash {
            animation: flash 0.9s ease-in-out infinite;
        }

        @keyframes flash {
            0% { opacity: 1; }
            50% { opacity: 0.5;  }
            100% { opacity: 1; }
        }
        #date {
            width: 250px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .ui-date {
            background: #fff;
            border: 1px solid #ccc;
            padding: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .ui-date-header {
            background: #f7f7f7;
            border-bottom: 1px solid #ddd;
        }

        .ui-date-title {
            font-weight: bold;
        }

        .ui-date .ui-date-prev,
        .ui-date .ui-date-next {
            top: 1px;
        }

        .ui-state-disabled {
            color: #ccc !important;
            pointer-events: none;
        }

        .ui-widget-content .ui-state-disabled {
            background: #f7f7f7 !important;
        }

        .form-control:focus {
            color: #212529;
            background-color: #fff;
            border-color: transparent !important;
            outline: 0;
            box-shadow: 0 0 0 0 transparent !important;
        }
    </style>

    <div class="checkout">
        <div class="container">
            <div class="content d-flex align-items-start flex-wrap">
                <div class="details">

                    <h5 class="mb-3 fw-bold">{{ trans('messages.products_details') }}</h5>
                    <div class="items">

                        <div class="items_meal d-flex justify-content-start align-items-center gap-3 flex-wrap">
                            @foreach ($cart[1]['all_meals'] as $meal)
                                @php
                                    $meal = App\Models\Meal::where('id', $meal)->first();
                                @endphp

                                <div class="item" style="flex: 0 0 48%">
                                    <div class="image">
                                    </div>
                                    <div class="info d-flex justify-content-between align-items-center w-100">
                                        <div class="content">
                                            <h4 class="name m-0">{{ $meal->{'title_' . App::getLocale()} }}</h4>
                                            <span>
                                                @if ($meal->type == 1)
                                                    {{ trans('messages.main_meal') }}
                                                @else
                                                    {{ trans('messages.sub_meal') }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @php
                            $duration = App\Models\Duration::where('id', $cart[1]['duration_id'])->first();
                            $symble=\App\Utils\helper::currency();

                        @endphp
                        <hr class="m-0" />

                        <div class="item align-items-center mt-3">
                            <div class="icon">
                                <i style="font-size: 30px;color:#295E4E;" class="fa-regular fa-clock"></i>
                            </div>
                            <div class="info d-flex justify-content-between align-items-center w-100">
                                <h5 class="name">{{ $duration->title_en }}</h5>
                                <h5 class="price">{{ $cart[1]['total'] }} {{$symble}}</h5>
                            </div>
                        </div>
                        <hr class="m-0" />
                        <h5 class="mt-3 fw-bold">{{ trans('messages.items_you_dont_like') }}</h5>
                        <div class="item">
                            <div class="info d-flex justify-content-between align-items-center w-100">
                                <p class="name m-0">{{ $cart[1]['dont_like'] }}</p>
                            </div>
                        </div>
                        <hr class="m-0" />
                        <h5 class="mt-3 fw-bold">{{ trans('messages.items_that_make_you_allergic') }}</h5>
                        <div class="item">
                            <div class="info d-flex justify-content-between align-items-center w-100">
                                <p class="name m-0">{{ $cart[1]['allergic'] }}</p>
                            </div>
                        </div>
                        <hr class="m-0" />

                        <h5 class="mt-3 fw-bold">{{ trans('messages.note_checkout') }}</h5>
                        <div class="item">
                            <div class="info d-flex justify-content-between align-items-center w-100">
                                <p class="name m-0">{{ $cart[1]['notes'] }}</p>
                            </div>
                        </div>
                        <hr class="m-0" />

                        <h5 class="my-3 fw-bold">{{ trans('messages.items_dont_like') }} </h5>
                        <div class="items_notLike d-flex justify-content-start align-items-center gap-3 flex-wrap">
                            @if (isset($cart[1]['items']))

                                @foreach ($cart[1]['items'] as $item)
                                    @php
                                        $item = App\Models\Item::where('id', $item)->first();
                                    @endphp
                                    @if ($item)
                                        <div class="item" style="flex: 0 0 30%">
                                            <div class="image" style="max-width: 50px">
                                                <img src="{{ asset('images/' . $item->image) }}" alt="">
                                            </div>
                                            <div class="info d-flex justify-content-between align-items-center w-100">
                                                <h5 class="name m-0">{{ $item->{'title_' . App::getLocale()} }}</h5>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                        </div>

                    </div>
                    <hr class="m-0">
                    <div class="total d-flex justify-content-between align-items-center w-100 mt-4">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="name d-inline-block">{{ trans('messages.subtotal') }}:</h5>
                                    <h6 class="subtotal d-inline-block" id="subtotal">{{ $cart[1]['total'] }} {{$symble}}</h6>
                                </div>
                                <div class="col-12">
                                    <h5 class="name d-inline-block">code:</h5>
                                    <h6 class="subtotal d-inline-block" id="code">{{ session('applied_coupon_custom.code', '') }} </h6>
                                </div>
                                <div class="col-12">
                                    <h5 class="name d-inline-block">Discount:</h5>
                                    <h6 class="subtotal d-inline-block" id="total">  {{session('applied_coupon_custom.discountAmount','0' ) }} {{$symble}}</h6>
                                </div>
                                <div class="col-12">
                                    <h5 class="name d-inline-block">{{ trans('messages.total') }}:</h5>
                                    <h6 class="subtotal d-inline-block" id="total">  {{session('applied_coupon_custom.finaltotla',$cart[1]['total'] ) }} {{$symble}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="m-0">

                    <div class=" my-3 flash"id="promoText" style="background: transparent">
                        <div class="text-start ">
                            <h6  >Have a <span class="fw-semibold">promo</span> code ?</h6>
                        </div>
                        <div class="hstack mx-n3">
                            <input class="form-control" id="couponCode" type="text" name="couponCode" placeholder="Enter coupon code"  aria-label="Add Promo Code here...">
                            <button type="button" class="btn btn-secondary w-xs my-1 " id="applyCoupon">Apply</button>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div id="addModals" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 overflow-hidden">
                            <div class="modal-header p-3">
                                <h4 class="card-title mb-0">{{ trans('messages.you_have_to_sign') }}</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="signinForm" style="max-width: 100%"
                                    action="{{ route('front.checkout.login.store') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    <h3 class="text-center fw-bolder mb-4">{{ trans('messages.login_now') }}</h3>
                                    <div class="container">
                                        <label for="signin-phone">{{ trans('messages.phone_number') }}</label>
                                        <div class="phone_inputs w-100">
                                            <div class="input">
                                                <span class="code">
                                                    <img src="{{ asset('front/images/الكويت.jpeg') }}" alt="#">
                                                    +965
                                                </span>
                                                <input type="number" name="phone" id="signin-phone" inputmode="numeric"
                                                    pattern="[0-9]" required max="99999999">
                                            </div>
                                        </div>
                                        <div class="inputs">
                                            <label for="signin-password">{{ trans('messages.password') }}</label>
                                            <input name="password" type="password" id="signin-password" required>
                                        </div>
                                        <input type="submit" value="Login" class="mb-4">
                                        <p class="text-center any_account log w-100">
                                            {{ trans('messages.don’t_have_an_account') }} <span
                                                style="cursor:pointer;color: #295E4E;"
                                                onclick="toggleForm('signup')">{{ trans('messages.sign_up') }}</span>
                                        </p>
                                    </div>
                                    <div id="durationContainer"></div>
                                </form>

                                <form id="signupForm" style="max-width: 100%"
                                    action="{{ route('front.checkout.register.store') }}" method="POST">
                                    @csrf
                                    <h3 class="text-center fw-bolder mb-4">{{ trans('messages.register') }}</h3>
                                    <div class="container">
                                        <div class="name_inputs">
                                            <div class="input">
                                                <label for="signup-fName">{{ trans('messages.first_name') }}</label>
                                                <input type="text" name="f_name" id="signup-fName" required>
                                            </div>
                                            <div class="input">
                                                <label for="signup-lName">{{ trans('messages.last_name') }}</label>
                                                <input type="text" name="l_name" id="signup-lName" required>
                                            </div>
                                        </div>
                                        <label for="signup-phone">{{ trans('messages.phone_no') }}</label>
                                        <div class="phone_inputs">
                                            <div class="input">
                                                <span class="code">
                                                    <img src="{{ asset('front/images/الكويت.jpeg') }}" alt="#">
                                                    +965
                                                </span>
                                                <input type="number" id="signup-phone" name="phone"
                                                    inputmode="numeric" pattern="[0-9]" required max="99999999">
                                            </div>
                                        </div>
                                        <div class="password_inputs">
                                            <div class="input">
                                                <label for="signup-password">{{ trans('messages.password') }}</label>
                                                <input type="password" name="password" id="signup-password" required>
                                            </div>
                                            <div class="input">
                                                <label
                                                    for="signup-Cpassword">{{ trans('messages.confirm_password') }}</label>
                                                <input type="password" name="password_confirmation" id="signup-Cpassword"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="check_input">
                                            <input type="checkbox" name="" id="signup-check" required>
                                            <label for="signup-check"
                                                class="m-0">{{ trans('messages.i_agree_with_the_terms_of_use') }}</label>
                                        </div>
                                        <input type="submit" value="{{ trans('messages.register') }}">
                                        <p class="text-center any_account w-100 mt-4">
                                            {{ trans('messages.already_have_an_account') }} <span
                                                style="cursor:pointer;color: #295E4E;"
                                                onclick="toggleForm('signin')">{{ trans('messages.sign_in') }}</span>
                                        </p>
                                    </div>
                                    <div id="durationContainer"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal -->

                @auth

                    <div class="form">
                        <form action="{{ route('front.storeOrder') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="info">
                                <h3>{{ trans('messages.shipping_information') }}</h3>
                                <div class="container input">
                                    <h3>{{ trans('messages.start_date') }}</h3>
                                    <input placeholder="DD/MM/YY" class="form-control w-100" name="date" type="text"
                                        id="date" required class="rounded">
                                </div>
                                <div class="col-md-12">
                                    <h3  class="mt-4 mb-0">Do you have more than one address?</h3>

                                    <div class="inputs_radio d-flex gap-5">
                                        <div class="input d-flex justify-content-start gap-1 align-items-center">
                                            <input type="radio" id="anotherAddressYes" name="anotherAddress" value="yes">
                                            <label for="anotherAddressYes">Yes</label>
                                        </div>
                                        <div class="input d-flex justify-content-start gap-1 align-items-center">
                                            <input type="radio" id="anotherAddressNo"  name="anotherAddress" value="no">
                                            <label for="anotherAddressNo">No</label>
                                        </div>
                                    </div>
                                </div>


                                <div class="container mt-5" id="continer_shipping" style="display: none;">
                                    <div id="template" class="repeater-block">
                                        <h3 class="mt-4 mb-0">{{ trans('messages.address') }}</h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select onchange="toggleInput(this)" name="governorates[]"
                                                    class="form-control type-select mb-1">
                                                    <option disabled selected value="">
                                                        {{ trans('messages.select_governorates') }}</option>
                                                    @foreach ($governorates as $value)
                                                        <option value="{{ $value->governorate_id }}">
                                                            {{ $value->governorate_name_en }} /
                                                            {{ $value->governorate_name_ar }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <select class="form-control subType-select" name="areas[]">
                                                    <option disabled selected value="">
                                                        {{ trans('messages.select_area') }}</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <textarea placeholder="{{ trans('messages.block') }}" name="block[]" cols="30" rows="10"
                                                    class="w-100 mt-2 rounded p-2" style="height: 50px; outline:none; border:1px solid #eee"></textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <textarea placeholder="{{ trans('messages.street') }}" name="street[]" cols="30" rows="10"
                                                    class="w-100 mt-2 rounded p-2" style="height: 50px; outline:none; border:1px solid #eee"></textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <textarea placeholder="{{ trans('messages.avenue') }}" name="avenue[]" cols="30" rows="10"
                                                    class="w-100 mt-2 rounded p-2" style="height: 50px; outline:none; border:1px solid #eee"></textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <textarea placeholder="{{ trans('messages.house') }}" name="house[]" cols="30" rows="10"
                                                    class="w-100 mt-2 rounded p-2" style="height: 50px; outline:none; border:1px solid #eee"></textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <textarea placeholder="{{ trans('messages.floor') }}" name="floor[]" cols="30" rows="10"
                                                    class="w-100 mt-2 rounded p-2" style="height: 50px; outline:none; border:1px solid #eee"></textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <textarea placeholder="{{ trans('messages.apartment') }}" name="apartment[]" cols="30" rows="10"
                                                    class="w-100 mt-2 rounded p-2" style="height: 50px; outline:none; border:1px solid #eee"></textarea>
                                            </div>
                                        </div>

                                        <textarea placeholder="{{ trans('messages.address_note') }}" name="address[]" cols="30" rows="10"
                                            class="w-100 mt-2 rounded p-2" style="height: 100px; outline:none; border:1px solid #eee"></textarea>

                                        <div class="col-md-12">
                                            <select name="shipping_notes[]" class="form-control type-select1 mb-1">
                                                <option disabled selected value="">
                                                    {{ trans('messages.select_shipping_note') }}</option>
                                                @foreach ($shipping_notes as $value)
                                                    <option value="{{ $value->id }}">
                                                        {{ App::getLocale() == 'ar' ? $value->shipping_note_ar : $value->shipping_note_en }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="shipping-details mt-3" style="display: none;">
                                            <h6>{{ trans('messages.shipping_details') }}</h6>
                                            <p style="margin-top: 5px !important;">{{ trans('messages.shipping_time') }}:
                                                <span class="shipping-time"></span>
                                            </p>
                                        </div>

                                        <div class="input_checkBoxs" id="days_off_radio" style="display: none;">
                                            <h3 class="mt-4 mb-0">{{ trans('messages.select_days') }}</h3>
                                            <div style="column-gap: 34px;" class="input_checkboxs1 d-flex flex-wrap">
                                                @foreach ($days as $key => $day)
                                                    <div class="input d-flex justify-content-start gap-1 align-items-center">
                                                        <input type="checkbox" id="day_{{ $key }}" name="days[0][]"
                                                            value="{{ $day->name }}">
                                                        <label class="m-0"
                                                            for="day_{{ $key }}">{{ $day->name }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-12">
                                                <button type="button"  style="display: none;" id="btn-remove"
                                                    class="btn btn-danger remove-button mt-2">{{ trans('messages.remove') }}</button>
                                            </div>
                                        </div>

                                    </div>
                                    <button type="button" id="add-button" style="display: none;"
                                        class="btn btn-primary add-button mt-2">{{ trans('messages.add_form') }}</button>
                                </div>


                                <div class="payment">
                                    <h3 class="mt-4 mb-0">{{ trans('messages.payment_method') }}</h3>
                                    <div class="inputs_radio d-flex gap-5">
                                        <div class="input d-flex justify-content-start gap-1 align-items-center">
                                            <input type="radio" id="Cash" name="payment_method" value="Cash"
                                                checked>
                                            <label class="m-0" for="Cash">{{ trans('messages.cash') }}</label>
                                        </div>
                                        <div class="input d-flex justify-content-start gap-1 align-items-center">
                                            <input type="radio" id="Online" name="payment_method" value="Online">
                                            <label class="m-0" for="Online">{{ trans('messages.online') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <input type="submit" value="{{ trans('messages.pay') }}" class="submit rounded mb-5">
                            </div>
                        </form>


                    </div>

                @endauth

                @guest
                    <div class="form">
                        <div style="margin-top:200px;" class="info text-center">
                            <label style="display: block; opacity: 0.7; font-weight: bold; margin-bottom: 20px;">
                                {{ trans('messages.you_have_to_sign') }}
                            </label>
                            <span class="btn btn-dark rounded mb-5"
                                style="width: 80%; background-color: #295E4E; border:none;" data-bs-toggle="modal"
                                data-bs-target="#addModals">{{ trans('messages.login_or_register') }}
                            </span>
                        </div>
                    </div>
                @endguest

            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
        $('#applyCoupon').on('click', function() {

            var couponCode = $('#couponCode').val();
            $.ajax({
                url: '{{ route("apply.coupon") }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    couponCode: couponCode
                },
                success: function(response) {
                    console.log(response);

                    // Handle the response if needed
                    if(response.message=='valid coupon'){
                        setTimeout(function() {
                            location.reload(); // Reload the page after 5 seconds
                        }, 1000); // 5000 milliseconds = 5 seconds
                       // location.reload(); // Use location.reload() instead of window.reload()




                toastr.success('Valid coupon', 'Success!!');
                    }else{
                        toastr.error('Invalid coupon', 'Error!!');
                        setTimeout(function() {
                            location.reload(); // Reload the page after 5 seconds
                        }, 1000); // 5000 milliseconds = 5 seconds
                    }



                    // Refresh the page after a successful response
                    console.log(response);
                },
                error: function(error) {
                    console.error('Error applying coupon:', error);
                }
            });
        });
    });
      $(document).ready(function() {
            // Function to check the selected radio button
            function checkRadioValue() {
                var checkedValue = $('input[name="anotherAddress"]:checked').val();
                var btnRemove = $('#btn-remove');
                var btnAdd = $('#add-button');
                var daysOffRadio = $('#days_off_radio');
                var continer_shipping=$('#continer_shipping');

                if (checkedValue == 'yes') {
            btnRemove.show();
            btnAdd.show();
            daysOffRadio.show();
            continer_shipping.show();
        } else {
            btnRemove.hide();
            btnAdd.hide();
            daysOffRadio.hide();
            continer_shipping.show();

        }
            }

            // Event listener for changes on radio buttons
            $('input[name="anotherAddress"]').change(function() {
                checkRadioValue(); // Call the function to check the selected value
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const daysOff = @json($daysOff);
            const addButton = document.getElementById('add-button');
            const template = document.getElementById('template');
            const container = template.parentNode;

            let selectedDays = new Set();

            function isDayOff(date) {
                const dayName = date.toLocaleString('en-US', {
                    weekday: 'long'
                });
                return daysOff.includes(dayName);
            }

            function initializeDatePicker(input) {
                input.addEventListener('input', function() {
                    const selectedDate = new Date(this.value);
                    if (isDayOff(selectedDate)) {
                        toastr.error(
                            `${selectedDate.toLocaleString('en-US', { weekday: 'long' })} is a day off. Please choose another date.`
                        );
                        this.value = '';
                    }
                });

                const maxDay = new Date();
                maxDay.setDate(maxDay.getDate() + 60);
                const today = new Date();
                today.setDate(today.getDate() + 3);

                let dayName = today.toLocaleString('en-US', {
                    weekday: 'long'
                });

                while (isDayOff(today)) {
                    today.setDate(today.getDate() + 1);
                    dayName = today.toLocaleString('en-US', {
                        weekday: 'long'
                    });
                }

                input.min = today.toISOString().split('T')[0];

                $(function() {
                    $("#date").datepicker({
                        maxDate: maxDay,
                        minDate: today,
                        beforeShowDay: function(date) {
                            let day = date.getDay();
                            let disableDay = daysOff.some(dayOff => day === getDayNumber(
                                dayOff));
                            return [!disableDay, ''];
                        }
                    });

                    function getDayNumber(dayName) {
                        const daysOfWeek = {
                            'Sunday': 0,
                            'Monday': 1,
                            'Tuesday': 2,
                            'Wednesday': 3,
                            'Thursday': 4,
                            'Friday': 5,
                            'Saturday': 6
                        };
                        return daysOfWeek[dayName] !== undefined ? daysOfWeek[dayName] : -1;
                    }
                });
            }

            function updateSelectedDays() {
                selectedDays = new Set();
                document.querySelectorAll('.repeater-block input[type="checkbox"]:checked').forEach(checkbox => {
                    selectedDays.add(checkbox.value);
                });
            }

            function toggleSelectedDays() {
                document.querySelectorAll('.repeater-block').forEach(block => {
                    block.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                        if (selectedDays.has(checkbox.value)) {
                            checkbox.disabled = true;
                            if (checkbox.checked) {
                                checkbox.disabled = false;
                            }
                        } else {
                            checkbox.disabled = false;
                        }
                    });
                });
            }

            const dateInput = document.getElementById('date');
            initializeDatePicker(dateInput);

            let blockCount = 1;

            function addFormBlock() {
                const newBlock = template.cloneNode(true);
                newBlock.removeAttribute('id');
                container.insertBefore(newBlock, addButton);

                const textarea = newBlock.querySelector('textarea');
                textarea.value = '';

                const checkboxes = newBlock.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach((checkbox, index) => {
                    updateSelectedDays();
                    toggleSelectedDays();
                    const newId = `day_${blockCount}_${index}`;
                    checkbox.setAttribute('id', newId);
                    checkbox.setAttribute('name', `days[${blockCount}][]`);
                    checkbox.checked = false;
                    checkbox.nextElementSibling.setAttribute('for', newId);
                });

                blockCount++;

                const newDateInput = newBlock.querySelector('#date');
                newDateInput.style.display = 'none'; // Hide date input initially

                const removeButton = newBlock.querySelector('.remove-button');
                removeButton.addEventListener('click', function() {
                    newBlock.remove();
                    updateSelectedDays();
                    toggleSelectedDays();
                });

                checkboxes.forEach((checkbox) => {
                    checkbox.addEventListener('change', function() {
                        if (checkbox.checked) {
                            newDateInput.style.display =
                                'block'; // Show date input if checkbox is selected
                        } else {
                            newDateInput.style.display =
                                'none'; // Hide date input if checkbox is deselected
                        }
                    });
                });

                updateSelectedDays();
                toggleSelectedDays();
            }

            addButton.addEventListener('click', addFormBlock);

            $(document).on('click', '.remove-button', function() {
                if ($('.repeater-block').length > 1) {
                    $(this).closest('.repeater-block').remove();
                    updateSelectedDays();
                    toggleSelectedDays();
                } else {
                    toastr.error('You must have at least one address block.', 'Error !');
                }
            });

            $(document).ready(function() {
                function updateShippingDetails(governorateId, areaId, shippingDetailsElement) {
                    var shippingDetailsUrl =
                        "{{ route('front.shipping', ['governorate_id' => ':governorate_id', 'area_id' => ':area_id']) }}";
                    shippingDetailsUrl = shippingDetailsUrl.replace(':governorate_id', governorateId)
                        .replace(':area_id', areaId);

                    $.ajax({
                        url: shippingDetailsUrl,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            if (data) {
                                shippingDetailsElement.show();
                                shippingDetailsElement.find('.shipping-time').text(data
                                    .shipping_time);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching shipping details: ", error);
                        }
                    });
                }

                document.addEventListener('change', function(event) {
                    if (event.target.type === 'checkbox') {
                        updateSelectedDays();
                        toggleSelectedDays();
                    }
                });

                $(document).on('change', '.type-select', function() {
                    var governorateId = $(this).val();
                    var subcategoriesUrl = "{{ route('front.area', ['id' => ':area']) }}";
                    subcategoriesUrl = subcategoriesUrl.replace(':area', governorateId);
                    var subTypeSelect = $(this).closest('.repeater-block').find('.subType-select');
                    var shippingDetailsElement = $(this).closest('.repeater-block').find(
                        '.shipping-details');

                    // Reset shipping details when governorate is changed
                    shippingDetailsElement.hide();
                    shippingDetailsElement.find('.shipping-time').text(' ');

                    $.ajax({
                        url: subcategoriesUrl,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            subTypeSelect.empty().append(
                                '<option disabled selected value="">{{ trans('messages.select_area') }}</option>'
                            );
                            if (data && data.length > 0) {
                                $.each(data, function(index, subType) {
                                    var subTypeOption = $('<option>', {
                                        value: subType.id,
                                        text: subType.area_en
                                    });
                                    subTypeSelect.append(subTypeOption);
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching subcategories: ", error);
                        }
                    });
                });

                $(document).on('change', '.subType-select', function() {
                    var governorateId = $(this).closest('.repeater-block').find('.type-select')
                        .val();
                    var areaId = $(this).val();
                    var shippingDetailsElement = $(this).closest('.repeater-block').find(
                        '.shipping-details');

                    // Reset shipping details when area is changed
                    shippingDetailsElement.hide();
                    shippingDetailsElement.find('.shipping-time').text(' ');

                    updateShippingDetails(governorateId, areaId, shippingDetailsElement);
                });
            });

        });
    </script>
    <script>
           document.addEventListener('DOMContentLoaded', function() {
            var promoText = document.getElementById('promoText');
            var couponCode = $('#couponCode');
            function applyFlash() {
                promoText.classList.remove('flash');
                void promoText.offsetWidth; // trigger reflow
                promoText.classList.add('flash');
            }

            applyFlash(); // Apply flash effect on document ready

            // Check if the input element has focus
            var hasFocus = $('#couponCode').is(':focus');
            if (hasFocus) {
                promoText.classList.remove('flash');
            } else {
                applyFlash();
            }

            // Add focus event to input
            $('#couponCode').focus(function() {
                promoText.classList.remove('flash');
            });

            // Add click event to the document
            $(document).click(function(event) {
                // Check if the click was inside the couponCode input field
                if (!$(event.target).is('#couponCode') && (!couponCode.val() || couponCode.val().trim() === '')) {
                    applyFlash();
                }
            });

            // Add click event to apply button
            $('#applyCoupon').click(function() {
                applyFlash();
            });
        });
        function toggleForm(form) {
            const signinForm = document.getElementById('signinForm');
            const signupForm = document.getElementById('signupForm');

            if (form === 'signin') {
                signinForm.style.display = 'block';
                signupForm.style.display = 'none';
            } else {
                signinForm.style.display = 'none';
                signupForm.style.display = 'block';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            toggleForm('signin'); // Default to show Sign In form
        });

        let inputsPhone = document.querySelectorAll('input[type="number"]');
        inputsPhone.forEach((inputPhone) => {
            inputPhone.addEventListener('input', () => {
                if (inputPhone.value.length > 8) {
                    inputPhone.value = inputPhone.value.slice(0, 8);
                }
            });

            inputPhone.addEventListener('focusin', () => {
                inputPhone.closest('.phone_inputs').style.border = '1px solid #295E4E';
            });

            inputPhone.addEventListener('focusout', () => {
                inputPhone.closest('.phone_inputs').style.border = '1px solid #33333378';
            });
        });
    </script>
@endpush
