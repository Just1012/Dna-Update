<header>
    <nav>
        <div class="container">
            <div class="content">
                <a href="{{ route('front.index') }}" class="logo">
                    @php
                        $images = App\Models\ImageSetting::first();
                    @endphp
                    <img src="{{ asset('images/' . $images->main_logo) }}" alt="">
                </a>
                <div class="links">
                    <ul class="m-0 p-0 d-flex justify-content-center align-items-center g-2">
                        @if (session()->has('cart_custom') &&
                                is_array(session('cart_custom')) &&
                                count(session('cart_custom')) > 0 &&
                                session('cart_custom')[1]['allergic']
                        )
                            <a href="{{ route('checkout') }}" class="mx-2">
                                <i style="color:#989a95" class="fa-solid fa-cart-shopping"></i>
                                <span
                                    class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">
                                    {{ count(session('cart_custom')) }}
                                    <span class="visually-hidden">unread messages</span>
                                </span>
                            </a>
                        @endif

                        <li class="position-relative lang">
                            <div class="lang-switcher" id="langSwitcher">
                                <i class="fa-solid fa-globe"></i>
                                <span id="currentLang">{{ LaravelLocalization::getCurrentLocaleNative() }}</span>
                                <i class="fa-solid fa-caret-down"></i>
                            </div>
                            <div class="dropdown" id="langDropdown">
                                <ul id="languageSwitcher">
                                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        <li class="{{ $localeCode }}" data-locale="{{ $localeCode }}">
                                            {{ $properties['native'] }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        @auth
                            <li class="position-relative profile">
                                <div class="info">
                                    <div class="image">
                                        <img src="{{ asset('images/' . auth()->user()->image) }}" alt="">
                                    </div>
                                    <div class="personal_info">
                                        <h6 class="m-0">{{ auth()->user()->name }}</h6>
                                        <p class="m-0 mt-1">{{ __('messages.WelcomeInDNA') }}</p>
                                    </div>
                                </div>
                                <div class="dropdown_personal">
                                    <ul>
                                        <li>
                                            <a
                                                href="{{ route('front.profile', ['id' => auth()->user()->id]) }}">Profile</a>
                                        </li>
                                        <li>
                                            <a href="#">{{ __('messages.PrivacySetting') }}</a>
                                        </li>
                                        <hr class="m-0">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('front.logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
                                                <span class="align-middle"
                                                    data-key="t-logout">{{ __('messages.Logout') }}</span>
                                            </a>
                                            <form id="logout-form" action="{{ route('front.logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endauth
                        @guest
                            <li class="position-relative profile">
                                <div class="info">
                                    <div class="personal_info">
                                        <h6 class="m-0">
                                            <a class="btn" style="background-color:#295E4E; color:#fff;"
                                                href="{{ route('front.login') }}">
                                                {{ __('messages.sign') }}
                                            </a>
                                        </h6>
                                    </div>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
@if (App::getLocale() == 'ar')
    <style>
        .lang-switcher {
            margin-left: 170px;
        }

        nav {
            & .content {
                & .links {
                    & ul {
                        & .lang {
                            .dropdown {
                                transform: translateY(-10%) !important;
                                transform: translateX(50%) !important;
                            }
                        }
                    }
                }
            }
        }
    </style>
@else
    <style>
        .lang-switcher {
            margin-right: 90px;
        }

        nav {
            & .content {
                & .links {
                    & ul {
                        & .lang {
                            .dropdown {
                                transform: translateY(-10%) !important;
                                transform: translateX(-50%) !important;
                            }
                        }
                    }
                }
            }
        }
    </style>
@endif
<style>
    .lang-switcher {
        display: flex;
        align-items: center;
        padding: 5px 10px;
        border: 1px solid #000;
        border-radius: 25px;
        cursor: pointer;
        font-size: 14px;
        background-color: #fff;
        position: relative;
        z-index: 1;
        margin-right: 90px;
    }


    .lang-switcher i {
        margin-right: 5px;
    }

    .lang-switcher span {
        margin-right: 5px;
    }

    .lang-switcher i.fa-caret-down {
        margin-left: auto;
    }

    .dropdown {
        display: none;
        position: absolute;
        top: calc(100% + 5px);
        left: 0;
        background-color: #fff;
        border: 1px solid #000;
        border-radius: 5px;
        z-index: 1000;
        min-width: 150px;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
    }

    #languageSwitcher {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    #languageSwitcher li {
        padding: 10px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        white-space: nowrap;
    }

    #languageSwitcher li:hover {
        background-color: #f0f0f0;
    }

    /* RTL support */
    body[dir="rtl"] .lang-switcher i {
        margin-right: 0;
        margin-left: 5px;
    }

    body[dir="rtl"] .lang-switcher span {
        margin-right: 0;
        margin-left: 5px;
    }

    body[dir="rtl"] .lang-switcher i.fa-caret-down {
        margin-left: 0;
        margin-right: auto;
    }

    body[dir="rtl"] .dropdown {
        left: auto;
        right: 0;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var langSwitcher = document.getElementById('langSwitcher');
        var langDropdown = document.getElementById('langDropdown');
        var languageSwitcher = document.getElementById('languageSwitcher');
        var localeItems = languageSwitcher.querySelectorAll('li');
        var currentLangSpan = document.getElementById('currentLang');

        // Toggle the dropdown on click
        langSwitcher.addEventListener('click', function() {
            langDropdown.style.display = langDropdown.style.display == 'block' ? 'none' : 'block';
        });

        // Close the dropdown when clicking outside of it
        document.addEventListener('click', function(event) {
            if (!langSwitcher.contains(event.target) && !langDropdown.contains(event.target)) {
                langDropdown.style.display = 'none';
            }
        });

        localeItems.forEach(function(item) {
            item.addEventListener('click', function() {
                var selectedLocale = this.getAttribute('data-locale');
                changeLanguage(selectedLocale);
            });
        });

        function changeLanguage(selectedLocale) {
            var currentUrl = window.location.href;
            var arUrl = '{{ LaravelLocalization::getLocalizedURL('ar') }}';
            var enUrl = '{{ LaravelLocalization::getLocalizedURL('en') }}';

            if (currentUrl.includes('/en/')) {
                arUrl = currentUrl.replace('/en/', '/' + selectedLocale + '/');
            } else if (currentUrl.includes('/ar/')) {
                enUrl = currentUrl.replace('/ar/', '/' + selectedLocale + '/');
            }

            if (currentUrl.indexOf('?') !== -1) {
                enUrl += currentUrl.substring(currentUrl.indexOf('?'));
                arUrl += currentUrl.substring(currentUrl.indexOf('?'));
            }

            window.location.href = (selectedLocale === 'ar') ? arUrl : enUrl;
        }

        // Set the current language text
        var currentLocale = '{{ LaravelLocalization::getCurrentLocale() }}';
        currentLangSpan.textContent = currentLocale === 'ar' ? 'العربية' : 'English';
    });
</script>
