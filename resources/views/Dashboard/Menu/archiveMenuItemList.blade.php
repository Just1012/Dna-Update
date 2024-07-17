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
    @if (App::getLocale() == 'ar')
        {{ $menu->first()->title_ar }} المؤرشفة
    @else
        Archived {{ $menu->first()->title_en }}
    @endif
@endsection
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">

                                <h5 class="card-title mb-0 col-sm-8 col-md-11">
                                    @if (App::getLocale() == 'ar')
                                        {{ $menu->first()->title_ar }} المؤرشفة
                                    @else
                                        Archived {{ $menu->first()->title_en }}
                                    @endif

                                    / <a href="{{ route('menuItem.index', ['menu' => $menu->first()->id]) }}">Back</a>
                                </h5>

                                <button type="submit"
                                    class="btn btn-outline-primary mb-0 col-sm-1 col-md-1 btn-icon waves-effect waves-light"
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
        var table = $('#alternative-pagination').DataTable({
            ajax: '{{ route('menuItem.archivedList', ['id' => $id]) }}',
            columns: [

                {
                    'data': null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },

                {
                    'data': null,
                    render: function(data, row, type) {
                        if (data.item1 && data.item1.title_en) {
                            return data.item1.title_ar;
                        } else {
                            return 'n/w';
                        }
                    }
                },

                {
                    'data': null,
                    render: function(data, row, type) {
                        if (data.item1 && data.item1.title_ar) {
                            return data.item1.title_ar;
                        } else {
                            return 'n/w';
                        }
                    }
                },

                {
                    'data': null,
                    render: function(data, row) {
                        return `<img src="{{ asset('images') }}/${data.item1.image}"
                                class="small-image" style="height: 50px; width: 50px" onclick="openFullScreen(this)">`;
                    }
                },

                {
                    'data': null,
                    render: function(data) {
                        var url = '{{ route('menuItem.restoreMenuItem', ':id') }}';
                        url = url.replace(':id', data.id);
                        return '<a href="' + url +
                            '"> <i class="bx bx-revision btn btn-success"></i></a>';
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
