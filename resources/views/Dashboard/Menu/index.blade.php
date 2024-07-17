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
    Menu
@endsection
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <h5 class="card-title mb-0 col-sm-8 col-md-10">Menu</h5>

                                <div class="hstack flex-wrap gap-2   mb-lg-0 mb-0 col-sm-2 col-md-1">
                                    <a href="{{ route('menu.addMenu') }}"
                                        class="btn btn-outline-secondary btn-load">
                                        <span class="d-flex align-items-center">
                                            <span class="spinner-grow flex-shrink-0" role="status">
                                                <span class="visually-hidden">+</span>
                                            </span>
                                            <span class="flex-grow-1 ms-2">
                                                +
                                            </span>
                                        </span>
                                    </a>
                                </div>

                                <button type="submit"
                                    class="btn btn-outline-primary mb-0 col-sm-2 col-md-1 btn-icon waves-effect waves-light"
                                    id="refresh"><i class="ri-24-hours-fill"></i></button>


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
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Action</th>
                                        <th>Created At</th>
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
            ajax: '{{ route('menu.dataTable') }}',
            columns: [

                {
                    'data': null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },

                {
                    'data': null,
                    render: function(data, row) {
                        return `<img src="{{ asset('images') }}/${data.image}"
                                class="small-image" style="height: 50px; width: 50px" onclick="openFullScreen(this)">`;
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
                        var itemUrl = '{{ route('menuItem.index', ':id') }}';
                        var editUrl = '{{ route('menu.edit', ':id') }}';
                        var deleteUrl = '{{ route('menu.archive', ':id') }}';

                        itemUrl = itemUrl.replace(':id',data.id);
                        editUrl = editUrl.replace(':id', data.id);
                        deleteUrl = deleteUrl.replace(':id', data.id);

                        var editButton = '<a href="' + editUrl +
                            '"> <i class="bx bxs-edit btn btn-warning"></i></a>';
                        var deleteButton = '<a href="' + deleteUrl +
                            '"> <i class="bx bx-archive-in btn btn-primary"></i></a>';
                        var itemsButton = '<a href="' + itemUrl +
                            '"> <i class="bx bx-show btn btn-success"></i></a>';

                        return itemsButton + '' + editButton + '' + deleteButton;
                    }
                },


                {
                    'data': 'created_at',
                    render: function(data, type, row) {
                        // Parse the date string
                        var date = new Date(data);

                        // Check if the date is valid
                        if (!isNaN(date.getTime())) {
                            // Format the date as 'YYYY-MM-DD'
                            var year = date.getFullYear();
                            var month = (date.getMonth() + 1).toString().padStart(2,
                                '0'); // Months are zero-based
                            var day = date.getDate().toString().padStart(2, '0');

                            return year + '-' + month + '-' + day;
                        } else {
                            return 'لا يجود بيانات'; // Handle invalid date strings
                        }
                    }
                },
            ]
        });
    </script>

    <script>
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
@endpush
