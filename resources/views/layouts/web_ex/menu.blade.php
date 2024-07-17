<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="#" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('web/assets/images/logo-light.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img style="scale: 5.5 !important;" src="{{ asset('web/assets/images/logo-light.png') }}" alt=""
                    height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="#" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('web/assets/images/logo-light.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img style="scale: 5.5 !important;" src="{{ asset('web/assets/images/logo-light.png') }}" alt=""
                    height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>

            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>

                {{-- Start Dashboard Page  --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ Request::routeIs('dashboard') ? 'active' : '' }}"
                        data-key="t-nft-landing">
                        <i class='bx bxs-dashboard'></i>
                        <span data-key="t-landing">Dashboard</span>
                    </a>
                </li>
                {{-- End Dashboard Page  --}}

                {{-- Start Order Page  --}}
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#order" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="order">
                        <i class='bx bxs-cart'></i><span data-key="t-landing">Order
                        </span>
                    </a>
                    <div class="collapse menu-dropdown" id="order">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('order.index') }}" class="nav-link"
                                    data-key="t-nft-landing">Order Request List</a>
                            </li>
                            {{-- <li class="nav-item">
                                <a href="{{ route('duration.addDuration') }}" class="nav-link" data-key="t-one-page">Add
                                    New duration</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('duration.archived') }}" class="nav-link"
                                    data-key="t-one-page">Archived Durations</a>
                            </li> --}}
                        </ul>
                    </div>
                </li>
                {{-- End Order Page  --}}

                {{-- Start Meals  --}}
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class='bx bx-dish'></i> <span data-key="t-dashboards">Meals</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboards">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('meal.index') }}" class="nav-link" data-key="t-one-page">List</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('meal.addMeal') }}" class="nav-link" data-key="t-one-page">Add New
                                    Meal</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('meal.archived') }}" class="nav-link" data-key="t-one-page">Archived
                                    Meals</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- end Meals -->


                {{-- Start Duration Page  --}}
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#duration" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="duration">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-landing">Duration
                        </span>
                    </a>
                    <div class="collapse menu-dropdown" id="duration">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('duration.index') }}" class="nav-link"
                                    data-key="t-nft-landing">List</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('duration.addDuration') }}" class="nav-link"
                                    data-key="t-one-page">Add
                                    New duration</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('duration.archived') }}" class="nav-link"
                                    data-key="t-one-page">Archived Durations</a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- End Duration Page  --}}

                {{-- Start Category Page  --}}
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#category" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="category">
                        <i class="bx bx-category-alt"></i> <span data-key="t-landing">Category
                        </span>
                    </a>
                    <div class="collapse menu-dropdown" id="category">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('category.index') }}" class="nav-link"
                                    data-key="t-nft-landing">List</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('category.addCategory') }}" class="nav-link"
                                    data-key="t-one-page">Add New Category</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('category.archived') }}" class="nav-link"
                                    data-key="t-one-page">Archived Category</a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- End Duration Page  --}}

                {{-- Start Items Page  --}}
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#item" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="item">
                        <i class='bx bx-bowl-rice'></i> <span data-key="t-landing">Items
                        </span>
                    </a>
                    <div class="collapse menu-dropdown" id="item">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('item.index') }}" class="nav-link"
                                    data-key="t-nft-landing">List</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('item.addItem') }}" class="nav-link" data-key="t-one-page">Add New
                                    Item</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('item.archived') }}" class="nav-link"
                                    data-key="t-one-page">Archived Items</a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- End Items Page  --}}

                {{-- Start Menus Page  --}}
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#menu" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="menu">
                        <i class='bx bx-food-menu'></i> <span data-key="t-landing">Menu
                        </span>
                    </a>
                    <div class="collapse menu-dropdown" id="menu">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('menu.index') }}" class="nav-link"
                                    data-key="t-nft-landing">List</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('menu.addMenu') }}" class="nav-link" data-key="t-one-page">Add New
                                    Menu</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('menu.archived') }}" class="nav-link"
                                    data-key="t-one-page">Archived Menu</a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- End Menus Page  --}}

                {{-- Start Program Page  --}}
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#program" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="program">
                        <i class='bx bx-cookie'></i> <span data-key="t-landing">Program
                        </span>
                    </a>
                    <div class="collapse menu-dropdown" id="program">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('program.index') }}" class="nav-link"
                                    data-key="t-nft-landing">List</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('program.addProgram') }}" class="nav-link"
                                    data-key="t-one-page">Add New Program</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('program.archiveProgramList') }}" class="nav-link"
                                    data-key="t-one-page">Archived Program</a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- End Program Page  --}}

                {{-- Start Slider Page  --}}
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#slider" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="slider">
                        <i class='bx bx-slideshow'></i> <span data-key="t-landing">slider
                        </span>
                    </a>
                    <div class="collapse menu-dropdown" id="slider">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('slider.index') }}" class="nav-link"
                                    data-key="t-nft-landing">List</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('slider.addSlider') }}" class="nav-link" data-key="t-one-page">Add
                                    New Slider</a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- End Slider Page  --}}

                {{-- Start users Page  --}}
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#users" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="users">
                        <i class='bx bxs-user'></i><span data-key="t-landing">{{ __('users') }}
                        </span>
                    </a>
                    <div class="collapse menu-dropdown" id="users">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admins.addUser') }}" class="nav-link"
                                    data-key="t-nft-landing">{{ __('Add User') }}</a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admins.list') }}" class="nav-link"
                                    data-key="t-nft-landing">{{ __('admins') }}</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('staff.list') }}" class="nav-link"
                                    data-key="t-one-page">{{ __('staff') }}</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('customers.list') }}" class="nav-link"
                                    data-key="t-one-page">{{ __('cutomers') }}</a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- End users Page  --}}

                {{-- Start users Page  --}}
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#settings" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="settings">
                        <i class='bx bx-cog'></i><span data-key="t-landing">{{ __('Settings') }}
                        </span>
                    </a>
                    <div class="collapse menu-dropdown" id="settings">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('daySetting.index') }}" class="nav-link"
                                    data-key="t-nft-landing">Days Setting</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('shipping.index') }}" class="nav-link"
                                    data-key="t-nft-landing">Shipping Governorate</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('shipping.time') }}" class="nav-link"
                                    data-key="t-nft-landing">Shipping Time</a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- End users Page  --}}


            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
