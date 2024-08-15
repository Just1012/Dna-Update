
@php
    $lang = App::getLocale(); // Correct function name
    $about = App\Models\ContactSetting::first();

@endphp
<style>.footer-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
}

footer {
    width: 100%;
}

footer .row {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

footer .col-md-4 {
    margin-bottom: 1rem;
}

footer .col-md-8 {
    display: flex;
    justify-content: center;
}

footer .btn-floating {
    margin: 0.5rem;
}

footer .list-unstyled {
    padding: 0;
    margin: 0;
    list-style: none;
}

footer .list-unstyled li {
    margin-bottom: 0.5rem;
}

footer .list-unstyled a {
    text-decoration: none;
    color: white;
    transition: color 0.3s;
}

footer .list-unstyled a:hover {
    color: #ccc;
}
</style>
<!-- Remove the container if you want to extend the Footer to full width. -->


<!-- Remove the container if you want to extend the Footer to full width. -->
<!-- Remove the container if you want to extend the Footer to full width. -->
<div class="footer-container" style="width: 100%">

    <footer class="bg-dark text-center text-white">
        <!-- Grid container -->
        <div class="container p-4 pb-0">
            <!-- Section: Links -->
            <section class="mb-4">
                <div class="row">
                    <!-- About Me, Privacy, and Phone Contact -->
                    <div class="col-md-4 text-md-start mb-3">
                        <ul class="list-unstyled">
                            <li>
                                <a href="{{route('about')}}" class="text-white">About Me</a>
                            </li>
                            <li>
                                <a href="{{route('privacy')}}" class="text-white">Privacy Policy</a>
                            </li>
                            <li>
                                <a href="tel:{{ $about->phone }}" class="text-white">Phone: {{ $about->phone }}</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Social Media Section -->
                    <div class="col-md-8">
                        <section class="mb-4">
                            @if($about->facebook)
                                <a class="btn btn-outline-light btn-floating m-1" target="_black" href="{{ $about->facebook }}" role="button">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            @endif

                            @if($about->twitter)
                                <a class="btn btn-outline-light btn-floating m-1" target="_black" href="{{ $about->twitter }}" role="button">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            @endif

                            @if($about->whatsapp)
                                <a class="btn btn-outline-light btn-floating m-1" target="_black" href="{{ $about->whatsapp }}" role="button">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            @endif

                            @if($about->instagram)
                                <a class="btn btn-outline-light btn-floating m-1" target="_black" href="{{ $about->instagram }}" role="button">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            @endif

                            @if($about->snapchat)
                                <a class="btn btn-outline-light btn-floating m-1" target="_black" href="{{ $about->snapchat }}" role="button">
                                    <i class="fab fa-snapchat-ghost"></i>
                                </a>
                            @endif
                        </section>
                    </div>
                </div>
            </section>
            <!-- Section: Links -->
        </div>
        <!-- Grid container -->

        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2024 Copyright:
            <a class="text-white" href="#">DNA</a>
        </div>
        <!-- Copyright -->
    </footer>

</div>
<!-- End of .footer-container -->

<!-- End of .footer-container -->

<!-- End of .footer-container -->
