@extends('layouts.front')
@section('title', trans('messages.programs'))
@section('content')
    @include('layouts.ex_front.header')

    <style>
           .add:hover{
            color: #F3BB68 !important;
        }
        .wrapper {
            position: relative;
            margin-top: 70px;

            img {
                width: 100%;
                min-height: 300px;
            }

            &::before {
                content: '';
                position: absolute;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.252);
            }

            .text {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);

                h1 {
                    color: #fff;
                    font-weight: bold;
                }
            }
        }


        @media (max-width:767px) {
            .wrapper {
                img {
                    min-height: auto;
                }
            }
        }
    </style>

    <div class="wrapper">
        @php
            $images = App\Models\ImageSetting::first();
        @endphp

        <img style="height: 300px !important; object-fit:cover;" src="{{ asset('images/' . $images->all_program_image) }}" alt="">
        <div class="text">
            <h1>{{ trans('messages.programs') }}</h1>
        </div>
    </div>

    <div class="all_programs">
        <div class="container">
            {{-- <div class="heading text-center">
            <h3>All Programs</h3>
          </div> --}}
            <div class="content d-flex justify-content-start align-items-center flex-wrap mb-5">
                @foreach ($programs as $program)
                    <div class="address">
                        <div class="image">
                            <img src="{{ asset('images/' . $program->image) }}" alt="">
                        </div>
                        <div class="offer">
                            <a class="" href="{{ route('front.programDetails', ['id' => $program->id]) }}">

                            <h2 class="mb-2 text-center add">
                                {{ App::getLocale() == 'ar' ? $program->title_ar : $program->title_en }}</h2>
                            </a>
                                <p class="mb-0 " >
                                {!! \App\Utils\helper::str_limit_words(App::getLocale() == 'ar' ? $program->description_ar : $program->description_en, 100) !!}
                            </p>

                        </div>

                </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="./js/bootstrap.bundle.js"></script>
    <script src="./js/main.js"></script>
@endpush
