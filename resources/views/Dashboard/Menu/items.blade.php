@extends('layouts.web')
@push('css')



<!-- Bootstrap Css -->
<link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">

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
                            <h5 class="card-title mb-0 col-sm-8 ">{{ App::getLocale() == 'ar' ? $menu->title_ar :
                                $menu->title_en }} /
                                <a href="{{ route('menu.index') }}"> Back</a>
                            </h5>






                            <!-- Load More Buttons -->
                            <div class="mb-lg-1 mb-0 col-sm-2 col-md-3">
                                <div class="row">
                                    <div class="d-flex">


                                                <a href="{{ route('create.items.for.menu',$menu->id) }}"
                                                    class="btn btn-success  col-5 mx-1 "><i class='bx bx-add-to-queue'></i> Add New</a>
                                        <a href="{{ route('menuItem.archiveMenuItemList',$menu->id) }}"
                                            class="btn btn-primary mx-1 "><i class='bx bxs-archive-in'></i></a>
                                        <button type="submit"
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
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
</div>
@endsection
@push('js')


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
