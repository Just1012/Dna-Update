@extends('layouts.front')
{{-- @section('title', trans('messages.profile')) --}}
@push('css')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .form-check-label{
        margin-bottom: 5px;
        font-size: 19px;
        font-weight: 600;
        color: #000000
    }
</style>
@endpush
@section('content')
<div class="main-content">
    <div class="page-content">
    <div class="container-fluid">

    <!-- start page title -->
    <div class="row">
    <div class="col-12">
<div style="margin-top: 100px">
    <form action="{{ route('update_profile_user',$order->User->id) }}" method="post" style="margin: auto">
    @csrf
    @method('PUT')
    <input type="hidden" name="order_id" value="{{ $order->id }}">
    <input type="hidden" name="num_of_week" value="{{ $order->duration_id }}">
    <div class="flex-shrink-0 mt-sm-0 mt-3">
    <div class="form-check">
        <input class="form-check-input checkbox suspension_" type="checkbox" value="1" name="suspension" id="flexCheckDefault" >
        <label class="form-check-label" for="flexCheckDefault">
            suspension Order
        </label>
    </div>
    <h6>
    User Name :<input  value="{{ $order->User->name }}" class="form-control w-100 hasDatepicker" name="name" type="text" id="date" required=""  >
    </h6>

    <h6>
    Phone No : +965<input  value="{{ $order->User->phone }}" class="form-control w-100 hasDatepicker" name="phone" type="text" id="" required=""  >
    </h6>
    <input type="hidden" name="activeCount" id="activeCount">
    <h6>


        <input type="text" name="start_date" id="inputDate1" class="dis" placeholder="start date" />
        <input type="text" name="end_date" id="inputDate2"   class="dis" placeholder="end date" />


    </h6>
    <h6>

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
    <div class="form-check dis">
        <input class="form-check-input checkbox dis"  type="checkbox" name="Monday" value="1" id="flexCheckDefault" @checked($orderday["Monday"]==1)>
        <label class="form-check-label" for="flexCheckDefault">
            Monday
        </label>
    </div>
    <div class="form-check dis">
        <input class="form-check-input checkbox "  type="checkbox" value="1" name="Tuesday" id="flexCheckDefault" @checked($orderday["Tuesday"]==1)>
        <label class="form-check-label" for="flexCheckDefault">
            Tuesday
        </label>
    </div>
    <div class="form-check dis">
        <input class="form-check-input checkbox "  type="checkbox" value="1" name="Wednesday" id="flexCheckDefault" @checked($orderday["Wednesday"]==1)>
        <label class="form-check-label" for="flexCheckDefault">
            Wednesday
        </label>
    </div>
    <div class="form-check dis">
        <input class="form-check-input checkbox "  type="checkbox" value="1" name="Thursday" id="flexCheckDefault" @checked($orderday["Thursday"]==1)>
        <label class="form-check-label" for="flexCheckDefault">
            Thursday
        </label>
    </div>
    <div class="form-check dis">
        <input class="form-check-input checkbox "  type="checkbox" value="1" name="Saturday" id="flexCheckDefault" @checked($orderday["Saturday"]==1)>
        <label class="form-check-label" for="flexCheckDefault">
            Saturday
        </label>
    </div>
    <div class="form-check dis">
        <input class="form-check-input checkbox "  type="checkbox" value="1" name="Sunday" id="flexCheckDefault" @checked($orderday["Sunday"]==1)>
        <label class="form-check-label" for="flexCheckDefault">
            Sunday
        </label>
    </div>
    <div class="form-check dis">
        <input class="form-check-input checkbox "  type="checkbox" value="1" name="Friday" id="flexCheckDefault" @checked($orderday["Friday"]==1)>
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
    <input type="submit" value="edit" class="btn btn-primary" style="width: 79%;margin: auto;">
    </form>

    <!--end card-header-->
    </div>






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
    </div>


@include('layouts.ex_front.header')


@endsection

@push('js')
<script>


const checkboxes = document.querySelectorAll('.checkbox');
const activeCountDisplay = document.getElementById('activeCount');

checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', updateActiveCount);
});

function updateActiveCount() {
    const activeCount = Array.from(checkboxes).filter(checkbox => checkbox.checked).length;
    activeCountDisplay.value  = activeCount;
}

</script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
// تحديد التاريخ الحالي
const today = new Date();
const minDate = new Date(today);
minDate.setDate(today.getDate() + 3); // إضافة 3 أيام

// تهيئة flatpickr لكلا حقلين
flatpickr("#inputDate1", {
    minDate: minDate, // تحديد الحد الأدنى للتاريخ
    disable: [
        function(date) {
            return date.getDay() === 5; // 5 = يوم الجمعة
        }
    ],
    dateFormat: "Y-m-d", // تنسيق التاريخ
});

flatpickr("#inputDate2", {
    minDate: minDate, // تحديد الحد الأدنى للتاريخ
    disable: [
        function(date) {
            return date.getDay() === 5; // 5 = يوم الجمعة
        }
    ],
    dateFormat: "Y-m-d", // تنسيق التاريخ
});

// حساب الفرق عند النقر على الزر
document.getElementById('calculateDays').addEventListener('click', function() {
    const inputDate1 = new Date(document.getElementById('inputDate1').value);
    const inputDate2 = new Date(document.getElementById('inputDate2').value);

    if (!inputDate1 || !inputDate2) {
        document.getElementById('result').innerText = 'يرجى اختيار كلا التاريخين.';
        return;
    }

    // حساب الفرق بالأيام
    const timeDifference = Math.abs(inputDate2 - inputDate1); // الفرق بالمللي ثانية
    const daysDifference = Math.floor(timeDifference / (1000 * 60 * 60 * 24)); // تحويل المللي ثانية إلى أيام

    // عرض النتيجة
    document.getElementById('result').innerText = `عدد الأيام بين التاريخين هو: ${daysDifference} يوم(s)`;
});


    </script>


<script>
$(".suspension_").click(function(){
// $(".dis").toggle();
$("input[name=recipients\\[\\]]").trigger('click');

});
</script>


@endpush

