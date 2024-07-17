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
    Governorate List
@endsection
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <h5 class="card-title mb-0 col-sm-8 col-md-8">Governorate List</h5>
                                {{-- Modal --}}
                                <div id="signupModals" class="modal fade" tabindex="-1" aria-hidden="true"
                                    style="display: none;">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 overflow-hidden">
                                            <div class="modal-header p-3">
                                                <h4 class="card-title mb-0">Add New Governorate</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="rounded-0 mb-0">
                                                <p class="mb-0"><span class="fw-semibold"></span></p>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('shipping.storeGovernorate') }}" method="POST">
                                                    @csrf
                                                    <div class="col-md-12">
                                                        <div class="mb-1" id="subsubcategories-container">
                                                            <h6 class="fw-semibold">Add New Governorate</h6>
                                                            <input type="text" class="form-control mb-2"
                                                                placeholder="Governorate Name ar" name="title_ar">
                                                            <input type="text" class="form-control mb-2"
                                                                placeholder="Governorate Name en" name="title_en">
                                                        </div>
                                                    </div>
                                                    <div class="text-end">
                                                        <button type="submit" class="btn btn-primary">Add</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Load More Buttons -->
                                <div class="mb-lg-1 mb-0 col-sm-2 col-md-3">
                                    <div class="row">
                                        <div class="d-flex">
                                            <button type="button" class="btn btn-success col-5 mx-1" data-bs-toggle="modal"
                                                data-bs-target="#signupModals"><i class='bx bx-add-to-queue'></i> Add
                                                New </button>
                                            {{-- <a href="{{ route('menuItem.archiveMenuItemList', $menu->id) }}" class="btn btn-primary mx-1"><i class='bx bxs-archive-in'></i></a> --}}
                                            <button type="submit"
                                                class="btn btn-outline-primary col-6 btn-icon waves-effect waves-light d-flex"
                                                id="refresh">
                                                <i class="ri-24-hours-fill"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="alert alert-secondary col-md-7 mx-auto alert-border-left alert-dismissible fade show"
                                    role="alert" id="alert" style="display: none">
                                    <i class="ri-check-double-line me-3 align-middle"></i> <strong id="strong"></strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body" style="overflow:auto">
                            <table id="alternative-pagination"
                                class="table nowrap dt-responsive align-middle table-hover table-bordered"
                                style="width:100%;overflow: scroll">
                                <thead>
                                    <tr>
                                        <th>#SSL</th>
                                        <th>Governorates</th>
                                        <th>View Area</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div>
    </div>
@endsection
@push('js')
    <script>
        var table = $('#alternative-pagination').DataTable({
            ajax: '{{ route('shipping.dataTable') }}',
            columns: [{
                    'data': null,
                    render: function(data, type, row, meta) {
                        // 'meta.row' is the index number
                        return meta.row + 1;
                    }
                },
                {
                    'data': null,
                    render: function(data) {
                        // Choose the appropriate name based on the selected language
                        var title = '{{ App::getLocale() == 'ar' ? 'title_ar' : 'title_en' }}';
                        return data[title];
                    }
                },
                {
                    'data': null,
                    render: function(data) {
                        var itemUrl = '{{ route('shipping.area', ':id') }}';

                        itemUrl = itemUrl.replace(':id', data.id);

                        var itemsButton = '<a href="' + itemUrl +
                            '"> <i class="bx bx-show btn btn-success"></i></a>';

                        return itemsButton;
                    }
                },
                {
                    'data': null,
                    render: function(data, row, type) {
                        if (data.status == 1) {
                            return `<label class="switch">
                                         <input type="checkbox" data-id="${data.id}" id="status" checked>
                                         <span class="slider round"></span>
                                    </label>`

                        } else {
                            return `<label class="switch">
                                         <input type="checkbox" data-id="${data.id}" id="status">
                                         <span class="slider round"></span>
                                    </label>`
                        }
                    }
                },
            ]
        });
    </script>
    <script>
        $(document).on('click', '#status', function() {
            var url = '{{ route('shipping.status', ':id') }}';
            url = url.replace(':id', $(this).data('id'));

            $.ajax({
                type: 'GET', // Use 'GET' instead of 'Get'
                url: url,
                success: function(response) {
                    toastr.success(response.message, 'تم بنجاح');
                    table.ajax.reload();
                },
                error: function(response) { // Use 'error' instead of 'errors'
                    toastr.error('أعد المحاولة', 'خطأ !');
                    table.ajax.reload();
                }
            });
        });

        $('#refresh').on('click', function() {
            $('#alert').css('display', 'none');
            table.ajax.reload();

        });

        // ...
    </script>
@endpush
