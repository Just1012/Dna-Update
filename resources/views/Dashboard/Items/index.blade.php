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
    Items
@endsection
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <h5 class="card-title mb-0 col-sm-8 col-md-10"> Items </h5>

                                <!-- Load More Buttons -->
                                <div class="hstack flex-wrap gap-2   mb-lg-0 mb-0 col-sm-2 col-md-1">
                                    <a href="{{ route('item.addItem') }}" class="btn btn-outline-secondary btn-load">
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
                        <div class="card-body border border-dashed border-end-0 border-start-0">
                            <form id="filterForm" action="{{ route('item.filter') }}" method="GET">
                                <div class="row g-3">
                                    <div class="col-xxl-5 col-sm-6">

                                    </div>
                                    <!--end col-->
                                    <div class="col-xxl-2 col-sm-6">

                                    </div>
                                    <!--end col-->
                                    <div class="col-xxl-2 col-sm-3">
                                        <div>
                                            <select class="form-control" data-choices data-choices-search-false
                                                name="choices-single-default" id="category1">
                                                <option value="">-- Select Category --</option>
                                                @foreach ($category as $cate)
                                                    <option value="{{ $cate->id }}">{{ $cate->title_en }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-xxl-2 col-sm-3">
                                        <div>
                                            <select class="form-control" data-choices data-choices-search-false
                                                name="choices-single-default" id="subCategory">
                                                <option value="">-- Select Sub Category --</option>
                                                @foreach ($subCategory as $cate)
                                                    <option value="{{ $cate->id }}">{{ $cate->title_en }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-xxl-2 col-sm-3">
                                        <div>
                                            <select class="form-control" data-choices data-choices-search-false
                                                name="choices-single-default" id="subSubCategory">
                                                <option value="">-- Select Sub Sub Category --</option>
                                                @foreach ($subSubCategory as $cate)
                                                    <option value="{{ $cate->id }}">{{ $cate->title_en }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-xxl-1 col-sm-3">
                                        <div>
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="ri-equalizer-fill me-1 align-bottom"></i> Filters
                                            </button>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </form>
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
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#alternative-pagination').DataTable({
            ajax: '{{ route('item.filter') }}',
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
                    render: function(data, row) {
                        return `<img src="{{ asset('images') }}/${data.image}"
                                class="small-image" style="height: 50px; width: 50px" onclick="openFullScreen(this)">`;
                    }
                },

                {
                    'data': null,
                    render: function(data) {

                        var editUrl = '{{ route('item.edit', ':id') }}';
                        var deleteUrl = '{{ route('item.archive', ':id') }}';

                        editUrl = editUrl.replace(':id', data.id);
                        deleteUrl = deleteUrl.replace(':id', data.id);

                        var editButton = '<a href="' + editUrl +
                            '"> <i class="bx bxs-edit btn btn-warning"></i></a>';
                        var deleteButton = '<a href="' + deleteUrl +
                            '"> <i class="bx bx-archive-in btn btn-primary"></i></a>';

                        return editButton + '' + deleteButton;
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

        // Form submission for filtering
        $('#filterForm').submit(function(e) {
            e.preventDefault(); // Prevent form submission

            var category = $('#category1').val();

            var subCategory = $('#subCategory').val();
            var subSubCategory = $('#subSubCategory').val();

            // Send an AJAX request to fetch filtered data
            $.ajax({
                url: '{{ route('item.filter') }}',
                method: 'GET',
                data: {
                    category: category,
                    subCategory: subCategory,
                    subSubCategory: subSubCategory
                },
                success: function(response) {
                    table.clear().rows.add(response.data).draw(); // Update DataTable with new data
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
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
