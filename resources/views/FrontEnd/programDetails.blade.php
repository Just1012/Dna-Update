@extends('layouts.front')
@section('title', App::getLocale() == 'ar' ? $programsDetails->title_ar : $programsDetails->title_en)
@push('css')
    <style>



        body {
    background-color: #e4e4e6;
    font-family: "Cairo", sans-serif;
}

.cairo-custom-body {
    font-family: "Cairo", sans-serif;
    font-optical-sizing: auto;
    font-weight: 400; /* Example weight value, adjust as needed */
    font-style: normal;
    font-variation-settings: "slnt" 0;
}
        .myshadow {
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }

        .program_details {
            padding: 20px 0;
        }

        .program_details .container {
            /* max-width: 1140px; */
            margin: auto;
        }

        .program_details .glass-effect {
            background: rgba(41, 94, 78, 0.6);
            /* Added transparency */
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(41, 94, 78, 0.8);
        }

        .program_details .details {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .program_details .info {
            display: flex;
            align-items: center;
        }

        .program_details .program-image {
            max-width: 100px;
            height: auto;
            border-radius: 10px;
            margin-right: 15px;
        }

        .program_details .program-title {
            font-size: 1.5rem;
            font-weight: 700;
            /* color: #333;*/
            color: white;
            margin: 10px;
        }

        .details_2 {
            width: 83%;
        }

        @media (max-width: 767px) {
            .program_details .details {
                flex-direction: column;
                align-items: flex-start;
            }

            .program_details .program-image {
                max-width: 80px;
                margin-bottom: 10px;
            }

            .program_details .program-title {
                font-size: 1.25rem;
            }
        }

        .tiles_radio label {
            display: flex;
            align-items: center;
            padding: 10px;
            background: #fff;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .tiles_radio label:hover {
            background: rgba(41, 94, 78, 0.7);
            color: #fff;
        }

        .tiles_radio input[type="radio"] {
            display: none;
        }

        .tiles_radio input[type="radio"]:checked+label {
            background: rgba(41, 94, 78);
            color: #fff;
            font-weight: bold;
        }

        .form-check img {
            width: 100%;
            border-radius: 5px;
        }

        .order-summary {
            background: #fff;
            border-radius: 5px;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
            padding: 20px;
        }

        .order-summary h5 {
            font-weight: bold;
        }

        .details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .info img {
            border-radius: 5px;
        }

        .info .text-center {
            margin: 10px 0;
        }

        @media (max-width: 767px) {
            .order-summary {
                margin-top: 20px;
            }

            .details_2 {
                width: 95%;
            }
        }

        @media (max-width:1024) {
            .details_2 {
                width: 100%;
                background: #000;
            }
        }

        .form-check-input.d-none {
            display: none;
        }

        /* Style the label to look like a button */
        .meal-label {
            cursor: pointer;
            display: block;
            text-align: center;
            border: 2px solid transparent;
            padding: 10px;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }

        /* Style the label when the corresponding checkbox is checked */
        .form-check-input.d-none:checked+.meal-label {
            box-shadow: rgba(117, 16, 16, 0.1) 0px 4px 12px;
            background: rgba(41, 94, 78, 0.6);
            border: 1px solid rgba(41, 94, 78, 0.8);
            color: #fff;
        }

        /* Add some style to the meal image */
        .meal-image {
            border-radius: 5px;
        }
    </style>
@endpush
@section('content')
    @include('layouts.ex_front.header')
    <div class="program_details py-4">
        <div class="container">
            <div class="glass-effect p-4 rounded">
                <div class="details">
                    <div class="info d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <img src="{{ asset('images/' . $programsDetails->image) }}" alt=""
                                    class="img-fluid program-image">
                            </div>
                            <h3 class="program-title">
                                {{ App::getLocale() == 'ar' ? $programsDetails->title_ar : $programsDetails->title_en }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="col-12 bg-light py-4 rounded myshadow p-4">
            <div class="row">
                <div class="mb-4">
                    <h4 class="title">{{ trans('messages.please_select_duration') }}</h4>
                </div>
                <div class="row tiles_radio">
                    @foreach ($durations as $key=>$duration)
                        <div class="col-md-3 col-6 my-2">
                            <div>
                                <input type="radio" {{$key==0?'checked':''}} onchange="changeDuration(this)"
                                    id="duration{{ $duration['duration_id'] ?? 0 }}" name="duration"
                                    value="{{ $duration['duration_id'] ?? 0 }}">
                                <label for="duration{{ $duration['duration_id'] ?? 0 }}"
                                    class="d-flex align-items-center p-2">
                                    <i class="fa-regular fa-clock me-2"></i>
                                    @php
                                        $name = 'title_' . App::getLocale();
                                    @endphp
                                    <h6 class="m-0">{{ $duration->duration->$name ?? 0 }}</h6>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @php
        $card = session('cart_custom', '0');
        $symble=\App\Utils\helper::currency();
    @endphp
    <div class="container my-4">
        <div class="col-12">
            <div class="row">
                <div class="col-md-9">
                    <div id="loading" class="bg-white" style="display:none; text-align: center;">
                        <img src="{{ asset('web/assets/images/loading1.gif') }}" alt="Loading..." />

                    </div>
                    <div class="myshadow p-4 bg-white rounded" id="my_card" style="display:none;">

                        <!-- * Step 1 start -->
                        <form id="programForm" action="{{ route('front.store.items') }}" method="post">
                            @csrf
                            <div>
                                <div class="mb-4">
                                    <h4 class=" d-inline">{{ trans('messages.meals') }} </h4>
                                    <p class="text-danger  d-inline d-block" id="you_message">You Must select at least
                                        {{ $programsDetails->min_meals }} meals</p>
                                </div>
                                <div class="row" id="meals-container">
                                    <!-- Meals will be populated here -->
                                </div>
                                <div class="mb-4">
                                    <h4 class="h4">{{ trans('messages.addons') }}</h4>
                                </div>
                                <div class="row" id="addons-container">
                                    <!-- Addons will be populated here -->
                                </div>
                                <div class="btns" id="button_submit">
                                    <button class="btn" disabled
                                        style=" box-shadow: rgba(117, 16, 16, 0.1) 0px 4px 12px;
                                        background: rgba(41, 94, 78, 0.6);
                                        border: 1px solid rgba(41, 94, 78, 0.8);
                                        color: #fff;">{{ trans('messages.next_step') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!-- Step 1 end -->
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-md-3">
                    <div class="order-summary myshadow p-4">

                        <h5>{{ trans('messages.order_summary') }}</h5>
                        <div>
                            <p>{{ trans('messages.meals') }}: <span id="main_course">0</span></p>
                            <p>{{ trans('messages.addons') }}: <span id="extra">0</span></p>
                            <hr>
                            <p>{{ trans('messages.total') }}: <span id="total">0</span> {{$symble}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection
@push('js')
    <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
           $(document).ready(function(){
        // On document ready, get the selected duration radio button
        var selectedDuration = document.querySelector('input[name="duration"]:checked');
        if (selectedDuration) {
            // If there's a selected duration, trigger the changeDuration function
            changeDuration(selectedDuration);
        }
    });
        function changeDuration(element) {
            var id = {{ $programsDetails->id }};
            var durationId = element.value;
            $('#loading').show();
            $('#my_card').hide();


            $.ajax({
                url: '{{ route('front.programDuration_store') }}', // Update this with your route for handling duration change
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    duration_id: durationId,
                    'id': id
                },
                success: function(response) {
                    // Handle the response here
                    $('#loading').hide();
                    $('#my_card').show();

                    $('#total').text(0);

                    populateMealsAndAddons(response);
                },
                error: function(xhr) {
                    $('#loading').hide();
                    $('#my_card').show();
                    // Handle errors here
                }
            });
        }

        function populateMealsAndAddons(data) {
            // Clear existing content
            $('#meals-container').empty();
            $('#addons-container').empty();
            var min= {{$programsDetails->min_meals}};

            // Populate meals
         // Populate meals
            data.meals.forEach(function(meal, index) {
                console.log(meal);

                $('#meals-container').append(`

                   <div class="col-md-3 col-6 mb-4">
                        <div class="" style="">
                        <div class="header text-center text-dark" style="background:#fff;box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;">
                        <p>${meal.calories} <img src="{{ asset('web/calories.png') }}" style="width:20px; height:20px; ">
                        </p>
                        </div>
                        <div class="mx-auto col-12">
                          <div class="" style="">
                                <input type="checkbox" class="form-check-input d-none" name="meals[]" id="meal${meal.id}" value="${meal.id}" ${index < min ? 'checked' : ''}>
                                <label class="form-check-label meal-label" for="meal${meal.id}">
                                    <h6>${meal.title}</h6>
                                    <p>${meal.price} {{$symble}}</p>
                                </label>
                            </div>
                        </div>
                    </div>
                    </div>


                `);
                if(index <1){

                $('#programForm').submit();
                }
            });

            // Populate addons
            data.addons.forEach(function(addon ,index) {
                $('#addons-container').append(`
                    <div class="col-md-3 col-6 mb-4">
                        <div class="" style="">
                        <div class="header text-center text-dark" style="background:#fff;box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;">
                        <p>${addon.calories} <img src="{{ asset('web/calories.png') }}" style="width:20px; height:20px; ">
                        </p>
                        </div>
                        <div class="mx-auto col-12">
                          <div class="" style="">
                                <input type="checkbox" class="form-check-input d-none" name="addons[]" id="addon${addon.id}" value="${addon.id}" ${index < 2 ? 'checked' : ''}>
                            <label class="form-check-label meal-label" for="addon${addon.id}">
                                <h6>${addon.title}</h6>
                                <p>${addon.price} {{$symble}}</p>

                            </label>
                            </div>
                        </div>
                    </div>
                    </div>
        `);
        if(index <1){

            $('#programForm').submit();
            }
            });

            // Bind change event to checkboxes
            $('input[type="checkbox"]').on('change', function() {
                $('#programForm').submit();
            });
        }


        $(document).ready(function() {
            $('#programForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        // Handle the response here
                        if (response.a && Array.isArray(response.a.meals)) {
                            let mealCount = response.a.meals.length;
                            if (Array.isArray(response.a.addons)) {
                                let addonsCount = response.a.addons.length;
                                $("#extra").text(addonsCount);

                            } else {
                                $("#extra").text(0);

                            }

                            $("#main_course").text(mealCount);

                            $('#total').text(response.a.total ?? 0);
                            if (mealCount >= response.a.program.min_meals) {
                                $('#you_message').addClass('d-none').removeClass('d-block');
                                $('#button_submit').html(`
                            <a href="{{ route('front.programDuration') }}" class="btn" style="box-shadow: rgba(117, 16, 16, 0.1) 0px 4px 12px;
                            background: rgba(41, 94, 78, 0.9);
                            border: 1px solid rgba(41, 94, 78, 0.8);
                            color: #fff;">{{ trans('messages.next_step') }}</a>
                        `);
                            } else {
                                $('#you_message').addClass('d-block').removeClass('d-none');

                                $('#button_submit').html(`
                                <button class="btn"  disabled    style=" box-shadow: rgba(117, 16, 16, 0.1) 0px 4px 12px;
                                background: rgba(41, 94, 78, 0.6);
                                border: 1px solid rgba(41, 94, 78, 0.8);
                                color: #fff;">{{ trans('messages.next_step') }}</button>

                        `);
                            }
                        } else {
                            if (response.a && Array.isArray(response.a.addons)) {
                                let addonsCount = response.a.addons.length;
                                $("#main_course").text(0);

                                $("#extra").text(addonsCount);

                                $('#total').text(response.a.total ?? 0);

                            } else {
                                $("#main_course").text(0);

                                $("#extra").text(0);

                                $('#total').text(0);

                            }
                        }

                    },
                    error: function(xhr) {
                        // Handle errors here
                        let selectedMeals = $('input[name="meals[]"]:checked').length;
                        alert('aa');
                        console.log(xhr);

                    }
                });
            });
        });
    </script>
@endpush
