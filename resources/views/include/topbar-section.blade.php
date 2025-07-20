<!-- Topbar Section Start -->
<div class="topbar-section section border-bottom">
    <div class="container">
        <div class="row align-items-center">
            <div class="col d-none d-md-block">
                <div class="topbar-menu">
                    <ul>
                        <li><a href="#"><i class="fa fa-phone"></i> 067 329 14 19</a></li>
                        <li><a href="#"><i class="fa fa-map-marker-alt"></i>Локація магазину</a></li>
                    </ul>
                </div>
            </div>
            <div class="col d-md-none d-lg-block">
                <p class="text-center my-2">Безкоштовна доставка</p>
            </div>

            <!-- Header Language & Currency Start -->
            <div class="col d-none d-md-block">
                <ul class="header-lan-curr text-white justify-content-end">
                    @php
                        $locales = [
                            'uk' => 'Українська',
                            'en' => 'English',
                        ];

                        $currentLocale = app()->getLocale();
                    @endphp

                    <li>
                        <a href="#">{{ $locales[$currentLocale] }}</a>
                        <ul class="curr-lan-sub-menu">
                            @foreach($locales as $code => $label)
                                @if($code !== $currentLocale)
                                    <li>
                                        <a href="{{ route('locale.switch', $code) }}">{{ $label }}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>

                    @php
                        $currencies = ['UAH', 'USD', 'EUR'];
                        $currentCurrency = session('currency', 'UAH');
                    @endphp

                    <li>
                        <a href="#">{{ $currentCurrency }}</a>
                        <ul class="curr-lan-sub-menu">
                            @foreach($currencies as $currency)
                                @if($currency !== $currentCurrency)
                                    <li>
                                        <a href="{{ route('currency.switch', $currency) }}">{{ $currency }}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- Header Language & Currency End -->
        </div>
    </div>
</div>
<!-- Topbar Section End -->
