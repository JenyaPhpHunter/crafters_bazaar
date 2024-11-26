<div class="footer3-section section section-fluid section-padding bg-light">
    <div class="container">
        <div class="row learts-mb-n40">

            <div class="col-xl-4 col-lg-5 col-12 learts-mb-40">
                <div class="widget-contact">
                    <p class="email">jenyaphphunter@gmail.com</p>
                    <p class="phone">(+38) 067 3291419</p>
                    <div class="app-buttons">
                        <a href="#"><img src="{{ asset('images/others/android.webp') }}" alt=""></a>
                        <a href="#"><img src="{{ asset('images/others/ios.webp') }}" alt=""></a>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-7 col-12 learts-mb-40">
                <div class="row row-cols-sm-3 row-cols-1 learts-mb-n40">
                    <div class="col learts-mb-40">
                        <ul class="widget-list">
                            <li><a href="#">Для чоловіків</a></li>
                            <li><a href="#">Для жінок</a></li>
                            <li><a href="#">Аксесуари</a></li>
                            <li><a href="#">розпродаж</a></li>
                        </ul>
                    </div>
                    <div class="col learts-mb-40">
                        <ul class="widget-list">
                            <li><a href="#">Про нас</a></li>
                            <li><a href="#">Локація магазину</a></li>
                            <li><a href="#">Контакти</a></li>
                            <li><a href="#">Політика підтримки</a></li>
                            <li><a href="#">FAQs</a></li>
                        </ul>
                    </div>
                    <div class="col learts-mb-40">
                        <ul class="widget-list">
                            <li> <i class="fab fa-twitter"></i> <a href="https://www.twitter.com/">Twitter</a></li>
                            <li> <i class="fab fa-facebook-f"></i> <a href="https://www.facebook.com/">Facebook</a></li>
                            <li> <i class="fab fa-instagram"></i> <a href="https://www.instagram.com/">Instagram</a></li>
                            <li> <i class="fab fa-youtube"></i> <a href="https://www.youtube.com/">Youtube</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-12 learts-mb-40">
                <h5 class="widget-title mb-2">Підписка</h5>
                <form id="subscribe_news" class="mc-form widget-subscibe2" action="{{ route('subscribe.toggle') }}" method="POST">
                    @csrf
                    <input id="subscribe-email" name="email" type="email" placeholder="Введіть ваш e-mail" @if($user)value="{{ $user->email }}"@endif>
                    <button id="subscribe-submit" class="btn">Підписатися</button>
                </form>
{{--                <!-- mailchimp-alerts Start -->--}}
{{--                <div class="mailchimp-alerts text-centre">--}}
{{--                    <div class="mailchimp-submitting"></div><!-- mailchimp-submitting end -->--}}
{{--                    <div class="mailchimp-success text-success"></div><!-- mailchimp-success end -->--}}
{{--                    <div class="mailchimp-error text-danger"></div><!-- mailchimp-error end -->--}}
{{--                </div><!-- mailchimp-alerts end -->--}}
            </div>
        </div>
    </div>
</div>

<div class="footer3-bottom section section-fluid section-padding bg-light pt-0">
    <div class="container">
        <div class="row align-items-end learts-mb-n40">

            <div class="col-md-4 col-12 learts-mb-40 order-md-2">
                <div class="widget-about text-center">
                    <img src="{{ asset('images/logo/logo.webp') }}" alt="">
                </div>
            </div>

            <div class="col-md-4 col-12 learts-mb-40 order-md-3">
                <div class="widget-payment text-center text-md-right">
                    <img src="{{ asset('images/others/pay.webp') }}" alt="">
                </div>
            </div>

            <div class="col-md-4 col-12 learts-mb-40 order-md-1">
                <div class="widget-copyright">
                    <p class="copyright text-center text-md-left">&copy; 2023 Ribalkin. All Rights Reserved</p>
                </div>
            </div>

        </div>
    </div>
</div>
