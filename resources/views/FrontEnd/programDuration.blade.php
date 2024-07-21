@extends('layouts.front')
@section('title', App::getLocale() == 'ar' ? $program->title_ar : $program->title_en)
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('content')
    @include('layouts.ex_front.header')
    <style>
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
    </style>
    <div class="program_details">
        <div class="container">
            <div class="bg">
                <div class="details">
                    <div class="info d-flex justify-content-between align-items-center">
                        <div class="right">
                            <div class="image">
                                <img src="{{ asset('images/' . $program->image) }}" alt="">
                            </div>
                            <h3>{{ App::getLocale() == 'ar' ? $program->title_ar : $program->title_en }}</h3>
                        </div>
                        <div class="left">
                            <div>
                                <p class="mb-1 mt-2">142</p>
                                <small class="mb-1 fw-normal">{{ trans('messages.reviews') }}</small>
                            </div>
                            <div>
                                <p class="mb-1 mt-2">201</p>
                                <small class="mb-1 fw-normal">{{ trans('messages.photos') }}</small>
                            </div>
                            <div>
                                <p class="mb-1 mt-2">142</p>
                                <small class="mb-1 fw-normal">{{ trans('messages.reviews') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="order">
        <div class="container">
            <div class="content d-flex justify-content-start">
                <div class="form">
                    <div class="form-container">
                        <!-- Sidebar start -->
                        <div class="form-sidebar">

                            <div class="step">
                                <div class="circle" style="width: 57px;">2</div>
                                <div class="step-content">
                                    <span>{{ trans('messages.order_preferences') }}</span>
                                    <b>{{ trans('messages.order_preferences') }}</b>
                                </div>
                            </div>
                            <div class="step">
                                <div class="circle">3</div>
                                <div class="step-content">
                                    <span>{{ trans('messages.summary') }}</span>
                                    <b>{{ trans('messages.summary') }}</b>
                                </div>
                            </div>
                            <div class="step">
                                <div class="circle">4</div>
                                <div class="step-content">
                                    <span style="font-size: 10px;">{{ trans('messages.end') }}</span>
                                    <b>{{ trans('messages.end') }}</b>
                                </div>
                            </div>
                        </div>
                        <!-- Sidebar end -->
                        <form style="max-width:100%;" action="{{ route('front.save.card') }}" method="POST">
                            @csrf
                            <!-- Step 1 start -->

                            <!-- Step 1 end -->

                            <!-- Step 2 start -->
                            <div class="stp step-2">
                                <div class="header">
                                    <h2 class="title">{{ trans('messages.items_you_dont_like') }}</h2>
                                </div>
                                <textarea
                                    style="width: 100%; border: 1px solid #999; height: 300px; resize: none; border-radius: 5px; outline: none; padding: 10px; margin-bottom: 30px;"
                                    name="dont_like" class="dont_like p-2 mb-3" placeholder="{{ trans('messages.enter_items_you_dont_like') }}"></textarea>

                                <div class="header p-0">
                                    <h2 class="title">{{ trans('messages.items_that_make_you_allergic') }}</h2>
                                </div>
                                <textarea
                                    style="width: 100%; border: 1px solid #999; height: 300px; resize: none; border-radius: 5px; outline: none; padding: 10px; margin-bottom: 30px;"
                                    name="allergic" class="dont_like p-2" placeholder="{{ trans('messages.enter_items_that_make_you_allergic') }}"></textarea>

                                <div class="btns mt-2">
                                    <button class="prev-stp" type="button">{{ trans('messages.go_back') }}</button>
                                    <button class="next-stp" type="button">{{ trans('messages.next_step') }}</button>
                                </div>
                            </div>
                            <!-- Step 2 end -->

                            <!-- Step 3 start -->
                            <div class="stp step-3">
                                <div class="custom-step-1">
                                    <div class="custom-header">
                                        <h1 class="custom-title">{{ trans('messages.items') }}</h1>
                                        <p>{{ trans('messages.select_items_not_like') }}</p>
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

                                <!-- Multi Selected -->
                                <div class="btns mt-2">
                                    <button class="prev-stp" type="button">{{ trans('messages.go_back') }}</button>
                                    <button class="next-stp" type="submit">{{ trans('messages.check_out') }}</button>
                                </div>
                            </div>
                            <!-- Step 3 end -->

                            <!-- Step 4 start -->
                            {{-- <div class="stp step-4">
                                <img src="{{ asset('front/images/icon-thank-you.svg') }}" alt="" />
                                <div class="header">
                                    <h1 class="title">{{ trans('messages.thank_you') }}</h1>
                                    <p class="exp">
                                        {{ trans('messages.thanks_for_confirming_subscription') }}
                                    </p>
                                </div>
                                <button class="next-stp" type="submit">{{ trans('messages.check_out') }}</button>
                            </div> --}}
                            <!-- Step 4 end -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <!--jquery cdn-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!--select2 cdn-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('web/assets/js/pages/select2.init.js') }}"></script>

    <script src="{{ asset('front/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('front/js/main.js') }}"></script>
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
            const steps = document.querySelectorAll('.stp');
            const nextBtns = document.querySelectorAll('.next-stp');
            const prevBtns = document.querySelectorAll('.prev-stp');

            let currentStep = 0;

            function showStep(stepIndex) {
                steps.forEach((step, index) => {
                    step.classList.toggle('active', index === stepIndex);
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const accordion = document.getElementById('accordionExample');
            const accordionItems = accordion.querySelectorAll('.accordion-item');

            accordionItems.forEach(item => {
                const button = item.querySelector('.accordion-button');
                const collapse = item.querySelector('.accordion-collapse');

                button.addEventListener('click', () => {
                    const isOpen = collapse.classList.contains('show');

                    // Close all sections first
                    accordionItems.forEach(i => {
                        const btn = i.querySelector('.accordion-button');
                        const col = i.querySelector('.accordion-collapse');
                        col.classList.remove('show');
                        btn.classList.add('collapsed');
                        btn.setAttribute('aria-expanded', 'false');
                    });

                    // Toggle the clicked section
                    if (!isOpen) {
                        collapse.classList.add('show');
                        button.classList.remove('collapsed');
                        button.setAttribute('aria-expanded', 'true');
                    }
                });
            });
        });
    </script>
@endpush
