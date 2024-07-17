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
    Program Details List
@endsection
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                @php
                                    $firstProgramDuration = $programDurations->first();
                                @endphp
                                <h5 class="card-title mb-0 col-sm-8 col-md-9">
                                    <span class="text-primary">{{ $firstProgramDuration->program->title_en }}</span> Program
                                    Details List / <a href="{{ route('program.index') }}">Back</a>
                                </h5>

                                {{-- Modal --}}
                                <div id="addModals" class="modal fade" tabindex="-1" aria-hidden="true"
                                    style="display: none;">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 overflow-hidden">
                                            <div class="modal-header p-3">
                                                <h4 class="card-title mb-0">Add New Meal</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('program.storeSingleMeal') }}" method="POST"> {{-- Adjust the action route as needed --}}
                                                    @csrf
                                                    <input name="program_id" type="hidden"
                                                        value="{{ $firstProgramDuration->program->id }}">
                                                    <div class="col-md-12">
                                                        <div class="mb-1">
                                                            <h6 class="fw-semibold">Meal</h6>
                                                            <select class="form-control" id="categories"
                                                                onchange="fetchDurations()" name="meal_id">
                                                                <optgroup label="Stages">
                                                                    <option value="" disabled selected>-- Select Meal
                                                                        --</option>
                                                                    @foreach ($meal as $val)
                                                                        <option value="{{ $val->id }}">
                                                                            {{ $val->title_en }}</option>
                                                                    @endforeach
                                                                </optgroup>
                                                            </select>
                                                        </div>
                                                    </div><!--end col-->
                                                    <div id="durationContainer"></div> {{-- Container for dynamic durations and prices --}}
                                                    <div class="text-end">
                                                        <button type="submit" class="btn btn-primary">Add</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->



                                <!-- Load More Buttons -->
                                <div class="mb-lg-1 mb-0 col-sm-2 col-md-2">
                                    <div class="row  ">
                                        <div class="d-flex">

                                            <button type="button" class="btn btn-success  col-5 mx-1 "
                                                data-bs-toggle="modal" data-bs-target="#addModals"><i
                                                    class='bx bx-add-to-queue'></i></button>

                                            <a href="{{ route('program.mealArchiveList', $firstProgramDuration->program->id) }}"
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

                                <!-- Modal -->
                                <div id="signupModals" class="modal fade" tabindex="-1" aria-hidden="true"
                                    style="display: none;">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 overflow-hidden">
                                            <div class="modal-header p-3">
                                                <h4 class="card-title mb-0">Edit Price</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" method="POST" id="editPriceForm">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="priceInput" class="form-label">Price</label>
                                                        <input type="number" class="form-control" id="priceInput"
                                                            name="price" placeholder="Enter new price">
                                                    </div>
                                                    <div class="text-end">
                                                        <button type="submit" class="btn btn-primary">Update
                                                            Price</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.modal -->

                            </div>
                        </div>

                        <div class="card-body" style="overflow:auto">
                            <table id="alternative-pagination"
                                class="table nowrap dt-responsive align-middle table-hover table-bordered"
                                style="width:100%;overflow: scroll">
                                <thead>
                                    <tr>
                                        <th>#SSL</th>
                                        <th>Meal Title</th>
                                        <th>Duration</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php $x = 0; ?>
                                    @foreach ($programDurations as $pd)
                                        <?php $x++; ?>
                                        <tr>
                                            <td>{{ $x }}</td>
                                            <td>{{ $pd->meal->title_en ?? 'N/A' }}</td>
                                            <td>{{ $pd->duration->title_en ?? 'N/A' }}
                                                ({{ $pd->duration->num_weeks ?? 'N/A' }} weeks)
                                            </td>
                                            <td>${{ number_format($pd->price, 2) }}</td>
                                            <td>
                                                <!-- Trigger Button -->
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#signupModals"
                                                    data-program-duration-id="{{ $pd->id }}"
                                                    data-price="{{ $pd->price }}">
                                                    <i class="bx bxs-edit"></i>
                                                </button>

                                                <a href="{{ route('program.mealArchive', ['id' => $pd->id]) }}"> <i
                                                        class="bx bx-archive-in btn btn-primary"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
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
            $('[data-bs-toggle="modal"]').on('click', function() {
                var button = $(this); // Button that triggered the modal
                var programDurationId = button.data(
                    'program-duration-id'); // Extract info from data-* attributes
                var price = button.data('price');

                // Update the form's action attribute with the program_duration ID
                var form = $('#editPriceForm');
                form.attr('action', '{{ url('program/updateProgramDetails') }}/' + programDurationId);
                $('#priceInput').val(price);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Prepare the route template from Laravel's route helper
            const routeTemplate = "{{ route('api.durations', ['mealId' => ':mealId']) }}";

            function fetchDurations() {
                const mealId = $('#categories').val();
                if (!mealId) {
                    $('#durationContainer').empty();
                    return;
                }

                // Replace the placeholder with the actual meal ID
                const url = routeTemplate.replace(':mealId', mealId);

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        const durations = response.data;
                        let $container = $('#durationContainer');
                        $container.empty();
                        durations.forEach(function(duration) {
                            let $inputGroup = $('<div class="col-md-12 mb-3">' +
                                '<label class="form-label">' + duration.title_en +
                                '</label>' +
                                '<input type="hidden" name="duration_ids[]" value="' +
                                duration.id + '">' + // Hidden input for duration ID
                                '<input type="text" class="form-control" name="price[]" placeholder="Enter Price for ' +
                                duration.title_en + '">' +
                                '</div>');
                            $container.append($inputGroup);
                        });
                    },
                    error: function(error) {
                        console.error('Error fetching durations:', error);
                        alert('Error fetching durations. Please try again.');
                    }
                });
            }

            $('#categories').change(fetchDurations);
        });
    </script>
@endpush
