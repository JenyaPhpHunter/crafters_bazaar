<div class="topbar-section section border-bottom animate__animated animate__fadeIn">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 d-flex align-items-center justify-content-between topbar-content">
                <!-- Contact Info (Left Side, Always Visible) -->
                <div class="contact-info">
                    <div class="topbar-menu">
                        <ul class="menu-list">
                            <li class="menu-item">
                                <a href="tel:+380673291419" class="menu-link">
                                    <i class="fa fa-phone"></i> +380 67 329 14 19
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <i class="fa fa-map-marker-alt"></i> Локація магазину
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Free Shipping Info (Centered, Expandable) -->
                <div class="free-shipping-wrapper">
                    <p class="promo-text my-0">Безкоштовна доставка при замовленні від 1000 грн</p>
                </div>

                <!-- Language & Currency (Right Side, Always Visible) -->
                <div class="language-currency">
                    <ul class="header-lan-curr text-white d-flex align-items-center">
                        @php
                            $locales = [
                                'uk' => 'Українська',
                                'en' => 'English',
                            ];
                            $currentLocale = app()->getLocale();
                        @endphp

                        <li class="lan-item dropdown">
                            <a href="#" class="dropdown-toggle menu-link" data-toggle="dropdown">
                                {{ $locales[$currentLocale] }} <i class="fa fa-angle-down ml-1"></i>
                            </a>
                            <ul class="curr-lan-sub-menu dropdown-menu">
                                @foreach($locales as $code => $label)
                                    @if($code !== $currentLocale)
                                        <li>
                                            <a href="{{ route('locale.switch', $code) }}" class="dropdown-item">{{ $label }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>

                        @php
                            $currencies = ['UAH', 'USD', 'EUR'];
                            $currentCurrency = session('currency', 'UAH');
                        @endphp

                        <li class="curr-item dropdown">
                            <a href="#" class="dropdown-toggle menu-link" data-toggle="dropdown">
                                {{ $currentCurrency }} <i class="fa fa-angle-down ml-1"></i>
                            </a>
                            <ul class="curr-lan-sub-menu dropdown-menu">
                                @foreach($currencies as $currency)
                                    @if($currency !== $currentCurrency)
                                        <li>
                                            <a href="{{ route('currency.switch', $currency) }}" class="dropdown-item">{{ $currency }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
