@extends('layouts.web')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
@endpush
@section('title')
    Add New Program
@endsection
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="col-md-9 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Create New Program</h4>
                        <div class="card-body ">
                            <div class="listjs-table" id="customerList">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        <div>
                                            <a class="btn btn-success add-btn" id="create-btn"
                                                href="{{ route('program.index') }}">Back</a>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('program.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="firstNameinput" class="form-label">Title Ar</label>
                                                <input value="" type="text" class="form-control" name="title_ar"
                                                    placeholder="Title Ar" id="titleArInput">
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="firstNameinput" class="form-label">Title En</label>
                                                <input value="" type="text" class="form-control" name="title_en"
                                                    placeholder="Title En" id="titleEnInput">
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Description Ar</label>
                                                <textarea style="height:100px" class="form-control" name="description_ar" placeholder="Description Ar"></textarea>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Description En</label>
                                                <textarea style="height:100px" class="form-control" name="description_en" placeholder="Description En"></textarea>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="address1ControlTextarea" class="form-label">Image</label>
                                                <input type="file" class="form-control" name="image"
                                                    id="address1ControlTextarea">
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="firstNameinput" class="form-label">Min-Meals</label>
                                                <input value="" type="number" class="form-control" name="min_meals"
                                                    placeholder="Title En" id="firstNameinput">
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <h6 class="fw-semibold">Menus</h6>
                                                <select class="js-example-basic-multiple" id="categories" name="menu_id">
                                                    <optgroup label="Menu">
                                                        <option value="" disabled selected>-- Select Menu --</option>
                                                        @foreach ($menu as $val)
                                                            <option value="{{ $val->id }}">
                                                                {{ App::getLocale() == 'ar' ? $val->title_ar : $val->title_en }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div><!--end col-->
                                        
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label>
                                                    <input type="checkbox" name="is_featured" value="1"
                                                        {{ old('is_featured', $id->is_featured ?? 0) == 1 ? 'checked' : '' }}>
                                                    Mark as Featured
                                                </label>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="card-header">
                                        <div id="template" style="display:none;">
                                            <div class="repeater-block">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">

                                                            <select class="form-control" onchange="toggleInput1()"
                                                                name="meal_id[]" id="categorySelect">
                                                                <option value="" disabled selected>-- Select Meal --
                                                                </option>
                                                                @foreach ($meal as $val)
                                                                    <option value="{{ $val->id }}">
                                                                        {{ App::getLocale() == 'ar' ? $val->title_ar : $val->title_en }}
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Duration inputs will be appended here -->
                                            </div>
                                        </div>
                                        <div id="repeater">
                                            <!-- Dynamic blocks will be appended here -->
                                        </div>
                                        <button type="button" class="btn btn-primary add-button mt-2">Add Meal</button>
                                    </div>
                                    <button type="submit" class="btn btn-success mt-2">Submit</button>
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
    <script>
        // Fetch durations from the server and initialize form handling
        function fetchDurations() {
            return $.ajax({
                url: '{{ route('duration.dataTable') }}', // Use Laravel's blade syntax for route
                type: 'GET',
                dataType: 'json'
            });
        }

        fetchDurations().done(function(response) {
            var durations = response.data.map(function(duration) {
                return duration; // Assuming 'name' is the attribute containing the duration name
            });

            $('.add-button').click(function() {
                var $template = $('#template .repeater-block').clone(); // Clone the template block
                var $row = $('<div class="row"></div>'); // Create a new row


                // Iterate over fetched durations to create inputs and manage layout
                durations.forEach(function(duration, index) {
                    var $inputGroup = $('<div class="col-md-6 mb-3">' +
                        '<label class="form-label">' + duration.title_en + '</label>' +
                        '<input type="hidden" name="duration_ids[]" value="' + duration.id +
                        '">' + // Hidden input for duration ID
                        '<input type="text" class="form-control" name="price[]" placeholder="Enter Price for ' +
                        duration.title_en + '">' +
                        '</div>');

                    $row.append($inputGroup);

                    // Every two inputs, append the current row to the template and start a new row
                    if ((index + 1) % 2 === 0 || index === durations.length - 1) {
                        $template.append($row);
                        $row = $('<div class="row"></div>'); // Reset row after appending
                    }
                });

                // Append the remove button in its own full-width row
                var $removeButton = $(
                    '<div class="col-12"><button type="button" class="btn btn-danger remove-button mt-2">Remove</button></div>'
                );
                $template.append($('<div class="row"></div>').append($removeButton));

                $('#repeater').append($template); // Append the cloned block to the repeater
            });

            // Remove button click event
            $(document).on('click', '.remove-button', function() {
                $(this).closest('.repeater-block')
                    .remove(); // Remove the block containing the clicked button
            });
        });

        function toggleInput1() {

            // Implement toggle logic for item select based on category selection if needed
        }
    </script>
    <script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#myeditorinstance',
            plugins: 'code table lists textcolor', // Include the textcolor plugin
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | forecolor backcolor | code | table', // Add forecolor and backcolor options
            toolbar_drawer: 'floating' // Optional: Change toolbar style to floating for better visibility
        });
    </script>
@endpush
