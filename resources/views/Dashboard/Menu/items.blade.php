@extends('layouts.web')
@push('css')

<link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
<!--datatable css-->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
<!--datatable responsive css-->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<!-- Bootstrap Css -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('title')
{{ App::getLocale() == 'ar' ? $menu->title_ar : $menu->title_en }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <h5 class="card-title mb-0 col-sm-8 ">{{ App::getLocale() == 'ar' ? $menu->title_ar : $menu->title_en }} /
                                    <a href="{{ route('menu.index') }}"> Back</a>
                                </h5>

                                {{-- Modal  --}}
                                <div id="signupModals" class="modal fade" tabindex="-1" aria-hidden="true"
                                    style="display: none;">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 overflow-hidden">
                                            <div class="modal-header p-3">
                                                <h4 class="card-title mb-0">Add New Item</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="rounded-0 mb-0">
                                                <p class="mb-0"> <span class="fw-semibold"></span> </p>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('menuItem.storeItem') }}" method="POST">
                                                    @csrf
                                                    <input name="menu_id" type="hidden" value="{{ $menu->id }}">
                                                    <div class="col-md-12">
                                                        <div class="mb-1">
                                                            <h6 class="fw-semibold">Categories</h6>
                                                            <select class="form-control" id="categories"
                                                                onchange="toggleInput()" name="category_id">
                                                                <optgroup label="Stages">
                                                                    <option value="" disabled selected>-- Select Category --
                                                                    </option>
                                                                    @foreach ($category as $cate)
                                                                        <option value="{{ $cate->id }}">
                                                                            {{ App::getLocale() == 'ar' ? $cate->title_ar : $cate->title_en }}
                                                                        </option>
                                                                    @endforeach
                                                                </optgroup>
                                                            </select>
                                                        </div>
                                                    </div><!--end col-->
                                                    <div class="col-md-12">
                                                        <div class="mb-1" id="subsubcategories-container">
                                                            <h6 class="fw-semibold">Items</h6>
                                                            <select  class="form-control"
                                                                id="items" name="item_id"  required>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="text-end">
                                                        <button type="submit" class="btn btn-primary">Add</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->

                                <!-- Load More Buttons -->
                                <div class="mb-lg-1 mb-0 col-sm-2 col-md-3">
                                    <div class="row  ">
                                    <div class="d-flex">
                                        <button type="button" class="btn btn-success  col-5 mx-1 " data-bs-toggle="modal"
                                        data-bs-target="#signupModals"><i class='bx bx-add-to-queue'></i> Add New</button>
                                        <a href="{{ route('menuItem.archiveMenuItemList',$menu->id) }}" class="btn btn-primary mx-1 "><i class='bx bxs-archive-in' ></i></a>
                                    <button
                                       type="submit"
                                        class="btn btn-outline-primary col-6  btn-icon waves-effect waves-light d-flex"
                                        id="refresh">
                                        <i class="ri-24-hours-fill "></i>
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

                                        <th>Title(EN)</th>
                                        <th>Title(AR)</th>
                                        <th>Image</th>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('web/assets/js/pages/select2.init.js') }}"></script>

    <script>
        function toggleInput() {
                var select = document.getElementById("categories");
                var categoryId = select.value;

                var subcategoriesContainer = $('#items');
                var subcategoriesUrl = "{{ route('menuItem.getItem', ['id' => ':categoryId']) }}";

                // Replace :categoryId with the actual category ID
                subcategoriesUrl = subcategoriesUrl.replace(':categoryId', categoryId);

                $.ajax({
                    url: subcategoriesUrl,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Clear previous subcategories
                        subcategoriesContainer.empty();
                        // Append new subcategories dropdown if there are subcategories
                        if (data && data.length > 0) {
                            var subcategoriesSelect = '';
                            subcategoriesSelect +=
                                '<option value="" selected disabled>-- Select Item --</option>';
                            $.each(data, function(index, item) {

                                subcategoriesSelect += '<option value="' + item.id +
                                    '"' + '>' +
                                    (
                                        {{ App::getLocale() == 'ar' ? 'item.title_ar' : 'item.title_en' }}
                                    ) +
                                    '</option>';
                            });


                            subcategoriesContainer.append(subcategoriesSelect);
                            // Bind change event using delegation

                        }
                    },
                    error: function(xhr, status, error) {
                        // Optionally display an error message to the user
                    }
                });
            }
    </script>

    <script>
        var table = $('#alternative-pagination').DataTable({
            ajax: '{{ route('menu.getItems', $menu->id) }}',
            columns: [

                {
                    'data': null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },


{
    'data': null,
    render: function(data) {
        return data.item1 && data.item1.title_en ? data.item1.title_en : '';
    }
},
{
    'data': null,
    render: function(data) {
        return data.item1 && data.item1.title_ar ? data.item1.title_ar : '';
    }
},
{
    'data': null,
    render: function(data) {
        if (data.item1 && data.item1.image) {
            return `<img src="{{ asset('images') }}/${data.item1.image}" class="small-image" style="height: 50px; width: 50px" onclick="openFullScreen(this)">`;
        }
        return ''; // Return empty string if image is not set
    }
},

                {
                    'data': null,
                    render: function(data) {
                        console.log(data);
                        var url = '{{ route('menuItem.archive', ':id') }}';
                        url = url.replace(':id', data.id);
                        return '<a href="' + url +
                            '"> <i class="bx bx-archive-in btn btn-primary"></i></a>';
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
