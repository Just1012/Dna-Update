<header>
    <nav>
        <div class="container">
            <div class="content">
                <a href="{{ route('front.index') }}" class="logo">
                    <img src="{{ asset('web/assets/images/logo-light.png') }}" alt="">
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
                                    class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">{{ count(session('cart_custom')) }}<span
                                        class="visually-hidden">unread messages</span></span>
                            </a>
                        @endif
                        <li class="position-relative lang">
                            <i class="fa-solid fa-globe"></i>

                            <div class="dropdown">
                                <ul id="languageSwitcher">
                                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        <li class="{{ $localeCode }}" data-locale="{{ $localeCode }}">
                                            {{ $properties['native'] }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var languageSwitcher = document.getElementById('languageSwitcher');
                                    var localeItems = languageSwitcher.querySelectorAll('li');

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
                                });
                            </script>
                        </li>
                        @auth


                            <li class="position-relative profile">
                                <div class="info">
                                    <div class="image">
                                        <img src="{{ asset('images/' . auth()->user()->image) }}" alt="">
                                    </div>
                                    <div class="personal_info">
                                        <h6 class="m-0">{{ auth()->user()->name }}</h6>
                                        <p class="m-0 mt-1">{{__('messages.WelcomeInDNA')}}</p>
                                    </div>
                                </div>
                                <div class="dropdown_personal">
                                    <ul>
                                        <li><a
                                                href="{{ route('front.profile', ['id' => auth()->user()->id]) }}">Profile</a>
                                        </li>
                                        <li><a href="#">{{__('messages.PrivacySetting')}}</a></li>
                                        <hr class="m-0">
                                        <li>
                                            <a class="dropdown-item" href="auth-logout-basic.html"
                                                href="{{ route('front.logout') }}"
                                                onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();"><i
                                                    class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                                    class="align-middle" data-key="t-logout">{{__('messages.Logout')}}</span></a>
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
                                        <h6 class="m-0"><a class="btn" style="background-color:#EA6A12; color:#fff;"
                                                href="{{ route('front.login') }}">{{__('messages.sign')}}</a></h6>

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
