@extends('layouts.web')
@push('css')
    <link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Bootstrap Css -->
@endpush

@section('title')
Coupons List
@endsection

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <h5 class="card-title mb-0 col-sm-8 col-md-10">Coupons List</h5>
                            <div class="hstack flex-wrap gap-2 mb-lg-0 mb-0 col-sm-2 col-md-1">
                                <button type="button" class="btn btn-outline-secondary btn-load" data-bs-toggle="modal" data-bs-target="#copuons_create">
                                    <span class="d-flex align-items-center">
                                        <span class="spinner-grow flex-shrink-0" role="status">
                                            <span class="visually-hidden">+</span>
                                        </span>
                                        <span class="flex-grow-1 ms-2">+</span>
                                    </span>
                                </button>
                            </div>
                            <button type="submit" class="btn btn-outline-primary mb-0 col-sm-2 col-md-1 btn-icon waves-effect waves-light" id="refresh">
                                <i class="ri-24-hours-fill"></i>
                            </button>
                            <div class="alert alert-secondary col-md-7 mx-auto alert-border-left alert-dismissible fade show" role="alert" id="alert" style="display: none">
                                <i class="ri-check-double-line me-3 align-middle"></i> <strong id="strong"></strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @if (session('error'))
                                <div class="alert alert-warning alert-border-left col-md-7 mx-auto alert-dismissible fade show" role="alert">
                                    <i class="ri-check-double-line me-3 align-middle"></i>
                                    <strong>{{ session('error') }}</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            @if (session('message'))
                                <div class="alert alert-secondary alert-border-left col-md-7 mx-auto alert-dismissible fade show" role="alert">
                                    <i class="ri-check-double-line me-3 align-middle"></i>
                                    <strong>{{ session('message') }}</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Modal Create Coupons -->
                        <div class="modal fade" id="copuons_create" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalgridLabel">Coupons</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('Coupons.store') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                @if (count($errors) > 0)
                                                <div class="alert alert-danger">
                                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                @endif

                                                <div class="col-xxl-6 col-md-6 my-2">
                                                    <div>
                                                        <label for="firstName" class="form-label">Name</label>
                                                        <input type="text" class="form-control" id="firstName" required name="name" placeholder="Enter Name" value="{{ old('name') }}">
                                                    </div>
                                                </div><!--end col-->
                                                <div class="col-xxl-6 col-md-6 my-2">
                                                    <div>
                                                        <label for="code" class="form-label">Code</label>
                                                        <input type="text" class="form-control" id="code" name="Code" value="{{ old('Code') }}" required placeholder="Enter code">
                                                    </div>
                                                </div><!--end col-->
                                                <div class="col-xxl-6 col-md-6 my-2">
                                                    <div>
                                                        <label for="DISCOUNT" class="form-label">DISCOUNT</label>
                                                        <input type="number" class="form-control" id="DISCOUNT" name="DISCOUNT" value="{{ old('DISCOUNT') }}" required placeholder="Enter DISCOUNT">
                                                    </div>
                                                </div><!--end col-->
                                                <div class="col-lg-6 col-md-6 my-2">
                                                    <label for="genderInput" class="form-label">DISCOUNT TYPE</label>
                                                    <div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="DISCOUNT_TYPE" id="inlineRadio1" {{ old('DISCOUNT_TYPE')==0 ? 'checked' : '' }} value="0">
                                                            <label class="form-check-label" for="inlineRadio1">Fixed</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="DISCOUNT_TYPE" id="inlineRadio2" {{ old('DISCOUNT_TYPE')==1 ? 'checked' : '' }} value="1">
                                                            <label class="form-check-label" for="inlineRadio2">Percentage</label>
                                                        </div>
                                                    </div>
                                                </div><!--end col-->
                                                <div class="col-lg-6 col-md-6 my-2">
                                                    <div class="mt-3">
                                                        <label class="form-label mb-0">START DATE</label>
                                                        <input type="date" required name="start_date" class="form-control" value="{{ old('start_date') }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 my-2">
                                                    <div class="mt-3">
                                                        <label class="form-label mb-0">END DATE</label>
                                                        <input type="date" required name="end_date" class="form-control" value="{{ old('end_date') }}">
                                                    </div>
                                                </div>
                                                <div class="col-xxl-6 col-md-6 my-2">
                                                    <div>
                                                        <label for="amount_order" class="form-label">MINIMUM ORDER AMOUNT</label>
                                                        <input type="number" required class="form-control" id="amount_order" name="MINIMUM_ORDER_AMOUNT" value="{{ old('MINIMUM_ORDER_AMOUNT') }}">
                                                    </div>
                                                </div><!--end col-->
                                                <div class="col-xxl-6 col-md-6 my-2">
                                                    <div>
                                                        <label for="MAXIMUM_DISCOUNT" class="form-label">MAXIMUM DISCOUNT</label>
                                                        <input type="number" required class="form-control" id="MAXIMUM_DISCOUNT" name="MAXIMUM_DISCOUNT" value="{{ old('MAXIMUM_DISCOUNT') }}">
                                                    </div>
                                                </div><!--end col-->
                                                <div class="col-xxl-6 col-md-6 my-2">
                                                    <div>
                                                        <label for="LIMIT_PER_USER" class="form-label">LIMIT PER USER</label>
                                                        <input type="number" required class="form-control" id="LIMIT_PER_USER" name="LIMIT_PER_USER" value="{{ old('LIMIT_PER_USER') }}">
                                                    </div>
                                                </div><!--end col-->
                                                <div class="col-lg-6 mt-3">
                                                    <h6 class="fw-semibold">Programs Select</h6>
                                                    <select class="js-example-basic-multiple form-control" style="" id="mySelect2" name="programs[]" multiple="multiple">
                                                        <optgroup label="Programs select">
                                                            @foreach($programs as $key => $value)
                                                            <option value="{{$value->id}}">{{$value->title_ar}}</option>
                                                            @endforeach
                                                        </optgroup>

                                                    </select>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </div><!--end col-->
                                            </div><!--end row-->
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Modal Create Coupons -->










                        <div class="modal fade copuons_edita" id="update" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalgridLabel">Coupons</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="" method="POST" id="update-form">
                                            @csrf
                                            @method('put')
                                            <div class="row">
                                                @if (count($errors) > 0)
                                                <div class="alert alert-danger">
                                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                @endif
                                                <input type="hidden" name="id" id="id">

                                                <div class="col-xxl-6 col-md-6 my-2">
                                                    <div>
                                                        <label for="name" class="form-label">Name</label>
                                                        <input type="text" class="form-control" id="name_up" required name="name" placeholder="Enter Name">
                                                    </div>
                                                </div><!--end col-->
                                                <div class="col-xxl-6 col-md-6 my-2">
                                                    <div>
                                                        <label for="code" class="form-label">Code</label>
                                                        <input type="text" class="form-control" id="code_up" name="Code" required placeholder="Enter code">
                                                    </div>
                                                </div><!--end col-->
                                                <div class="col-xxl-6 col-md-6 my-2">
                                                    <div>
                                                        <label for="DISCOUNT" class="form-label">DISCOUNT</label>
                                                        <input type="number" class="form-control" id="DISCOUNT_up" name="DISCOUNT" required placeholder="Enter DISCOUNT">
                                                    </div>
                                                </div><!--end col-->
                                                <div class="col-lg-6 col-md-6 my-2">
                                                    <label for="genderInput" class="form-label">DISCOUNT TYPE</label>
                                                    <div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="DISCOUNT_TYPE" id="inlineRadio1" value="0">
                                                            <label class="form-check-label" for="inlineRadio1">Fixed</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="DISCOUNT_TYPE" id="inlineRadio2" value="1">
                                                            <label class="form-check-label" for="inlineRadio2">Percentage</label>
                                                        </div>
                                                    </div>
                                                </div><!--end col-->
                                                <div class="col-lg-6 col-md-6 my-2">
                                                    <div class="mt-3">
                                                        <label class="form-label mb-0">START DATE</label>
                                                        <input type="date" required name="start_date" class="form-control" id="start_date_up">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 my-2">
                                                    <div class="mt-3">
                                                        <label class="form-label mb-0">END DATE</label>
                                                        <input type="date" required name="end_date" class="form-control" id="end_date_up">
                                                    </div>
                                                </div>
                                                <div class="col-xxl-6 col-md-6 my-2">
                                                    <div>
                                                        <label for="amount_order" class="form-label">MINIMUM ORDER AMOUNT</label>
                                                        <input type="number" required class="form-control" id="amount_order_up" name="MINIMUM_ORDER_AMOUNT">
                                                    </div>
                                                </div><!--end col-->
                                                <div class="col-xxl-6 col-md-6 my-2">
                                                    <div>
                                                        <label for="MAXIMUM_DISCOUNT" class="form-label">MAXIMUM DISCOUNT</label>
                                                        <input type="number" required class="form-control" id="MAXIMUM_DISCOUNT_up" name="MAXIMUM_DISCOUNT">
                                                    </div>
                                                </div><!--end col-->
                                                <div class="col-xxl-6 col-md-6 my-2">
                                                    <div>
                                                        <label for="LIMIT_PER_USER" class="form-label">LIMIT PER USER</label>
                                                        <input type="number" required class="form-control" id="LIMIT_PER_USER_up" name="LIMIT_PER_USER">
                                                    </div>
                                                </div><!--end col-->
                                                <div class="col-lg-6 mt-3">
                                                    <h6 class="fw-semibold">Programs Select</h6>
                                                    <select class="js-example-basic-multiple form-control myselect11 text-black" id="programs_up" name="programs[]" multiple="multiple">
                                                        <optgroup label="Programs select">
                                                            @foreach($programs as $program)
                                                                <option value="{{ $program->id }}">{{ $program->title_ar }}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    </select>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal"><i class='bx bx-window-close'></i></button>
                                                        <button type="submit" class="btn btn-primary"><i class='bx bxs-edit-alt'></i></button>
                                                    </div>
                                                </div><!--end col-->
                                            </div><!--end row-->
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- Table -->
                        <table id="alternative-pagination" class="table nowrap dt-responsive align-middle table-hover table-bordered" style="width:100%;overflow: scroll">
                            <thead>
                                <tr>
                                    <th>NAME</th>
                                    <th>CODE</th>
                                    <th>DISCOUNT</th>
                                    <th>DISCOUNT TYPE</th>
                                    <th>START DATE</th>
                                    <th>END DATE</th>
                                    <th>STATUS</th>
                                    <th>EDIT</th>
                                </tr>
                            </thead>
                            <tbody class="text-center"></tbody>
                        </table><!-- End Table -->
                    </div>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </div>
