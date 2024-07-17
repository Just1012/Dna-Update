@extends('layouts.web')
@push('css')
    <link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('title')
    Area List
@endsection

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <h5 class="card-title mb-0 col-sm-8">

                                    {{-- {{ App::getLocale() == 'ar' ? $id->title_ar : $id->title_en }} / --}}
                                    <a href="{{ route('shipping.index') }}">Back</a>
                                </h5>
                                {{-- Modal --}}
                                <div id="signupModals" class="modal fade" tabindex="-1" aria-hidden="true"
                                    style="display: none;">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 overflow-hidden">
                                            <div class="modal-header p-3">
                                                <h4 class="card-title mb-0">Add New Area</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="rounded-0 mb-0">
                                                <p class="mb-0"><span class="fw-semibold"></span></p>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('shipping.storeArea') }}" method="POST">
                                                    @csrf
                                                    <input name="governorate_id" type="hidden" value="{{ $id }}">
                                                    <div class="col-md-12">
                                                        <div class="mb-1" id="subsubcategories-container">
                                                            <h6 class="fw-semibold">Add New Area</h6>
                                                            <input type="text" class="form-control mb-2" placeholder="Area Name ar" name="area_ar">
                                                            <input type="text" class="form-control mb-2" placeholder="Area Name en" name="area_en">
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
                                        <th>Area</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('web/assets/js/pages/select2.init.js') }}"></script>
    <script>
        // function toggleInput() {
        //     var select = document.getElementById("categories");
        //     var categoryId = select.value;

        //     var subcategoriesContainer = $('#items');
        //     var subcategoriesUrl = "{{ route('menuItem.getItem', ['id' => ':categoryId']) }}";

        //     subcategoriesUrl = subcategoriesUrl.replace(':categoryId', categoryId);

        //     $.ajax({
        //         url: subcategoriesUrl,
        //         type: 'GET',
        //         dataType: 'json',
        //         success: function(data) {
        //             subcategoriesContainer.empty();
        //             if (data && data.length > 0) {
        //                 var subcategoriesSelect = '<option value="" selected disabled>-- Select Item --</option>';
        //                 $.each(data, function(index, item) {
        //                     subcategoriesSelect += '<option value="' + item.id + '">' + ({{ App::getLocale() == 'ar' ? 'item.title_ar' : 'item.title_en' }}) + '</option>';
        //                 });
        //                 subcategoriesContainer.append(subcategoriesSelect);
        //             }
        //         },
        //         error: function(xhr, status, error) {
        //             // Optionally display an error message to the user
        //         }
        //     });
        // }

        var table = $('#alternative-pagination').DataTable({
            ajax: '{{ route('shipping.getArea', $id) }}',
            columns: [{
                    'data': null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    'data': null,
                    render: function(data) {
                        // Choose the appropriate name based on the selected language
                        var title = '{{ App::getLocale() == 'ar' ? 'area_ar' : 'area_en' }}';
                        return data[title];
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

        function openFullScreen(image) {
            var fullScreenContainer = document.createElement('div');
            fullScreenContainer.className = 'fullscreen-image';

            var fullScreenImage = document.createElement('img');
            fullScreenImage.src = image.src;

            fullScreenContainer.appendChild(fullScreenImage);
            document.body.appendChild(fullScreenContainer);

            fullScreenContainer.addEventListener('click', function() {
                document.body.removeChild(fullScreenContainer);
            });
        }
    </script>
    <script>
        $(document).on('click', '#status', function() {
            var url = '{{ route('shipping.areaStatus', ':id') }}';
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
