@extends('layouts.front')

@section('title', trans('messages.register'))
@section('content')
<style>
  body {
    overflow: hidden;
  }
</style>
<div class="wrapper">
    <div class="signup">
        <div class="content">
          <div class="signup_form">
            <div class="heading text-center">
              <h2 class="mb-2">{{ trans('messages.sign_up') }}</h2>
              <!--<p>{{ trans('messages.create_account') }}</p>-->
            </div>
            <form action="{{ route('front.register.store') }}" method="POST">
                @csrf
              <div class="name_inputs">
                <div class="input" style="margin-right:10px">
                  <label for="fName">{{ trans('messages.first_name') }}</label>
                  <input type="text" name="f_name" id="fName" required>
                </div>
                <div class="input">
                  <label for="lName">{{ trans('messages.last_name') }}</label>
                  <input type="text" name="l_name" id="lName" required>
                </div>
              </div>

              <label for="phone">{{ trans('messages.phone_no') }}</label>
              <div class="phone_inputs">
                <div class="input">
                  <span class="code">
                    <img src="{{ asset('front/images/الكويت.jpeg') }}" alt="#">
                    +965
                  </span>
                  <label for="phone">{{ trans('messages.phone_no') }}</label>
                  <input type="number" name="phone" id="phone" inputmode="numeric" pattern="[0-9]" required>
                </div>
              </div>

              <div class="password_inputs">
                <div class="input" style="margin-right: 40px">
                  <label for="password">{{ trans('messages.password') }}</label>
                  <input type="password" name="password" id="password" required>
                </div>
                <div class="input">
                  <label for="Cpassword">{{ trans('messages.confirm_password') }}</label>
                  <input type="password" name="password_confirmation" id="Cpassword" required>
                </div>
              </div>
              <div class="check_input">
                <input type="checkbox" name="" id="check" required>
                <label for="check" class="m-0">{{ trans('messages.agree_terms') }}</label>
                @include('layouts.model')

              </div>
              <input type="submit" value="{{ trans('messages.submit') }}">
            </form>

            <p class="text-center any_account">
              {{ trans('messages.already_have_account') }} <a href="{{ route('front.login') }}">{{ trans('messages.sign_in') }}</a>
            </p>
          </div>
          <div class="image">
            <img src="{{ asset('front/images/09.png') }}" alt="">
          </div>
        </div>
    </div>
  </div>

@endsection

@push('js')
<script>
    let inputPhone = document.querySelector('#phone');
    let phoneDiv = document.querySelector('.phone_inputs');
    inputPhone.addEventListener('focusin', () => {
        phoneDiv.style.border = '1px solid #295E4E';
    });
    inputPhone.addEventListener('focusout', () => {
        phoneDiv.style.border = '1px solid #3333335e';
    });

    inputPhone.addEventListener("input", () => {
        let phoneNumber = inputPhone.value;
        if (phoneNumber.length > 8) {
            inputPhone.value = inputPhone.value.slice(0, 8);
        }
    });
</script>
@endpush