</div>

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        var table = $('#alternative-pagination').DataTable({
            ajax: "{{ route('Coupons.datatable') }}",
            columns: [
                { 'data': 'name' },
                { 'data': 'code' },
                { 'data': 'discount' },
                {
                    'data': null,
                    render:function(data){
                        return data.discount_type == 0 ? "Fixed" : "Percentage";
                    }
                },
                { 'data': 'start_date' },
                { 'data': 'end_date' },
                {
                    'data': null,
                    render: function(data) {
                        var statusChecked = data.status == 1 ? 'checked' : '';
                        return `<label class="switch">
                                    <input type="checkbox" data-id="${data.id}" id="status" ${statusChecked}>
                                    <span class="slider round"></span>
                                </label>`;
                    }
                },
                {
    'data': null,
    render: function(data) {
        var editButton = `
            <button
                data-bs-toggle="modal"
                data-bs-target="#update"
                class="btn btn-warning edit-btn"
                data-id="${data.id}"
                data-name="${data.name}"
                data-code="${data.code}"
                data-discount="${data.discount}"
                data-discount_type="${data.discount_type}"
                data-start_date="${data.start_date}"
                data-end_date="${data.end_date}"
                data-minimum_order="${data.minimum_order}"
                data-maximum_discount="${data.maximum_discount}"
                data-limit_per_user="${data.limit_per_user}"
                data-programs_ids='${data.programs_ids}'>
                <i class="bx bxs-edit"></i>
            </button>`;
        return editButton;
    }
}


            ]
        });

        $(document).on('click', '#status', function() {
            $.ajax({
                type: "put",
                url: "{{ route('Coupons.status') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': $(this).data('id')
                },
                success: function(response) {
                    $('#alert').css('display', 'block');
                    $('#strong').text(response.message);
                    table.ajax.reload();
                }
            });
        });

        $('#refresh').on('click', function() {
            $('#alert').css('display', 'none');
            table.ajax.reload();
        });
        document.addEventListener('DOMContentLoaded', function () {
    $(document).on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var code = $(this).data('code');
        var discount = $(this).data('discount');
        var discount_type = $(this).data('discount_type');
        var start_date = $(this).data('start_date');
        var end_date = $(this).data('end_date');
        var minimum_order = $(this).data('minimum_order');
        var maximum_discount = $(this).data('maximum_discount');
        var limit_per_user = $(this).data('limit_per_user');
        var programs_ids = $(this).data('programs_ids');


        // Populate the modal with the data from the button
        $('#id').val(id);
        $('#name_up').val(name);
        $('#code_up').val(code);
        $('#DISCOUNT_up').val(discount);
        $('input[name="DISCOUNT_TYPE"][value="' + discount_type + '"]').prop('checked', true);
        $('#start_date_up').val(start_date);
        $('#end_date_up').val(end_date);
        $('#amount_order_up').val(minimum_order);
        $('#MAXIMUM_DISCOUNT_up').val(maximum_discount);
        $('#LIMIT_PER_USER_up').val(limit_per_user);

        // Set the selected programs
        $('#programs_up').val(programs_ids).trigger('change');
        // Change the form action to the update route with the specific ID
        var url_selling = '{{ route("Coupons.update", ":id") }}'.replace(':id', id);
        $('#update-form').attr('action', url_selling);
    });
});
    </script>
       <script>
           $('#mySelect2').select2({
               dropdownParent: $('#copuons_create'),
               templateResult: function(state) {
            if (!state.id) {
                return state.text;
            }
            var $state = $(
                '<span style="color: black;">' + state.text + '</span>'
            );
            return $state;
        },
        templateSelection: function(state) {
            return $('<span style="color: black;">' + state.text + '</span>');
        }
           });
           $('.myselect11').select2({
               dropdownParent: $('.copuons_edita'),
               templateResult: function(state) {
            if (!state.id) {
                return state.text;
            }
            var $state = $(
                '<span style="color: black;">' + state.text + '</span>'
            );
            return $state;
        },
        templateSelection: function(state) {
            return $('<span style="color: black;">' + state.text + '</span>');
        }
           });
       </script>

@endpush
