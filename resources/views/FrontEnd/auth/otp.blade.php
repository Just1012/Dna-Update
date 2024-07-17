@extends('layouts.front')

@section('title', 'otp')
@section('content')
<style>
  body{
    overflow: hidden;
  }
</style>
<div class="wrapper">
    <div class="otp">
        <div class="content">
          <div class="otp_form">
            <div class="heading text-center">
              <h2 class="mb-2">Verification Code</h2>
              <p>We Have Sent The Verification Code To Your Email Address.</p>
            </div>
            <h6>ExampleEmail@gmail.com</h6>
            <form action="{{ route('front.otp.post') }}" method="POST">
                @csrf
                <div class="inputs">
                    <input type="text" name="number_1" id="number_1" required maxlength="1">
                    <input type="text" name="number_2" id="number_2" required maxlength="1">
                    <input type="text" name="number_3" id="number_3" required maxlength="1">
                    <input type="text" name="number_4" id="number_4" required maxlength="1">
                </div>
                <input type="submit" value="Confirm">
            </form>

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
    function addListener(input) {
      input.addEventListener("keyup", () => {
        const code = parseInt(input.value);
        if (code >= 0 && code <= 9) {
          const n = input.nextElementSibling;
          if (n) n.focus();
        } else {
          input.value = "";
        }

        const key = event.key; // const {key} = event; ES6+
        if (key === "Backspace" || key === "Delete") {
          const prev = input.previousElementSibling;
          if (prev) prev.focus();
        }
      });
    }

    const inputs = ["number_1", "number_2", "number_3", "number_4"];

    inputs.map((id) => {
      const input = document.getElementById(id);
      addListener(input);
    });
    </script>
@endpush
