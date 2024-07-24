@extends('layouts.front')
@section('title', App::getLocale() == 'ar' ? $program->title_ar : $program->title_en)
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
@endpush
@section('content')
    @include('layouts.ex_front.header')
    <style>
        body {
            background-color: #e4e4e6;
            font-family: "Cairo", sans-serif;
        }

        .cairo-custom-body {
            font-family: "Cairo", sans-serif;
            font-optical-sizing: auto;
            font-weight: 400;
            /* Example weight value, adjust as needed */
            font-style: normal;
            font-variation-settings: "slnt" 0;
        }

        .custom-step-1 {
            display: flex;
            width: 90%;
            flex-direction: column;
        }

        .custom-header .custom-title {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .custom-tiles {
            display: flex;
            justify-content: start;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .custom-tiles .custom-tile {
            width: 150px;
            cursor: pointer;
            border: 1px solid #f5f5f5;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            flex-direction: column;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .custom-tiles .custom-tile.active {
            background-color: #295E4E;
            border-color: #295E4E;
            color: #fff;
        }

        .custom-tiles .custom-tile label {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 100%;
        }

        .custom-tiles .custom-tile .custom-image {
            cursor: pointer;
            margin: 10px 0;
            width: 130px;
            border-radius: 50%;
            overflow: hidden;
            height: 130px;
            object-fit: cover;
        }

        .custom-tiles .custom-tile .custom-image img {
            width: 100%;
            height: 100%;
        }

        .custom-tiles .custom-tile h6,
        .custom-tiles .custom-tile p {
            cursor: pointer;
        }

        .custom-tiles .custom-tile p span {
            font-weight: bold;
            color: #295E4E;
        }

        .myshadow {
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }

        .program_details {
            padding: 20px 0;
        }

        .program_details .container {
            max-width: 1320px;
            margin: auto;
        }

        .program_details .glass-effect {
            background: rgba(41, 94, 78, 0.6);
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

        .form-check-input.d-none {
            display: none;
        }

        .meal-label {
            cursor: pointer;
            display: block;
            text-align: center;
            border: 2px solid transparent;
            padding: 10px;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }

        .form-check-input.d-none:checked+.meal-label {
            box-shadow: rgba(117, 16, 16, 0.1) 0px 4px 12px;
            background: rgba(41, 94, 78, 0.6);
            border: 1px solid rgba(41, 94, 78, 0.8);
            color: #fff;
        }

        .meal-image {
            border-radius: 5px;
        }

        .order-card {
            background-color: #fff;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
            padding: 20px;
            border-radius: 10px;
        }

        .next-stp {
            background-color: rgba(41, 94, 78, 0.6);
            color: #fff;
            border-color: #295E4E;
        }

        .next-stp:hover {
            background-color: #1f473a;
            border-color: #1f473a;
            color: #fff;

        }

        .step {
            width: 100%;
        }

        /* RTL styles */
        body[dir="rtl"] .header,
        body[dir="rtl"] p,
        body[dir="rtl"] textarea,
        body[dir="rtl"] h2,
        body[dir="rtl"] h6 {
            text-align: right;
        }

        .required-field::after {
            content: '*';
            color: red;
            margin-left: 5px;
        }

        .prev-stp .required-star {
            color: red;
            margin-left: 5px;
        }

        #toast-container>.toast-error {
            background-color: rgba(255, 0, 0, 0.7) !important;
            color: #fff !important;
            box-shadow: #fff !important;
        }

        .toast-error .toast-title {
            color: #fff !important;
        }

        .toast-error .toast-message {
            color: #fff !important;
        }

        @media (min-width: 1200px) {

            .container,
            .container-lg,
            .container-md,
            .container-sm,
            .container-xl {
                max-width: 1320px;
            }
        }
    </style>

    <div class="program_details py-4">
        <div class="container">
            <div class="glass-effect p-4 rounded">
                <div class="details d-flex justify-content-between align-items-center">
                    <div class="info d-flex align-items-center">
                        <div class="me-3">
                            <img src="{{ asset('images/' . $program->image) }}" alt=""
                                class="img-fluid program-image">
                        </div>
                        <h3 class="program-title">{{ App::getLocale() == 'ar' ? $program->title_ar : $program->title_en }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="order py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="order-card">
                        <form action="{{ route('front.save.card') }}" method="POST">
                            @csrf
                            <div class="step step-2">
                                <p class="text-danger" style="font-size: 14px">
                                    {{ App::getLocale() == 'ar' ? 'يرجى التأكد من كتابة جميع الملاحظات الغذائية الخاصة بك، بما في ذلك تفضلها التي لا ولديك حساسية عليها. سوف نقوم بمراجعة ملاحظاتك للتأكد من أنها تتناسب مع معايير شركتنا وقائمتنا. إذا تمكنا من الحفاظ على جودة طعامنا العالية دون المكونات التي ذكرتها، فسنقبل اشتراكك. العلم يرجى أنه كلما قل عدد المكونات التي تستبعدها، كلما زاد تنوع خيارات الوجبات' : 'Please make sure to write down all your food notes, including dislikes and any allergies. We will review your preferences to ensure they fit within our company standards and our menu. If we can maintain our high food quality without the ingredients you list, we will accept your subscription. Please note that the fewer ingredients you exclude, the wider the variety of meal options you will receive.' }}
                                </p>
                                <div class="header mb-3">
                                    <h2 class="title required-field">{{ trans('messages.items_you_dont_like') }}</h2>
                                </div>

                                <textarea name="dont_like" class="form-control mb-3" rows="5"
                                    placeholder="{{ trans('messages.enter_items_you_dont_like') }}"></textarea>

                                <div class="header mb-3">
                                    <h2 class="title required-field">{{ trans('messages.items_that_make_you_allergic') }}
                                    </h2>
                                </div>
                                <textarea name="allergic" class="form-control mb-3" rows="5"
                                    placeholder="{{ trans('messages.enter_items_that_make_you_allergic') }}"></textarea>

                                <div class="header mb-3">
                                    <h2 class="title required-field">{{ trans('messages.note') }}
                                    </h2>
                                </div>
                                <textarea name="notes" class="form-control mb-3" rows="5"
                                    placeholder="{{ trans('messages.note_place_holder') }}"></textarea>

                                <div class="d-flex justify-content-between">
                                    <button class="btn next-stp" type="button">{{ trans('messages.next_step') }}</button>
                                </div>
                            </div>

                            <div class="step step-3 d-none">
                                <div class="custom-step-1">
                                    <div class="custom-header mb-4">
                                        <h2 class="title ">{{ trans('messages.items') }}</h2>
                                        <p class="text-danger" style="font-size: 14px;">
                                            {{ trans('messages.select_items_not_like') }}</p>
                                    </div>
                                    <div class="custom-tiles">
                                        @foreach ($program->menu->Menu as $item)
                                            <div class="custom-tile" data-id="{{ $item->Item1->id }}">
                                                <div class="custom-image">
                                                    <img src="{{ asset('images/' . $item->Item1->image) }}"
                                                        alt="Meal Image">
                                                </div>
                                                <h6>{{ $item->Item1->{'title_' . App::getLocale()} }}</h6>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <input type="hidden" name="items" id="selected-items" value="">

                                <div class="d-flex justify-content-between mt-4">
                                    <button class="btn btn-secondary prev-stp"
                                        type="button">{{ trans('messages.go_back') }}</button>
                                    <button class="btn next-stp" type="submit">{{ trans('messages.check_out') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ asset('web/assets/js/pages/select2.init.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tiles = document.querySelectorAll('.custom-tile');
            const selectedItemsInput = document.getElementById('selected-items');
            const form = document.getElementById('menu-form');

            let selectedItems = new Set();

            tiles.forEach(tile => {
                tile.addEventListener('click', () => {
                    const itemId = tile.getAttribute('data-id');
                    if (tile.classList.toggle('active')) {
                        selectedItems.add(itemId);
                    } else {
                        selectedItems.delete(itemId);
                    }
                    selectedItemsInput.value = Array.from(selectedItems).join(',');
                });
            });

            form.addEventListener('submit', () => {
                selectedItemsInput.value = Array.from(selectedItems).join(',');
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const steps = document.querySelectorAll('.step-2, .step-3');
            const nextBtns = document.querySelectorAll('.next-stp');
            const prevBtns = document.querySelectorAll('.prev-stp');

            let currentStep = 0;

            function showStep(stepIndex) {
                steps.forEach((step, index) => {
                    step.classList.toggle('d-none', index !== stepIndex);
                });
            }

            nextBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    if (currentStep < steps.length - 1) {
                        currentStep++;
                        showStep(currentStep);
                    }
                });
            });

            prevBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    if (currentStep > 0) {
                        currentStep--;
                        showStep(currentStep);
                    }
                });
            });

            showStep(currentStep);
        });
    </script>
@endpush
