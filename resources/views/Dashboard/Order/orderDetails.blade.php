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
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Order Details</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('order.index') }}">Order</a></li>
                                <li class="breadcrumb-item active">Order Details</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row justify-content-center">
                <div class="col-xxl-9">
                    <div class="card" id="demo">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-header border-bottom-dashed p-4">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <img src="{{ asset('web/assets/images/logo-light.png') }}"
                                                class="card-logo card-logo-dark" alt="logo dark" height="70">
                                            <img src="assets/images/logo-light.png" class="card-logo card-logo-light"
                                                alt="logo light" height="70">
                                        </div>
                                        <div class="flex-shrink-0 mt-sm-0 mt-3">
                                            <h6><span class="text-muted fw-normal">User Name :
                                                </span><span id="legal-register-no">{{ $order->User->name }}</span>
                                            </h6>
                                            <h6>
                                                <span class="text-muted fw-normal">Phone No : </span>
                                                <span id="email">+965 {{ $order->User->phone }}</span>
                                            </h6>
                                            <h6>
                                                <span class="text-muted fw-normal">Duration : </span>
                                                <span id="email">{{ $order->Duration->{'title_' . App::getLocale()}
                                                    }}</span>
                                            </h6>
                                            <h6>
                                                <span class="text-muted fw-normal">Start Date : </span>
                                                <span id="email">{{ $order->start_date }}</span>
                                            </h6>
                                            <h6>
                                                <span class="text-muted fw-normal">End Date : </span>
                                                <span id="email">{{ $order->end_date }}</span>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <!--end card-header-->
                            </div>
                            <!--end col-->
                            <div class="col-lg-12">
                                <div class="card-body p-4">
                                    <div class="row g-3">
                                        <div class="col-lg-2 col-6">
                                            <p class="text-muted mb-2 text-uppercase fw-semibold">Order No</p>
                                            <h5 class="fs-14 mb-0">#VL<span id="invoice-no">{{ $order->id }}</span>
                                            </h5>
                                        </div>
                                        @php
                                        use Carbon\Carbon;
                                        $date = Carbon::parse($order->created_at)->format('Y-m-d');
                                        $time = Carbon::parse($order->created_at)->format('h:i A');
                                        @endphp
                                        <!--end col-->
                                        <div class="col-lg-3 col-6">
                                            <p class="text-muted mb-2 text-uppercase fw-semibold">Order Created Date</p>
                                            <h5 class="fs-14 mb-0"><span id="invoice-date">{{ $date }}</span>
                                                <small class="text-muted" id="invoice-time">{{ $time }}</small>
                                            </h5>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-3 col-6">
                                            <p class="text-muted mb-2 text-uppercase fw-semibold">Payment Status
                                            </p>
                                            <span class="badge bg-success-subtle text-success fs-11"
                                                id="payment-status">{{ $order->payment_method }}</span>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-2 col-6">
                                            <p class="text-muted mb-2 text-uppercase fw-semibold">Program Name</p>
                                            <h5 class="fs-14 mb-0"><span id="total-amount">{{ $order->Program->{'title_'
                                                    . App::getLocale()} }}</span>
                                            </h5>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-2 col-6">
                                            <p class="text-muted mb-2 text-uppercase fw-semibold">Total Amount
                                            </p>
                                            <h5 class="fs-14 mb-0">$<span id="total-amount">{{ $order->total }}</span>
                                            </h5>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </div>
                                <!--end card-body-->
                            </div>
                            <!--end col-->
                            <div class="col-lg">
                                <div class="card-body p-4">
                                    <div class="container">
                                        <div class="row">
                                            @foreach ($order->OrderDays as $value)
                                            @php
                                            $locale = App::getLocale();
                                            $governorateName = DB::table('governorates')
                                            ->where('id', $value->Address->governorate_id)
                                            ->select('title_' . $locale . ' as title')
                                            ->first();
                                            $areaName = DB::table('areas')
                                            ->where('id', $value->Address->area_id)
                                            ->select('area_' . $locale . ' as area')
                                            ->first();
                                            @endphp
                                            <div class="col-md-6 mt-sm-5 mt-4">
                                                <h6 class="text-muted text-uppercase fw-semibold">Address</h6>

                                                <p class="text-muted mb-1" id="address-details">
                                                    {{ $governorateName->title }} - {{ $areaName->area }} <br> {{
                                                    $value->Address->address }}</p>

                                                <p class="text-muted mb-0" id="zip-code"><span>Days: </span>
                                                    @php
                                                    $days = [];
                                                    if ($value->Monday == 1) {
                                                    $days[] = 'Monday';
                                                    }
                                                    if ($value->Tuesday == 1) {
                                                    $days[] = 'Tuesday';
                                                    }
                                                    if ($value->Wednesday == 1) {
                                                    $days[] = 'Wednesday';
                                                    }
                                                    if ($value->Thursday == 1) {
                                                    $days[] = 'Thursday';
                                                    }
                                                    if ($value->Friday == 1) {
                                                    $days[] = 'Friday';
                                                    }
                                                    if ($value->Saturday == 1) {
                                                    $days[] = 'Saturday';
                                                    }
                                                    if ($value->Sunday == 1) {
                                                    $days[] = 'Sunday';
                                                    }
                                                    @endphp
                                                    {{ implode(' - ', $days) }}
                                                </p>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="card-body p-4">

                                    <div class="table-responsive mb-5">
                                        <h5>Meals Selected</h5>
                                        <table
                                            class="table table-borderless text-center table-nowrap align-middle mb-0">
                                            <thead>
                                                <tr class="table-active">
                                                    <th scope="col" style="width: 50px;">#</th>
                                                    <th scope="col">Meal Name</th>
                                                    <th scope="col">Type</th>
                                                </tr>
                                            </thead>
                                            <tbody id="products-list">
                                                @php
                                                $meals = json_decode($order->meals_id);
                                                $x = 0;
                                                @endphp
                                                @foreach ($meals as $meal)
                                                @php
                                                $value = App\Models\Meal::where('id', $meal)->first();
                                                $x++;
                                                @endphp
                                                <tr>
                                                    <td scope="row" style="width: 50px;">{{ $x }}
                                                    </td>
                                                    <td scope="row" style="width: 50px;">
                                                        {{ $value->{'title_' . App::getLocale()} }}
                                                    </td>
                                                    <td scope="row" style="width: 50px;">
                                                        @if ($value->type == 1)
                                                        {{ 'Main' }}
                                                        @else
                                                        {{ 'Sub' }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <!--end table-->
                                    </div>


                                    <div class="table-responsive">
                                        <h5>Items Not Like</h5>
                                        <table
                                            class="table table-borderless text-center table-nowrap align-middle mb-0">
                                            <thead>
                                                <tr class="table-active">
                                                    <th scope="col" style="width: 50px;">#</th>
                                                    <th scope="col">Image</th>
                                                    <th scope="col">Item Name</th>
                                                </tr>
                                            </thead>
                                            <tbody id="products-list">
                                                @php
                                                $items = json_decode($order->items_id);
                                                $x = 0;
                                                @endphp
                                                @foreach ($items as $item)
                                                @if($item)
                                                @php
                                                $value = App\Models\Item::where('id', $item)->first();
                                                $x++
                                                @endphp
                                                <tr>
                                                    <td scope="row" style="width: 50px;">{{ $x }}</td>
                                                    <td scope="row" style="width: 50px;">
                                                        <img style="width: 50px; height: 50px; border-radius: 50%;"
                                                            src="{{ asset('images/' . $value->image) }}" alt="Image">
                                                    </td>
                                                    <td scope="row" style="width: 50px;">
                                                        {{ $value->{'title_' . App::getLocale()} }}</td>
                                                </tr>

                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <!--end table-->
                                    </div>


                                    <div class="mt-4">
                                        <div class="alert alert-success">
                                            <p class="mb-0"><span class="fw-semibold">Vulnerability : </span>
                                                <span id="note">{{ $order->vulnerability }}</span>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <div class="alert alert-info">
                                            <p class="mb-0"><span class="fw-semibold">Unlike : </span>
                                                <span id="note">{{ $order->unlike }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                                        <a href="javascript:window.print()" class="btn btn-secondary"><i
                                                class="ri-printer-line align-bottom me-1"></i> Print</a>
                                        <a href="javascript:void(0);" class="btn btn-primary"><i
                                                class="ri-download-2-line align-bottom me-1"></i> Download</a>
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
@push('js')
@endpush
