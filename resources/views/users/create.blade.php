@extends('layouts.web')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
@endpush
@section('title')
    Create New Category
@endsection
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="col-md-9 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Create New Category</h4>
                        <div class="card-body ">
                            <div class="listjs-table" id="customerList">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        <div>
                                            <a class="btn btn-success add-btn" id="create-btn"
                                                href="{{ route('admins.list') }}">Back</a>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('admins.storeUser') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                        <!-- Name Field -->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="nameInput" class="form-label">Name</label>
                                                <input type="text" class="form-control" name="name" placeholder="Name"
                                                    id="nameInput" required>
                                            </div>
                                        </div>

                                        <!-- Phone Field -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="phoneInput" class="form-label">Phone</label>
                                                <input type="text" class="form-control" name="phone"
                                                    placeholder="Phone (8 digits)" id="phoneInput" pattern="\d{8}" required>
                                            </div>
                                        </div>

                                        <!-- Image Upload Field -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="imageInput" class="form-label">Image</label>
                                                <input type="file" class="form-control" name="image" id="imageInput">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <h6 class="fw-semibold">Role</h6>
                                                <select class="js-example-basic-multiple" id="categories"
                                                    name="role_id">
                                                    <optgroup label="Stages">
                                                        <option value="" disabled selected>Select Role
                                                        </option>
                                                        @foreach ($roles as $role)
                                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div><!--end col-->

                                        <!-- Password Field -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="passwordInput" class="form-label">Password</label>
                                                <input type="password" class="form-control" name="password"
                                                    placeholder="Password" id="passwordInput" required>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="col-lg-12">
                                            <div>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div><!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('web/assets/js/pages/select2.init.js') }}"></script>
@endpush
