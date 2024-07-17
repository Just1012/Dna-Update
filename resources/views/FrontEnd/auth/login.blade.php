@extends('layouts.front')

@section('title', trans('messages.sign_in'))
@section('content')
<style>
  body{
    overflow: hidden;
  }
</style>

<div class="wrapper">
    <div class="login">
        <div class="content">
          <div class="login_form">
            <div class="heading text-center">
              <h2 class="mb-2">{{ trans('messages.sign_in') }}</h2>
              <p>{{ trans('messages.stay_connected') }}</p>
            </div>
            <form action="{{ route('front.login.store') }}" method="POST">
                @csrf
              <div class="inputs">
                <label for="phone">{{ trans('messages.phone') }}</label>
                <input type="number" name="phone" id="phone" inputmode="numeric" pattern="[0-9]" required>
            </div>
              <div class="inputs">
                <label for="password">{{ trans('messages.password') }}</label>
                <input type="password" name="password" id="password" required>
            </div>
              <div class="inputs">
                <div class="check_input">
                  <input type="checkbox" name="" id="check">
                  <label for="check">{{ trans('messages.remember_me') }}</label>
                </div>
                <a href="./forgetPassword.html">{{ trans('messages.forgot_password') }}</a>
              </div>
              <input type="submit" value="{{ trans('messages.submit') }}">
            </form>
            <p class="my-3 text-center">{{ trans('messages.sign_in_with_others') }}</p>

            <p class="text-center any_account">
              {{ trans('messages.no_account') }} <a href="{{ route('front.register') }}">{{ trans('messages.sign_up') }}</a>
            </p>
          </div>
          <div class="image">
            <img src="{{ asset('front//images/09.png') }}" alt="">
          </div>
        </div>
    </div>
  </div>
@endsection