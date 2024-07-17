@extends('layouts.web')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
@endpush
@section('title')
    Profile Page
@endsection
@section('content')
    <style>
        .fixed-size-img {
            width: 150px;
            /* Set the desired width */
            height: 150px;
            /* Set the desired height */
            object-fit: cover;
            /* Ensures the image covers the area without distortion */
        }

        .input-group {
            position: relative;
        }

        .code {
            position: absolute;
            left: 5px;
            top: 50%;
            transform: translateY(-20%);
            display: flex;
            align-items: center;
            color: #000;
            gap: 7px;
            padding-left: 20px;
            /* Adjust padding as needed */
        }

        .input-group-prepend {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 10px;
            /* Adjust left positioning as needed */
        }

        .code img {
            width: 25px;
            object-fit: cover;
        }

        #phonenumberInput {
            padding-left: 80px;
            /* Adjust to make room for the flag and code */
        }

        .position-relative {
            position: relative;
        }

        .input_password {
            padding-right: 40px;
            /* Adjust padding to make room for the icon */
        }

        .eyeicon {
            position: absolute;
            right: 10px;
            /* Adjust this value to position the icon correctly */
            top: 50%;
            transform: translateY(20%);
            cursor: pointer;
            width: 20px;
            /* Adjust size as needed */
            height: 20px;
            /* Adjust size as needed */
        }
    </style>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="position-relative mx-n4 mt-n4">
                    <div class="profile-wid-bg profile-setting-img">
                        <img src="{{ asset('web/assets/images/profile-bg.jpg') }}" class="profile-wid-img" alt="">
                        <div class="overlay-content">
                            <div class="text-end p-3">
                                <div class="p-0 ms-auto rounded-circle profile-photo-edit">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xxl-3">
                        <div class="card mt-n5">
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                        <img id="displayImage" src="{{ asset('images/' . auth()->user()->image) }}"
                                            class="rounded-circle avatar-xl img-thumbnail user-profile-image fixed-size-img"
                                            alt="user-profile-image">
                                        <div class="avatar-xs p-0 rounded-circle profile-photo-edit">

                                        </div>
                                    </div>
                                    <h5 class="fs-16 mb-1">{{ auth()->user()->name }}</h5>

                                </div>
                            </div>
                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-->
                    <div class="col-xxl-9">
                        <div class="card mt-xxl-n5">
                            <div class="card-header">
                                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails"
                                            role="tab">
                                            <i class="fas fa-home"></i> Personal Details
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                            <i class="far fa-user"></i> Change Password
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body p-4">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                        <form action="{{ route('profile.update', $user->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="firstnameInput" class="form-label">Name</label>
                                                        <input type="text" class="form-control" id="firstnameInput"
                                                            placeholder="Enter your Name" name="name"
                                                            value="{{ $user->name }}">
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="phonenumberInput" class="form-label phone">Phone
                                                            Number</label>
                                                        <span class="code">
                                                            <img src="{{ asset('front/images/الكويت.jpeg') }}"
                                                                alt="#">
                                                            +965
                                                        </span>
                                                        <input type="number" class="form-control" id="phonenumberInput"
                                                            placeholder="+(965) 12345678" name="phone"
                                                            value="{{ $user->phone }}">
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="imageInput" class="form-label">User Image</label>
                                                        <input type="file" class="dropify" data-height="100"
                                                            data-width="50" class="w-100" id="imageInput" accept="image/*"
                                                            name="image">
                                                    </div>
                                                </div>
                                                <!--end col-->

                                                <div class="col-lg-12">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="submit" class="btn btn-secondary">Updates</button>
                                                        <button type="button" class="btn btn-soft-danger">Cancel</button>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                            </div>
                                            <!--end row-->
                                        </form>
                                    </div>
                                    <!--end tab-pane-->
                                    <div class="tab-pane" id="changePassword" role="tabpanel">
                                        <form action="{{ route('profile.update', $user->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row g-2">
                                                <div class="col-lg-4">
                                                    <div class="position-relative">
                                                        <label for="oldpasswordInput" class="form-label">Old
                                                            Password*</label>
                                                        <input type="password" name="old_password"
                                                            class="form-control input_password" id="oldpasswordInput"
                                                            placeholder="Enter current password">
                                                        <img src="{{ asset('front/images/eye-close.png') }}"
                                                            class="eyeicon" alt="Toggle visibility">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="position-relative">
                                                        <label for="newpasswordInput" class="form-label">New
                                                            Password*</label>
                                                        <input type="password" name="new_password"
                                                            class="form-control input_password" id="newpasswordInput"
                                                            placeholder="Enter new password">
                                                        <img src="{{ asset('front/images/eye-close.png') }}"
                                                            class="eyeicon" alt="Toggle visibility">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="position-relative">
                                                        <label for="confirmpasswordInput" class="form-label">Confirm
                                                            Password*</label>
                                                        <input type="password" name="new_password_confirmation"
                                                            class="form-control input_password" id="confirmpasswordInput"
                                                            placeholder="Confirm password">
                                                        <img src="{{ asset('front/images/eye-close.png') }}"
                                                            class="eyeicon" alt="Toggle visibility">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="text-end">
                                                        <button type="submit" class="btn btn-secondary">Change
                                                            Password</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                    <!--end tab-pane-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->

            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('web/assets/js/pages/select2.init.js') }}"></script>
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
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let passwords = document.querySelectorAll('.input_password');
            let eyeIcons = document.querySelectorAll('.eyeicon');

            eyeIcons.forEach((eyeIcon, index) => {
                eyeIcon.addEventListener('click', () => {
                    let inputPass = eyeIcon.previousElementSibling;
                    if (inputPass.type === "password") {
                        inputPass.type = "text";
                        eyeIcon.setAttribute("src", "{{ asset('front/images/eye-open.png') }}");
                    } else {
                        inputPass.type = "password";
                        eyeIcon.setAttribute("src", "{{ asset('front/images/eye-close.png') }}");
                    }
                });
            });

            let inputPhone = document.querySelector('#phone');
            let phoneDiv = document.querySelector('.phone_inputs');
            inputPhone.addEventListener('focusin', () => {
                phoneDiv.style.border = '1px solid #EA6A12';
            });
            inputPhone.addEventListener('focusout', () => {
                phoneDiv.style.border = '1px solid #33333378';
            });

            inputPhone.addEventListener("input", () => {
                let phoneNumber = inputPhone.value;
                if (phoneNumber.length > 8) {
                    inputPhone.value = inputPhone.value.slice(0, 8);
                }
            });
        });
    </script>
@endpush
