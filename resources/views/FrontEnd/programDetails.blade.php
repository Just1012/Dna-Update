@extends('layouts.front')
@section('title', App::getLocale() == 'ar' ? $programsDetails->title_ar : $programsDetails->title_en)
@section('content')
    @include('layouts.ex_front.header')
    <div class="program_details">
        <div class="container">
            <div class="bg">
                <div class="details">
                    <div class="info d-flex justify-content-between align-items-center">
                        <div class="right">
                            <div class="image">
                                <img src="{{ asset('images/' . $programsDetails->image) }}" alt="">
                            </div>
                            <h3>{{ App::getLocale() == 'ar' ? $programsDetails->title_ar : $programsDetails->title_en }}</h3>
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
                <div class="form" style="flex: 0 0 73%;">
                    <div class="form-container">
                        <!-- * Step 1 start -->
                        <form action="{{ route('front.storeProgramMeals', ['id' => $programsDetails->id]) }}" method="post">
                            @csrf
                            <div class="stp step-1">
                                <div class="header">
                                    <h1 class="title">{{ trans('messages.meals') }}</h1>
                                </div>
                                <div class="tiles">
                                    @foreach ($meals as $meal)
                                        <div class="tile">
                                            <input type="checkbox" name="meals[]" id="meal{{ $meal['id'] }}" value="{{ $meal['id'] }}">
                                            <label for="meal{{ $meal['id'] }}">
                                                <div class="image">
                                                    <img src="{{ asset('front/images/breakfast.jpg') }}" alt="Meal Image">
                                                </div>
                                                <h6>{{ $meal['title'] }}</h6>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="header">
                                    <h1 class="title">{{ trans('messages.addons') }}</h1>
                                </div>
                                <div class="tiles">
                                    @foreach ($addons as $addon)
                                        <div class="tile">
                                            <input type="checkbox" name="addons[]" id="addon{{ $addon['id'] }}" value="{{ $addon['id'] }}">
                                            <label for="addon{{ $addon['id'] }}">
                                                <div class="image">
                                                    <img src="{{ asset('front/images/breakfast.jpg') }}" alt="">
                                                </div>
                                                <h6>{{ $addon['title'] }}</h6>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="btns">
                                    <button class="next-stp" type="submit">{{ trans('messages.next_step') }}</button>
                                </div>
                            </div>
                        </form>
                        <!-- Step 1 end -->
                    </div>
                </div>
                {{-- <div class="checkout" style="flex: 0 0 25%;">
                    <div class="heading">
                        <h2>{{ trans('messages.checkout') }}</h2>
                    </div>
                    <div class="item">
                        <h5>{{ trans('messages.main_course') }}</h5>
                        <p>$150</p>
                    </div>
                    <div class="item mt-0">
                        <h5>{{ trans('messages.sub_course') }}</h5>
                        <p>$150</p>
                    </div>
                    <hr class="m-0" />
                    <div class="total">
                        <H5>{{ trans('messages.total') }}</H5>
                        <p>$300</p>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
@endpush