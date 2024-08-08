@extends('layouts.front')
@section('title', trans('messages.home_page'))
@push('css')

<style>
    .pagination .page-link:focus,
    .pagination .page-link:hover {
        color: #295E4E;
        background-color: #fff;
        border-color: #295E4E;
        outline: none;
        box-shadow: none;
    }

    .products {
        & .boxes {
            & .box {
                & .image {
                    img {
                        height: 100%;
                    }
                }
            }
        }
    }
</style>
@endpush
@section('content')
    @include('layouts.ex_front.header')

    <!-- slider -->
    <section class="slider">
        <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($data['slider_main'] as $index => $slider)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}" data-bs-interval="10000">
                        <img src="{{ asset('images/' . $slider->image) }}" class="d-block w-100" alt="{{ $slider->title_en }}">
                        @if (
                            $slider->title_en ||
                                $slider->title_ar ||
                                $slider->description_en ||
                                $slider->description_ar ||
                                $slider->link_btn ||
                                $slider->link)
                            <div class="carousel-caption d-none d-md-block">
                                <h2>{{ App::getLocale() == 'ar' ? $slider->title_ar : $slider->title_en }}</h2>

                                <p>{!! App::getLocale() == 'ar' ? $slider->description_ar : $slider->description_en !!}</p>
                                @if ($slider->link_btn || $slider->link)
                                    <a target="_blank" href="{{ $slider->link }}"
                                        style="color: {{ $slider->link_btn_color }}; background-color:{{ $slider->link_btn_bg }}"
                                        class="btn">{{ $slider->link_btn }}</a>
                                @endif
                            </div>
                        @endif

                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">{{ trans('messages.previous') }}</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">{{ trans('messages.next') }}</span>
            </button>
        </div>
    </section>

    <!-- Food Systeme -->
    <section class="Food_systems">
        <div class="container">
            <div class="info">
                <div class="heading d-flex justify-content-between align-items-center">
                    <h3>{{ trans('messages.programs') }}</h3>
                    <a class="view_all" href="{{ route('front.allProgram') }}">
                        <span>{{ trans('messages.view_all') }}</span>
                        <div class="icon">
                            <i class="ri-arrow-drop-right-line"></i>
                        </div>
                    </a>
                </div>
                <div class="d-flex justify-content-between align-items-end">
                    <div class="splide overflow-hidden w-100" aria-labelledby="carousel-heading" style="direction: ltr;">
                        <div class="splide__track">
                            <ul class="splide__list">

                                @foreach ($data['programs'] as $index => $programs)
                                    <li class="splide__slide">
                                        <a href="{{ route('front.programDetails', ['id' => $programs->id]) }}">
                                            <div class="address">
                                                <div class="image">
                                                    <img src="{{ asset('images/' . $programs->image) }}" alt="{{ $programs->title_en }}">
                                                </div>
                                                <div class="offer">
                                                    <h2 class="mb-2 text-center" style="color:#295E4E">
                                                        {{ App::getLocale() == 'ar' ? $programs->title_ar : $programs->title_en }}
                                                    </h2>
                                                    <p class="mb-0">
                                                        {!! \App\Utils\helper::str_limit_words(App::getLocale() == 'ar' ? $programs->description_ar : $programs->description_en, 100) !!}
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Menu Category Section -->
    <section class="categories_cart" style="overflow: hidden;">
        <div class="container">
            <div class="content row">
                <div class="col-lg-6 categories">
                    <div class="heading d-flex justify-content-between align-items-center">
                        <h3>{{ trans('messages.menu_category') }}</h3>
                    </div>
                    <div class="menus">
                        <div class="container">
                            <div class="d-flex justify-content-start align-items-center gap-3" style="overflow-x: scroll">
                                @foreach ($categories as $category)
                                    <div id="menu_card" class="menu_card" data-choose="{{ $category->id }}"
                                        onclick="handleCategoryClick(this, {{ $category->id }})">
                                        <img style="border-radius: 50%;" src="{{ asset('images/' . $category->image) }}"
                                            alt="{{ $category->title_en }}">
                                        <h6 class="mb-2 text-black">
                                            {{ App::getLocale() == 'ar' ? $category->title_ar : $category->title_en }}</h6>
                                        <div class="icon">
                                            <i class="ri-arrow-drop-right-line"></i>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 sub_categories" style="overflow: hidden;">
                    <div class="d-flex justify-content-start align-items-center flex-wrap">
                        <div class="heading d-flex justify-content-between align-items-center">
                            <h3>{{ trans('messages.sub_category') }}</h3>
                            <a href="#" class="d-flex justify-content-center align-items-center">
                                <span>{{ trans('messages.view_all') }}</span>
                                <i class="ri-arrow-drop-right-line rounded-circle mx-1"
                                    style="background-color: #295E4E; color: #fff; font-size: 25px;"></i>
                            </a>
                        </div>
                        <div class="content_sub d-flex justify-content-start g-2 flex-wrap" id="subCategoriesContent">
                            <!-- Dynamic content will be injected here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Products Section -->
    <section class="products small">
        <div class="container">
            <div id="itemsContent" class="boxes d-flex justify-content-start align-items-center mt-2 mb-3 flex-wrap">
                <!-- Dynamic items will be inserted here -->
            </div>
            <ul id="paginationControls" class="pagination justify-content-center"></ul>
        </div>
    </section>

    <!-- Advertisements Section -->
    <section class="advertisements">
        <div class="container">
            <div class="content d-flex justify-content-start align-items-center">
                @foreach ($data['slider_second'] as $index => $slid)
                    <div class="advertisements_1">
                        <img src="{{ asset('images/' . $slid->image) }}" style="object-fit: cover; width: 100%; height: 100%;" alt="{{ $slid->title_en }}">
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <script src="{{ asset('front/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('front/js/main.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var splide = new Splide('.splide', {
                perPage: 3,
                perMove: 1,
                breakpoints: {
                    767: {
                        perPage: 1,
                    },
                    991: {
                        perPage: 2,
                    }
                }
            });
            splide.mount();
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var menuCards = document.querySelectorAll('#menu_card');
            menuCards.forEach((card) => {
                card.addEventListener('click', removeActive);
            });

            function removeActive() {
                menuCards.forEach((card) => {
                    if (this.classList.contains('active')) {
                        this.classList.remove('active');
                    } else {
                        menuCards.forEach((card) => {
                            card.classList.remove('active');
                        });
                        this.classList.add('active');
                    }
                });
            }
        });
    </script>
    <script>
         const swiper = new Swiper('.swiper-container', {
        slidesPerView: 'auto',
        spaceBetween: 20,
        freeMode: true,
        scrollbar: {
            el: '.swiper-scrollbar',
            draggable: true,
        },
    });
        var currentLocale = '{{ App::getLocale() }}';
        var categoryId = null;
        var subCategoryId = null;
        let currentPage = 1;
        let totalPages = 1;
        let isLoading = false;

        function handleCategoryClick(element, catId) {
            if (catId == categoryId) {
                categoryId = null;
                subCategoryId = null;
            } else {
                categoryId = catId;
                subCategoryId = null;
            }

            document.querySelectorAll('.menu_card').forEach(card => {
                card.classList.add('active');
            });
            if (catId != categoryId) {
                element.classList.remove('active');
            }

            fetchSubCategories(categoryId);
        }

        function fetchSubCategories(catId) {
            fetch(`/get-sub-categories/${catId}`)
                .then(response => response.json())
                .then(data => {
                    displaySubCategories(data);
                    fetchItems();
                })
                .catch(error => {
                    const subCategoriesContent = document.getElementById('subCategoriesContent');
                    subCategoriesContent.innerHTML = '<p>{{ trans('messages.no_subcategories') }}</p>';
                });
        }

        function fetchItems(page = 1) {
            if (isLoading) return;
            isLoading = true;

            const itemsContent = document.getElementById('itemsContent');
            let loadingMessage = document.getElementById('loadingMessage');

            if (!loadingMessage) {
                // loadingMessage = document.createElement('p');
                // loadingMessage.id = 'loadingMessage';
                // loadingMessage.innerText = '{{ trans('messages.loading_items') }}';
                // itemsContent.appendChild(loadingMessage);
            }

            const url = `/get-items/${categoryId}/${subCategoryId}?page=${page}`;
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    displayItems(data.data, page);
                    totalPages = data.last_page;
                    currentPage = data.current_page;
                    displayPaginationControls(data);
                    isLoading = false;
                    loadingMessage.remove();
                })
                .catch(error => {
                    isLoading = false;
                });
        }

        function displaySubCategories(data) {
            const subCategoriesContent = document.getElementById('subCategoriesContent');
            subCategoriesContent.innerHTML = '';
            if (data.length === 0) {
                subCategoriesContent.innerHTML = '<p>{{ trans('messages.no_subcategories') }}</p>';
            } else {
                data.forEach(subCategory => {
                    const button = document.createElement('button');
                    button.id = 'subBtn';
                    button.className = 'btn ' + subCategory.slug;
                    button.textContent = currentLocale === 'ar' ? subCategory.title_ar : subCategory.title_en;
                    button.onclick = () => handleSubCategoryClick(button, subCategory.id);
                    subCategoriesContent.appendChild(button);
                });
            }
        }

        function handleSubCategoryClick(button, subCatId) {
            if (subCatId == subCategoryId) {
                subCategoryId = null;
            } else {
                subCategoryId = subCatId;
            }

            document.querySelectorAll('#subBtn').forEach(btn => {
                btn.classList.remove('active');
            });

            if (subCategoryId) {
                button.classList.add('active');
            }

            currentPage = 1;
            fetchItems();
        }

        function displayItems(items, page) {
            const itemsContent = document.getElementById('itemsContent');
            if (page === 1) {
                itemsContent.innerHTML = '';
            }

            if (items.length === 0 && page === 1) {
                itemsContent.innerHTML = '<p>{{ trans('messages.no_items') }}</p>';
            } else {
                items.forEach(item => {
                    const itemDiv = document.createElement('div');
                    itemDiv.className = 'box ' + (item.subCategory ? item.subCategory.slug : 'general');
                    itemDiv.innerHTML = `
                    <div style="padding-right:35px !important;" class="content">
                        <h6 class="mb-1 mt-3 heading-title fw-bolder"> ${currentLocale == 'ar' ? item.title_ar : item.title_en}</h6>
                    </div>
                    <div class="image">
                        <img src="/images/${item.image}" alt="${item.title_en}">
                    </div>
                `;
                    itemsContent.appendChild(itemDiv);
                });
            }
        }

        function handleScroll() {
            const {
                scrollTop,
                scrollHeight,
                clientHeight
            } = document.documentElement;
            if (scrollHeight - scrollTop - clientHeight < 100) {
                if (currentPage < totalPages) {
                    fetchItems(currentPage + 1);
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            fetchSubCategories(null);
            window.addEventListener('scroll', handleScroll);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var subBtn = document.querySelectorAll('#subBtn');
            subBtn.forEach((card) => {
                card.addEventListener('click', removeActive);
            });

            function removeActive() {
                subBtn.forEach((card) => {
                    if (this.classList.contains('active')) {
                        this.classList.remove('active');
                    } else {
                        subBtn.forEach((card) => {
                            card.classList.remove('active');
                        });
                        this.classList.add('active');
                    }
                });
            }
        });
    </script>
@endpush
