@extends('layouts.front')
@section('title', App::getLocale() == 'ar' ? $program->title_ar : $program->title_en)
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
@endpush
@section('content')
    @include('layouts.ex_front.header')
    <style>
        body {
            background-color: #e4e4e6;
            font-family: "Cairo", sans-serif;
        }

        .cairo-custom-body {
            font-family: "Cairo", sans-serif;
            font-optical-sizing: auto;
            font-weight: 400;
            /* Example weight value, adjust as needed */
            font-style: normal;
            font-variation-settings: "slnt" 0;
        }

        .custom-step-1 {
            display: flex;
            width: 100%;
            flex-direction: column;
        }

        .custom-header .custom-title {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .custom-tiles {
            display: flex;
            justify-content: start;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .custom-tiles .custom-tile {
              width:auto;
            cursor: pointer;
            border: 1px solid #f5f5f5;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            flex-direction: column;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .custom-tiles .custom-tile.active {
            background-color: #295E4E;
            border-color: #295E4E;
            color: #fff;
        }

        .custom-tiles .custom-tile label {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 100%;
        }

        .custom-tiles .custom-tile .custom-image {
            cursor: pointer;
            margin: 10px 0;
            width: 130px;
            border-radius: 50%;
            overflow: hidden;
            height: 130px;
            object-fit: cover;
        }

        .custom-tiles .custom-tile .custom-image img {
            width: 100%;
            height: 100%;
        }

        .custom-tiles .custom-tile h6,
        .custom-tiles .custom-tile p {
            cursor: pointer;
        }

        .custom-tiles .custom-tile p span {
            font-weight: bold;
            color: #295E4E;
        }

        .myshadow {
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }

        .program_details {
            padding: 20px 0;
        }

        .program_details .container {
            max-width: 1320px;
            margin: auto;
        }

        .program_details .glass-effect {
            background: rgba(41, 94, 78, 0.6);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(41, 94, 78, 0.8);
        }

        .program_details .details {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .program_details .info {
            display: flex;
            align-items: center;
        }

        .program_details .program-image {
            max-width: 100px;
            height: auto;
            border-radius: 10px;
            margin-right: 15px;
        }

        .program_details .program-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            margin: 10px;
        }

        .details_2 {
            width: 83%;
        }

        @media (max-width: 767px) {
            .program_details .details {
                flex-direction: column;
                align-items: flex-start;
            }

            .program_details .program-image {
                max-width: 80px;
                margin-bottom: 10px;
            }

            .program_details .program-title {
                font-size: 1.25rem;
            }
        }

        .tiles_radio label {
            display: flex;
            align-items: center;
            padding: 10px;
            background: #fff;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .tiles_radio label:hover {
            background: rgba(41, 94, 78, 0.7);
            color: #fff;
        }

        .tiles_radio input[type="radio"] {
            display: none;
        }

        .tiles_radio input[type="radio"]:checked+label {
            background: rgba(41, 94, 78);
            color: #fff;
            font-weight: bold;
        }

        .form-check img {
            width: 100%;
            border-radius: 5px;
        }

        .form-check-input.d-none {
            display: none;
        }

        .meal-label {
            cursor: pointer;
            display: block;
            text-align: center;
            border: 2px solid transparent;
            padding: 10px;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }

        .form-check-input.d-none:checked+.meal-label {
            box-shadow: rgba(117, 16, 16, 0.1) 0px 4px 12px;
            background: rgba(41, 94, 78, 0.6);
            border: 1px solid rgba(41, 94, 78, 0.8);
            color: #fff;
        }

        .meal-image {
            border-radius: 5px;
        }

        .order-card {
            background-color: #fff;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
            padding: 20px;
            border-radius: 10px;
        }

        .next-stp {
            background-color: rgba(41, 94, 78, 0.6);
            color: #fff;
            border-color: #295E4E;
        }

        .next-stp:hover {
            background-color: #1f473a;
            border-color: #1f473a;
            color: #fff;

        }

        .step {
            width: 100%;
        }

        /* RTL styles */
        body[dir="rtl"] .header,
        body[dir="rtl"] p,
        body[dir="rtl"] textarea,
        body[dir="rtl"] h2,
        body[dir="rtl"] h6 {
            text-align: right;
        }

        .required-field::after {
            content: '*';
            color: red;
            margin-left: 5px;
        }

        .prev-stp .required-star {
            color: red;
            margin-left: 5px;
        }

        #toast-container>.toast-error {
            background-color: rgba(255, 0, 0, 0.7) !important;
            color: #fff !important;
            box-shadow: #fff !important;
        }

        .toast-error .toast-title {
            color: #fff !important;
        }

        .toast-error .toast-message {
            color: #fff !important;
        }

        @media (min-width: 1200px) {

            .container,
            .container-lg,
            .container-md,
            .container-sm,
            .container-xl {
                max-width: 1320px;
            }
        }
        /* Style for the category block */
        .category-block {
    margin-bottom: 20px;
    overflow-x: auto; /* Enable horizontal scrolling */
    white-space: nowrap; /* Prevent line breaks */

}

.category-block::-webkit-scrollbar {
    display: none; /* Hide scrollbar in Chrome/Safari/Webkit browsers */
}





/* Custom scrollbar for Firefox */



/* Style for the items container */
.items-container {
    display: flex; /* Align items in a row */
  /*  overflow-x: auto; /* Enable horizontal scrolling */
    white-space: nowrap; /* Prevent items from wrapping to the next line */
    padding: 10px 0; /* Add vertical padding */
    gap: 10px; /* Space between items */
    max-width: 100%; /* Ensure container width is not exceeding its parent */
    box-sizing: border-box; /* Include padding and border in container's width */
    -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
    scrollbar-width: none; /* Hide scrollbar in Firefox */
    -ms-overflow-style: none; /* Hide scrollbar in IE/Edge */
}

/* Style for each custom tile */
.custom-tile {
    flex: 0 0 auto; /* Prevent shrinking and growing */
    width: 150px; /* Fixed width for tiles */
    cursor: pointer;
    border: 1px solid #f5f5f5;
    border-radius: 10px;
    padding: 10px;
    text-align: center; /* Center align content */
    transition: background-color 0.3s, border-color 0.3s;
    box-sizing: border-box; /* Include padding and border in tile's width */
}

/* Active state for tiles */
.custom-tile.active {
    background-color: #295E4E;
    border-color: #295E4E;
    color: #fff;
}

/* Style for the custom image */
.custom-image {
    margin: 10px 0;
    width: 130px;
    border-radius: 50%;
    overflow: hidden;
    height: 130px;
}

/* Ensure images cover their container */
.custom-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Ensure proper text alignment */
.custom-tile h6,
.custom-tile p {
    cursor: pointer;
}

/* For tablets and smaller screens */
@media (max-width: 1024px) {
    .items-container {
        padding: 5px 0; /* Adjust vertical padding for smaller screens */
    }

    .custom-tile {
        width: 130px; /* Reduce tile width for smaller screens */
    }

    .custom-image {
        width: 100px; /* Reduce image size for smaller screens */
        height: 100px;
    }
}

/* For mobile screens */
@media (max-width: 767px) {
    .items-container {
        padding: 5px 0; /* Adjust vertical padding for mobile screens */
    /*    overflow-x: auto; /* Ensure horizontal scrolling on mobile */
    }

    .custom-tile {
        width: 100px; /* Further reduce tile width for mobile screens */
    }

    .custom-image {
        width: 80px; /* Further reduce image size for mobile screens */
        height: 80px;
    }

    /* Ensure the text fits well */
    .custom-tile h6 {
        font-size: 14px; /* Adjust text size for smaller screens */
    }
}

/* For very small screens (phones in portrait mode) */
@media (max-width: 480px) {
    .items-container {
        padding: 5px 0; /* Adjust padding for very small screens */
       /* gap: 5px; /* Reduce gap between items */
    }

    .custom-tile {
        width: 80px; /* Further reduce tile width */
    }

    .custom-image {
        width: 60px; /* Further reduce image size */
        height: 60px;
    }

    .custom-tile h6 {
        font-size: 12px; /* Adjust text size for very small screens */
    }
}


    </style>

    <div class="program_details py-4">
        <div class="container">
            <div class="glass-effect p-4 rounded">
                <div class="details d-flex justify-content-between align-items-center">
                    <div class="info d-flex align-items-center">
                        <div class="me-3">
                            <img src="{{ asset('images/' . $program->image) }}" alt=""
                                class="img-fluid program-image">
                        </div>
                        <h3 class="program-title">{{ App::getLocale() == 'ar' ? $program->title_ar : $program->title_en }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="order py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="order-card">
                        <form action="{{ route('front.save.card') }}" method="POST">
                            @csrf
                            <div class="step step-2">
                                <p class="text-danger" style="font-size: 14px">
                                    {{ App::getLocale() == 'ar' ? 'يرجى التأكد من كتابة جميع الملاحظات الغذائية الخاصة بك، بما في ذلك تفضلها التي لا ولديك حساسية عليها. سوف نقوم بمراجعة ملاحظاتك للتأكد من أنها تتناسب مع معايير شركتنا وقائمتنا. إذا تمكنا من الحفاظ على جودة طعامنا العالية دون المكونات التي ذكرتها، فسنقبل اشتراكك. العلم يرجى أنه كلما قل عدد المكونات التي تستبعدها، كلما زاد تنوع خيارات الوجبات' : 'Please make sure to write down all your food notes, including dislikes and any allergies. We will review your preferences to ensure they fit within our company standards and our menu. If we can maintain our high food quality without the ingredients you list, we will accept your subscription. Please note that the fewer ingredients you exclude, the wider the variety of meal options you will receive.' }}
                                </p>
                                <div class="header mb-3">
                                    <h2 class="title required-field">{{ trans('messages.items_you_dont_like') }}</h2>
                                </div>

                                <textarea name="dont_like" class="form-control mb-3" rows="5"
                                    placeholder="{{ trans('messages.enter_items_you_dont_like') }}"></textarea>

                                <div class="header mb-3">
                                    <h2 class="title required-field">{{ trans('messages.items_that_make_you_allergic') }}
                                    </h2>
                                </div>
                                <textarea name="allergic" class="form-control mb-3" rows="5"
                                    placeholder="{{ trans('messages.enter_items_that_make_you_allergic') }}"></textarea>

                                <div class="header mb-3">
                                    <h2 class="title required-field">{{ trans('messages.note') }}
                                    </h2>
                                </div>
                                <textarea name="notes" class="form-control mb-3" rows="5"
                                    placeholder="{{ trans('messages.note_place_holder') }}"></textarea>

                                <div class="d-flex justify-content-between">
                                    <button class="btn next-stp" type="button">{{ trans('messages.next_step') }}</button>
                                </div>
                            </div>

                            <div class="step step-3 d-none">
                                <div class="custom-step-1">
                                    <div class="custom-header mb-4">
                                        <h2 class="title">{{ trans('messages.items') }}</h2>
                                        <p class="text-danger" style="font-size: 14px;">
                                            {{ trans('messages.select_items_not_like') }}</p>
                                    </div>
                                    <div class="custom-tiles">
                                        @foreach ($groupedItems as $category)
                                        <div class="d-block" style="display: inline-block;     width: 100%;" >
                                                <h3 class="">
                                                    <input type="checkbox" class="select-category" data-id="{{ $category['category']->id }}">
                                                    {{ $category['category']->{'title_' . App::getLocale()} }}
                                                </h3>
                                        </div>
                                                <div class="category-block">
                                                <div class="items-container" data-category-id="{{ $category['category']->id }}">
                                                    @foreach ($category['items'] as $item)
                                                        <div class="custom-tile" data-id="{{ $item->id }}">
                                                            <div class="custom-image">
                                                                <img src="{{ asset('images/' . $item->image) }}" alt="Meal Image">
                                                            </div>
                                                            <h6>{{ $item->{'title_' . App::getLocale()} }}</h6>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <input type="hidden" name="items" id="selected-items" value="">

                                <div class="d-flex justify-content-between mt-4">
                                    <button class="btn btn-secondary prev-stp" type="button">{{ trans('messages.go_back') }}</button>
                                    <button class="btn next-stp" type="submit">{{ trans('messages.check_out') }}</button>
                                </div>
                            </div>



                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ asset('web/assets/js/pages/select2.init.js') }}"></script>

    {{-- <script>
document.addEventListener('DOMContentLoaded', () => {
    const tiles = document.querySelectorAll('.custom-tile');
    const selectedItemsInput = document.getElementById('selected-items');
    const form = document.getElementById('menu-form');

    let selectedItems = new Set();

    // Function to update the hidden input field with selected items
    function updateSelectedItems() {
        selectedItemsInput.value = Array.from(selectedItems).join(',');
    }

    // Tile click event listener to select/deselect items
    tiles.forEach(tile => {
        tile.addEventListener('click', () => {
            const itemId = tile.getAttribute('data-id');
            if (tile.classList.toggle('active')) {
                selectedItems.add(itemId);
            } else {
                selectedItems.delete(itemId);
            }
            updateSelectedItems();
        });
    });

    // Category checkbox event listener to select/deselect all items in the category
    document.querySelectorAll('.select-category').forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            const categoryId = checkbox.getAttribute('data-id');
            const itemsContainer = document.querySelector(`.items-container[data-category-id="${categoryId}"]`);
            const categoryTiles = itemsContainer.querySelectorAll('.custom-tile');

            if (checkbox.checked) {
                categoryTiles.forEach(tile => {
                    const itemId = tile.getAttribute('data-id');
                    tile.classList.add('active');
                    selectedItems.add(itemId);
                });
            } else {
                categoryTiles.forEach(tile => {
                    const itemId = tile.getAttribute('data-id');
                    tile.classList.remove('active');
                    selectedItems.delete(itemId);
                });
            }
            updateSelectedItems();
        });
    });

    form.addEventListener('submit', () => {
        updateSelectedItems();
    });
});


    </script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tiles = document.querySelectorAll('.custom-tile');
            const selectedItemsInput = document.getElementById('selected-items');
            const form = document.getElementById('menu-form');

            let selectedItems = new Set();

            // Function to update the hidden input field with selected items
            function updateSelectedItems() {
                selectedItemsInput.value = Array.from(selectedItems).join(',');
            }

            // Tile click event listener to select/deselect items
            tiles.forEach(tile => {
                tile.addEventListener('click', () => {
                    const itemId = tile.getAttribute('data-id');
                    const categoryId = tile.closest('.items-container').getAttribute('data-category-id');
                    const categoryCheckbox = document.querySelector(`.select-category[data-id="${categoryId}"]`);

                    // Toggle item selection
                    if (tile.classList.toggle('active')) {
                        selectedItems.add(itemId);
                    } else {
                        selectedItems.delete(itemId);
                    }

                    // Update category checkbox based on the state of items
                    updateCategoryCheckbox(categoryId);

                    // Update the hidden input field
                    updateSelectedItems();
                });
            });

            // Category checkbox event listener to select/deselect all items in the category
            document.querySelectorAll('.select-category').forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    const categoryId = checkbox.getAttribute('data-id');
                    const itemsContainer = document.querySelector(`.items-container[data-category-id="${categoryId}"]`);
                    const categoryTiles = itemsContainer.querySelectorAll('.custom-tile');

                    // Check or uncheck all items within the category
                    if (checkbox.checked) {
                        categoryTiles.forEach(tile => {
                            const itemId = tile.getAttribute('data-id');
                            if (!tile.classList.contains('active')) {
                                tile.classList.add('active');
                                selectedItems.add(itemId);
                            }
                        });
                    } else {
                        categoryTiles.forEach(tile => {
                            const itemId = tile.getAttribute('data-id');
                            tile.classList.remove('active');
                            selectedItems.delete(itemId);
                        });
                    }

                    // Update the hidden input field
                    updateSelectedItems();
                });
            });

            // Function to update the category checkbox based on the items' selection state
            function updateCategoryCheckbox(categoryId) {
                const itemsContainer = document.querySelector(`.items-container[data-category-id="${categoryId}"]`);
                const categoryTiles = itemsContainer.querySelectorAll('.custom-tile');
                const categoryCheckbox = document.querySelector(`.select-category[data-id="${categoryId}"]`);

                // Check if all items in the category are selected
                const allSelected = Array.from(categoryTiles).every(tile => tile.classList.contains('active'));
                const noneSelected = Array.from(categoryTiles).every(tile => !tile.classList.contains('active'));

                // If all items are selected, check the category checkbox, otherwise uncheck it
                if (allSelected) {
                    categoryCheckbox.checked = true;
                    categoryCheckbox.indeterminate = false;
                } else if (noneSelected) {
                    categoryCheckbox.checked = false;
                    categoryCheckbox.indeterminate = false;
                } else {
                    categoryCheckbox.indeterminate = true; // Set indeterminate state if some are selected
                }
            }

            form.addEventListener('submit', () => {
                updateSelectedItems();
            });
        });
        </script>

    <script>
   document.addEventListener('DOMContentLoaded', function() {
    const steps = document.querySelectorAll('.step-2, .step-3');
    const nextBtns = document.querySelectorAll('.next-stp');
    const prevBtns = document.querySelectorAll('.prev-stp');
    const allergicTextarea = document.querySelector('textarea[name="allergic"]');
    const dont_likeTextarea = document.querySelector('textarea[name="dont_like"]');
    const notesTextarea = document.querySelector('textarea[name="notes"]');

    const step3Btn = document.querySelector('.next-stp[type="submit"]');

    let currentStep = 0;

    function showStep(stepIndex) {
        steps.forEach((step, index) => {
            step.classList.toggle('d-none', index !== stepIndex);
        });
    }

    nextBtns.forEach(btn => {
        btn.addEventListener('click', (event) => {
            // Check if navigating to step 3
            if (currentStep === 0 && btn !== step3Btn) {
                // Validate the allergic textarea
                if (!dont_likeTextarea.value.trim()) {
                    toastr.error('Please enter items that make you dont like.', 'Error!!');

                    return; // Prevent navigation to step 3
                }
                if (!allergicTextarea.value.trim()) {
                    toastr.error('Please enter items that make you allergic.', 'Error!!');


                    return; // Prevent navigation to step 3
                }
                if (!notesTextarea.value.trim()) {
                    toastr.error('Please enter items that make you notes.', 'Error!!');


                    return; // Prevent navigation to step 3
                }

            }
            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            }
        });
    });

    prevBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        });
    });

    showStep(currentStep);
});

    </script>
@endpush
