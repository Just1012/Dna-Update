@extends('layouts.front')
@section('title', trans('messages.profile'))
@push('css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
@endpush
@section('content')
    @include('layouts.ex_front.header')
    <style>
        .dropify-wrapper .dropify-message p {
            font-size: 16px;
        }

        .dropify-wrapper .dropify-message .dropify-error {
            font-size: 16px;
        }

        .dropify-wrapper .dropify-clear,
        .dropify-wrapper .dropify-preview .dropify-render .dropify-infos .dropify-infos-inner .dropify-filename,
        .dropify-wrapper .dropify-preview .dropify-render .dropify-infos .dropify-infos-inner .dropify-infos-message {
            font-size: 16px;
        }
    </style>
    <section class="Profile" id="Profile">
        <div class="container">
            <div class="content d-flex justify-content-between align-items-start flex-wrap">
                <div class="userInfo">
                    <div class="image">
                        <img src="{{ asset('images/' . $user->image) }}" alt="" id="displayImage">
                    </div>
                    <div class="info text-center mt-3">
                        <h5>{{ auth()->user()->name }}</h5>
                    </div>
                </div>
                <div class="userdetails">
                    <ul class="tabs d-flex justify-content-start gap-3">
                        <li data-choose=".programs_details" class="active">{{ trans('messages.programs_details') }}</li>
                        <li data-choose=".personal_details">{{ trans('messages.personal_details') }}</li>
                        <li data-choose=".change_passwords">{{ trans('messages.change_passwords') }}</li>
                    </ul>
                    <div class="contentUserDetails">
                        <div class="container">
                            <div class="Content programs_details">
                                <div class="orders d-flex justify-content-start align-items-center flex-wrap gap-3">
                                    @foreach ($order as $value)
                                        <div class="order">
                                            <div class="title">
                                                <h5>{{ trans('messages.order_no') }} : {{ $value->id }}</h5>
                                            </div>
                                            <div class="icon" title="{{ trans('messages.view_details') }}" data-order-id="{{ $value->id }}"
                                                data-bs-toggle="modal" data-bs-target="#orderModal">
                                                <i class="fa-solid fa-eye"></i>
                                            </div>
                                            <div class="date">
                                                <h3>{{ trans('messages.start_date') }} : <span>{{ $value->start_date }}</span></h3>
                                                <h3>{{ trans('messages.end_date') }} : <span>{{ $value->end_date }}</span></h3>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="Content personal_details" style="display: none;">
                                <form action="{{ route('front.user.update', $user->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="name_phone_inputs d-flex justify-content-start flex-wrap">
                                        <div class="input">
                                            <label for="fName" class="d-block">{{ trans('messages.first_name') }}</label>
                                            <input type="text" class="w-100" name="name" value="{{ $user->name }}"
                                                id="fName">
                                        </div>
                                        <div class="phone_inputs">
                                            <div class="input">
                                                <span class="code">
                                                    <img src="{{ asset('front/images/الكويت.jpeg') }}" alt="#">
                                                    +965
                                                </span>
                                                <input value="{{ $user->phone }}" type="number" name="phone"
                                                    id="phone" inputmode="numeric" pattern="[0-9]" required
                                                    max="99999999">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="image_input justify-content-start flex-wrap mt-2">
                                        <div class="input">
                                            <label for="imageInput" class="d-block">{{ trans('messages.image') }}</label>
                                            <input type="file" class="dropify" data-height="100" data-width="50"
                                                class="w-100" id="imageInput" accept="image/*" name="image">
                                        </div>
                                    </div>
                                    <input type="submit" value="{{ trans('messages.update') }}">
                                </form>
                            </div>
                            <div class="Content change_passwords" style="display: none;">
                                <form action="{{ route('front.user.update', $user->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="password d-flex justify-content-start flex-wrap mt-3 flex-column">
                                        <div class="input mb-3">
                                            <label for="oldPass" class="d-block">{{ trans('messages.old_password') }}</label>
                                            <input type="password" name="old_password" class="w-100 input_password"
                                                id="oldPass">
                                            <div class="image">
                                                <img src="{{ asset('front/images/eye-close.png') }}" class="eyeicon">
                                            </div>
                                        </div>
                                        <div class="input mb-3">
                                            <label for="newPass" class="d-block">{{ trans('messages.new_password') }}</label>
                                            <input type="password" name="new_password" class="w-100 input_password"
                                                id="newPass">
                                            <div class="image">
                                                <img src="{{ asset('front/images/eye-close.png') }}" class="eyeicon">
                                            </div>
                                        </div>
                                        <div class="input mb-3">
                                            <label for="cPass" class="d-block">{{ trans('messages.confirm_password') }}</label>
                                            <input name="new_password_confirmation" type="password"
                                                class="w-100 input_password" id="cPass">
                                            <div class="image">
                                                <img src="{{ asset('front/images/eye-close.png') }}" class="eyeicon">
                                            </div>
                                        </div>
                                    </div>
                                    <input type="submit" value="{{ trans('messages.edit') }}">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Extra Large modal example -->
        <div class="modal fade bs-example-modal-xl" id="orderModal" tabindex="-1" role="dialog"
            aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myExtraLargeModalLabel">{{ trans('messages.order_details') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-lg-12">
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-lg-2 col-6">
                                        <p class="text-muted mb-2 text-uppercase fw-semibold">{{ trans('messages.order_no') }}</p>
                                        <h5 class="fs-14 mb-0">#VL<span id="invoice-no"></span></h5>
                                    </div>
                                    <div class="col-lg-3 col-6">
                                        <p class="text-muted mb-2 text-uppercase fw-semibold">{{ trans('messages.order_created_date') }}</p>
                                        <h5 class="fs-14 mb-0"><span id="invoice-date"></span> <small class="text-muted"
                                                id="invoice-time"></small></h5>
                                    </div>
                                    <div class="col-lg-3 col-6">
                                        <p class="text-muted mb-2 text-uppercase fw-semibold">{{ trans('messages.payment_status') }}</p>
                                        <span class="badge bg-success-subtle text-success fs-11"
                                            id="payment-status"></span>
                                    </div>
                                    <div class="col-lg-2 col-6">
                                        <p class="text-muted mb-2 text-uppercase fw-semibold">{{ trans('messages.program_name') }}</p>
                                        <h5 class="fs-14 mb-0" id="program-name"></h5>
                                    </div>
                                    <div class="col-lg-2 col-6">
                                        <p class="text-muted mb-2 text-uppercase fw-semibold">{{ trans('messages.total_amount') }}</p>
                                        <h5 class="fs-14 mb-0">$<span id="total-amount"></span></h5>
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="row" id="address-details">
                                        <!-- Address details will be dynamically populated here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg">
                            <div class="card-body p-4">
                                <div class="table-responsive mb-5">
                                    <h5>{{ trans('messages.meals_selected') }}</h5>
                                    <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                        <thead>
                                            <tr class="table-active">
                                                <th scope="col" style="width: 50px;">#</th>
                                                <th scope="col">{{ trans('messages.meal_name') }}</th>
                                                <th scope="col">{{ trans('messages.type') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="meals-list">
                                            <!-- Meals will be dynamically populated here -->
                                        </tbody>
                                    </table>
                                </div>
                                <div class="table-responsive">
                                    <h5>{{ trans('messages.items_not_like') }}</h5>
                                    <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                        <thead>
                                            <tr class="table-active">
                                                <th scope="col" style="width: 50px;">#</th>
                                                <th scope="col">{{ trans('messages.image') }}</th>
                                                <th scope="col">{{ trans('messages.items_not_like') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="items-list">
                                            <!-- Items will be dynamically populated here -->
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-4">
                                    <div class="alert alert-danger">
                                        <p class="mb-0"><span class="fw-semibold">{{ trans('messages.vulnerability') }} : </span> <span
                                                id="note-vulnerability"></span></p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <div class="alert alert-info">
                                        <p class="mb-0"><span class="fw-semibold">{{ trans('messages.unlike') }} : </span> <span
                                                id="note-unlike"></span></p>
                                    </div>
                                </div>
                                <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                                    <a href="javascript:window.print()" class="btn btn-secondary"><i
                                            class="ri-printer-line align-bottom me-1"></i> {{ trans('messages.print') }}</a>
                                    <a href="javascript:void(0);" class="btn btn-primary"><i
                                            class="ri-download-2-line align-bottom me-1"></i> {{ trans('messages.download') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection
    @push('js')
        <script src="{{ asset('front/js/bootstrap.bundle.js') }}"></script>
        <script src="{{ asset('front/js/main.js') }}"></script>
        <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>

        <script>
            $('.dropify').dropify({
                messages: {
                    'default': 'Drag and drop a file here or click',
                    'replace': 'Drag and drop or click to replace',
                    'remove': 'Remove',
                    'error': 'Ooops, something wrong happended.'
                }
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const tabs = document.querySelectorAll('.tabs li');
                const content = document.querySelectorAll('.contentUserDetails .Content');

                // Show the default active tab's content on page load
                content.forEach(con => {
                    if (con.classList.contains('programs_details')) {
                        con.style.display = 'block';
                    } else {
                        con.style.display = 'none';
                    }
                });

                tabs.forEach(tab => {
                    tab.addEventListener('click', function() {
                        handleActive(this);
                        manageContent(this.dataset.choose);
                    });
                });

                function handleActive(tab) {
                    tabs.forEach(tab => {
                        tab.classList.remove('active');
                    });
                    tab.classList.add('active');
                }

                function manageContent(selector) {
                    content.forEach(con => {
                        con.style.display = 'none';
                    });
                    document.querySelector(selector).style.display = "block";
                }

                const imageInput = document.getElementById('imageInput');
                const displayImage = document.getElementById('displayImage');

                imageInput.addEventListener('change', (e) => {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            displayImage.src = e.target.result;
                        }
                        reader.readAsDataURL(file);
                    }
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                $('.icon').on('click', function() {
                    var orderId = $(this).data('order-id');

                    // Make AJAX request to get order details
                    $.ajax({
                        url: '/getOrderData/' + orderId,
                        method: 'GET',
                        success: function(response) {
                            console.log(response
                                .address_details); // Log the response to check its structure

                            // Populate modal fields with response data
                            $('#invoice-no').text(response.id);
                            $('#invoice-date').text(response.date);
                            $('#invoice-time').text(response.time);
                            $('#payment-status').text(response.payment_status);
                            $('#program-name').text(response.program_name);
                            $('#total-amount').text(response.total_amount);

                            // Address details
                            var addressDetails = '';
                            response.address_details.forEach(function(detail) {
                                addressDetails += '<div class="col-md-6 mt-sm-5 mt-4">';
                                addressDetails +=
                                    '<p class="text-muted mb-1">{{ App::getLocale() == 'ar' ? 'المحافظة' : 'Governorate' }} : ' + detail
                                    .governorate + '</p>';
                                addressDetails += '<p class="text-muted mb-1">{{ App::getLocale() == 'ar' ? 'المدينة' : 'Area' }} : ' +
                                    detail.area + '</p>';
                                addressDetails +=
                                    '<h6 class="text-muted text-uppercase fw-semibold">{{ trans('messages.address') }}</h6>';
                                addressDetails += '<p class="text-muted mb-1">' + detail
                                    .address + '</p>';


                                if (Array.isArray(detail.days3)) {
                                    const days = detail.days3.filter(day => typeof day ===
                                        'string');
                                    addressDetails += '<p class="text-muted mb-0">{{ trans('messages.days') }}: ' +
                                        days.join(', ') + '</p>';
                                } else if (typeof detail.days3 === 'object') {
                                    const days = Object.values(detail.days3).filter(day =>
                                        typeof day === 'string');
                                    addressDetails += '<p class="text-muted mb-0">{{ trans('messages.days') }}: ' +
                                        days.join(', ') + '</p>';
                                } else if (typeof detail.days3 === 'string') {
                                    addressDetails += '<p class="text-muted mb-0">{{ trans('messages.days') }}: ' +
                                        detail.days3 + '</p>';
                                } else {
                                    addressDetails += '<p class="text-muted mb-0">{{ trans('messages.days') }}: ' +
                                        JSON.stringify(detail.days3) + '</p>';
                                }

                                addressDetails += '</div>';
                            });
                            $('#address-details').html(addressDetails);



                            // Meals list
                            var mealsList = '';
                            response.meals.forEach(function(meal, index) {
                                mealsList += '<tr>';
                                mealsList += '<td>' + (index + 1) + '</td>';
                                mealsList += '<td>' + meal.name + '</td>';
                                mealsList += '<td>' + (meal.type == 1 ? 'Main' : 'Sub') +
                                    '</td>';
                                mealsList += '</tr>';
                            });
                            $('#meals-list').html(mealsList);

                            // Items list
                            var itemsList = '';
                            response.items.forEach(function(item, index) {
                                itemsList += '<tr>';
                                itemsList += '<td>' + (index + 1) + '</td>';
                                itemsList +=
                                    '<td><img style="width: 50px; height: 50px; border-radius: 50%;" src="' +
                                    item.image + '" alt="Image"></td>';
                                itemsList += '<td>' + item.name + '</td>';
                                itemsList += '</tr>';
                            });
                            $('#items-list').html(itemsList);

                            // Vulnerability and Unlike notes
                            $('#note-vulnerability').text(response.vulnerability);
                            $('#note-unlike').text(response.unlike);
                        },
                        error: function() {
                            alert('Failed to fetch order data.');
                        }
                    });
                });
            });
        </script>

        <script>
            document.getElementById('togglePassword').addEventListener('change', function() {
                const passwordFields = document.querySelectorAll('#oldPass, #newPass, #cPass');
                passwordFields.forEach(field => {
                    field.type = this.checked ? 'text' : 'password';
                });
            });
        </script>

        <script>
            let passwords = document.querySelectorAll('.input_password')
            let eyeIcons = document.querySelectorAll('.eyeicon');

            eyeIcons.forEach((eyeIcon, index) => {
                let inputPass = passwords[index];
                eyeIcon.addEventListener('click', () => {
                    if (inputPass.type == "password") {
                        inputPass.type = "text"
                        eyeIcon.setAttribute("src", "{{ asset('front/images/eye-open.png') }}")
                    } else {
                        inputPass.type = "password";
                        eyeIcon.setAttribute("src", "{{ asset('front/images/eye-close.png') }}");
                    }
                })
            })


            let inputPhone = document.querySelector('#phone');
            let phoneDiv = document.querySelector('.phone_inputs');
            inputPhone.addEventListener('focusin', () => {
                phoneDiv.style.border = '1px solid #295E4E';
            })
            inputPhone.addEventListener('focusout', () => {
                phoneDiv.style.border = '1px solid #33333378';
            })

            inputPhone.addEventListener("input", () => {
                let phoneNumber = inputPhone.value;
                if (phoneNumber.length > 8) {
                    inputPhone.value = inputPhone.value.slice(0, 8);
                }
            });
        </script>
    @endpush
