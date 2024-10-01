@extends('layouts.web')
@push('css')
<link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
<!--datatable css-->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
<!--datatable responsive css-->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<!-- Bootstrap Css -->

@endpush
@section('title')
    Orders List
@endsection
@section('content')
<div class="main-content">
<div class="page-content">
<div class="container-fluid">

<!-- start page title -->
<div class="row">
<div class="col-12">

<form action="{{ route('order.Orderupdate',$order->User->id) }}" method="post">
@csrf
@method('PUT')
<input type="hidden" name="order_id" value="{{ $order->id }}">
<div class="flex-shrink-0 mt-sm-0 mt-3">

<h6>
User Name :<input  value="{{ $order->User->name }}" class="form-control w-100 hasDatepicker" name="name" type="text" id="date" required=""  >
</h6>

<h6>

Phone No :   +965<input  value="{{ $order->User->phone }}" class="form-control w-100 hasDatepicker" name="phone" type="text" id="" required=""  >

</h6>
<h6>
<select>
@php

$duration= App\Models\Duration::get();

@endphp
<option disabled selected>Your Choice</option>
@foreach ($duration as $duration)
<option id="{{ $duration->id }}"
@selected($duration->id==$order->duration_id)> {{ $duration->title_en}} </option>
@endforeach
</select>
{{-- address :<input  value="{{ $order->Duration->{'title_' . App::getLocale()} }}" class="form-control w-100 hasDatepicker" name="text" type="text" id="date" required=""  > --}}

</h6>
<h6>
Start Date :<input  value="{{ $order->start_date }}" class="form-control w-100 hasDatepicker" name="start_date" type="date" id="date" required=""  >
</h6>
<h6>
End Date :<input  value="{{ $order->start_date }}" class="form-control w-100 hasDatepicker" name="end_date" type="date" id="date" required=""  >
</h6>

@php
    // Fetch the data from the database for the specified order
    $orderday = App\Models\orderDayes::where("order_id", $order->id)->first([
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Sunday",
        "Saturday",
        "Friday"
    ]);

    // Define the days of the week
    $days = ["Monday", "Tuesday", "Wednesday", "Thursday","Saturday", "Sunday","Friday"];
@endphp

<div class="form-check">
    <input class="form-check-input" type="checkbox" name="Monday" value="1" id="flexCheckDefault" @checked($orderday["Monday"]==1)>
    <label class="form-check-label" for="flexCheckDefault">
        Monday
    </label>
</div>
<div class="form-check">
    <input class="form-check-input" type="checkbox" value="1" name="Tuesday" id="flexCheckDefault" @checked($orderday["Tuesday"]==1)>
    <label class="form-check-label" for="flexCheckDefault">
        Tuesday
    </label>
</div>
<div class="form-check">
    <input class="form-check-input" type="checkbox" value="1" name="Wednesday" id="flexCheckDefault" @checked($orderday["Wednesday"]==1)>
    <label class="form-check-label" for="flexCheckDefault">
        Wednesday
    </label>
</div>
<div class="form-check">
    <input class="form-check-input" type="checkbox" value="1" name="Thursday" id="flexCheckDefault" @checked($orderday["Thursday"]==1)>
    <label class="form-check-label" for="flexCheckDefault">
        Thursday
    </label>
</div>
<div class="form-check">
    <input class="form-check-input" type="checkbox" value="1" name="Saturday" id="flexCheckDefault" @checked($orderday["Saturday"]==1)>
    <label class="form-check-label" for="flexCheckDefault">
        Saturday
    </label>
</div>
<div class="form-check">
    <input class="form-check-input" type="checkbox" value="1" name="Sunday" id="flexCheckDefault" @checked($orderday["Sunday"]==1)>
    <label class="form-check-label" for="flexCheckDefault">
        Sunday
    </label>
</div>
<div class="form-check">
    <input class="form-check-input" type="checkbox" value="1" name="Friday" id="flexCheckDefault" @checked($orderday["Friday"]==1)>
    <label class="form-check-label" for="flexCheckDefault">
        Friday
    </label>
</div>




<h6>
@error("comment") {{ $message }} @enderror
Comment :<textarea class="form-control w-100 hasDatepicker" name="comment" id="" cols="30" rows="10"></textarea>


</h6>
</div>

</div>
</div>

<!--end card-header-->
</div>
<input type="submit" value="edit" class="btn btn-primary">
</form>






</div>
</div>
<!--end card-body-->
</div>
<!--end col-->
</div>
<!--end row-->
</div>
<!--end card-->
</div>
<!--end col-->
</div>
<!--end row-->

</div><!-- container-fluid -->
</div><!-- End Page-content -->
</div>
@endsection



<script>
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

</script>
@push('js')

@endpush
