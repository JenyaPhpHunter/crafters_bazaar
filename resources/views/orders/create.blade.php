@extends('layouts.app')

@section('content')
    <!-- Page Title/Header Start -->
    <div class="page-title-section section" data-bg-image="assets/images/bg/page-title-1.webp">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-title">
                        <h1 class="title">Деталі замовлення</h1>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active">Деталі замовлення</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Title/Header End -->
    <div class="section-title2 text-center">
        <h2 class="title">Ваше замовлення</h2>
    </div>
    <div class="container">
        <div class="row learts-mb-n30">
            <div class="col-lg-12 order-lg-2 learts-mb-30">
                <div class="order-review">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="name"></th>
                            <th class="name">Товар</th>
                            <th class="total">Вартість</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $subtotal = 0;
                            $total = 0
                        @endphp
                        @foreach($cartItems as $cartItem)
                            <tr>
                                @if(!empty($cartItem->product) && !empty($cartItem->product->productphotos) && count($cartItem->product->productphotos) > 0)
                                    <td width="150"><img src="{{ asset( $cartItem->product->productphotos[0]->path . '/' . $cartItem->product->productphotos[0]->filename) }}" alt="Product Image"></td>
                                @else
                                    <td></td>
                                @endif
                                <td class="name"><a href="{{route('products.show', ['product' => $cartItem->product->id]) }}">{{ $cartItem->product->name }}&nbsp; <strong class="quantity">×&nbsp;{{ $cartItem->quantity }}</strong></td>
                                <td class="total"><span>{{ $cartItem->price * $cartItem->quantity }} грн</span></td>
                                @php
                                    $subtotal = $subtotal + $cartItem->price * $cartItem->quantity;
                                    $total = $total + $cartItem->price * $cartItem->quantity;
                                @endphp
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr class="subtotal">
                            <th colspan="2">Вартість без знижки</th>
                            <td><span>{{ $subtotal }} грн</span></td>
                        </tr>
                        <tr class="total">
                            <th colspan="2">Загальна вартість</th>
                            <td><strong><span>{{ $total }} грн</span></strong></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Checkout Section Start -->
    <div class="section section-padding">
        <div class="container">
            <div class="checkout-coupon">
                <p class="coupon-toggle">маєте код знижки? <a href="#checkout-coupon-form" data-bs-toggle="collapse">Натисніть тут, щоб ввести свій код</a></p>
                <div id="checkout-coupon-form" class="collapse">
                    <div class="coupon-form">
                        <p>Якщо у вас є код знижки, застосуйте його нижче.</p>
                        <form action="#" class="learts-mb-n10">
                            <input class="learts-mb-10" type="text" placeholder="Coupon code">
                            <button class="btn btn-dark btn-outline-hover-dark learts-mb-10">застосувати купон</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="section-title2">
                <h2 class="title">Ваші дані</h2>
            </div>
            <form class="checkout-form learts-mb-50" method="post" action="{{ route('orders.store') }}">
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 col-12 learts-mb-20">
                        <label for="name">Ім'я <abbr class="required">*</abbr></label>
                        <input type="text" id="name" name="name" value="{{ $user->name ?? '' }}">
                    </div>
                    <div class="col-md-6 col-12 learts-mb-20">
                        <label for="bdSecondName">По-батькові</label>
                        <input type="text" id="bdSecondName" name="secondname" value="{{ $user->secondname ?? '' }}">
                    </div>
                    <div class="col-12 learts-mb-20">
                        <label for="surname">Прізвище <abbr class="required">*</abbr></label>
                        <input type="text" id="surname" name="surname" value="{{ $user->surname ?? '' }}">
                    </div>
                    <div class="col-md-6 col-12 learts-mb-20">
                        <label for="bdEmail">Email <abbr class="required">*</abbr></label>
                        <input type="text" id="bdEmail" name="email" value="{{ $user_email ?? '' }}">
                    </div>
                    <div class="col-md-6 col-12 learts-mb-30">
                        <label for="bdPhone">Телефон <abbr class="required">*</abbr></label>
                        <input type="text" id="bdPhone" name="phone" value="{{ $user->phone ?? '' }}">
                    </div>
                    <label style="text-align: center; font-weight: bold; font-style: italic;">Спосіб доставки <abbr class="required">*</abbr></label>
                    @foreach($deliveries as $delivery)
                        <div class="form-check form-check-inline">
                            <input type="radio" id="deliveryType{{ $delivery->id }}" name="delivery_id" value="{{ $delivery->id }}" @if($user->delivery_id == $delivery->id) checked @endif class="form-check-input">
                            <label class="form-check-label" for="deliveryType{{ $delivery->id }}">
                                {{ $delivery->name }}
                            </label>
                        </div>
                    @endforeach
                    <!-- HTML для поля областей -->
                    <label style="text-align: center; font-weight: bold; font-style: italic;">Місце доставки <abbr class="required">*</abbr></label>
                    <div class="col-6 learts-mb-20">
                        <input type="text" id="bdTownOrRegion" name="region" placeholder="Область" @if($user->region) value="{{ $user->region->name }}" @endif>
                        <ul id="regionList"></ul>
                    </div>

                    <!-- HTML для поля міст -->
                    <div class="col-6 learts-mb-20">
                        <input type="text" id="bdTownOrCity" name="city" placeholder="Населенний пункт (місто/село)"  @if($user->city) value="{{ $user->city->name }}" @endif>
                        <ul id="cityList"></ul>
                    </div>
                    <script>
                        // Селектор для поля областей
                        const townOrRegionInput = document.getElementById("bdTownOrRegion");
                        const regionList = document.getElementById("regionList");

                        // Селектор для поля міст
                        const townOrCityInput = document.getElementById("bdTownOrCity");
                        const cityList = document.getElementById("cityList");

                        // Масив областей та міст (ваші дані з бази)
                        // Масив областей та міст (ваші дані з бази)
                        const regionsAndCities = @json(array_values($arr_region_cities));

                        // Функція фільтрації списку областей
                        function filterRegions() {
                            const searchText = townOrRegionInput.value.toLowerCase();
                            const filteredRegions = regionsAndCities.filter(region => region.region_name.toLowerCase().includes(searchText));

                            // Очищаємо список областей
                            regionList.innerHTML = "";

                            // Додаємо знайдені області до списку
                            filteredRegions.forEach(region => {
                                const li = document.createElement("li");
                                li.textContent = region.region_name;
                                li.addEventListener("click", () => {
                                    townOrRegionInput.value = region.region_name;
                                    regionList.innerHTML = ""; // Сховати список після вибору
                                });
                                regionList.appendChild(li);
                            });
                        }

                        // Функція фільтрації списку міст
                        function filterCities() {
                            const searchText = townOrCityInput.value.toLowerCase();
                            const selectedRegion = townOrRegionInput.value;
                            const citiesInRegion = regionsAndCities.find(region => region.region_name === selectedRegion)?.cities || [];
                            const filteredCities = citiesInRegion.filter(city => city.toLowerCase().includes(searchText));

                            // Очищаємо список міст
                            cityList.innerHTML = "";

                            // Додаємо знайдені міста до списку
                            filteredCities.forEach(city => {
                                const li = document.createElement("li");
                                li.textContent = city;
                                li.addEventListener("click", () => {
                                    townOrCityInput.value = city;
                                    cityList.innerHTML = ""; // Сховати список після вибору
                                });
                                cityList.appendChild(li);
                            });
                        }

                        // Обробники подій
                        townOrRegionInput.addEventListener("input", filterRegions);
                        townOrCityInput.addEventListener("input", filterCities);

                        document.addEventListener("click", (event) => {
                            if (event.target !== townOrRegionInput) {
                                regionList.innerHTML = "";
                            }
                            if (event.target !== townOrCityInput) {
                                cityList.innerHTML = "";
                            }
                        });
                    </script>
                    <div class="col-6 learts-mb-20">
                        <label for="bdAddress1">Вулиця</label>
                        <input type="text" id="bdAddress1" name="street" placeholder="назва вулиці" value="{{ $address['street'] }}">
                    </div>
                    <div class="col-3 learts-mb-20">
                        <label for="bdHouseNumber">№ Будинку</label>
                        <input type="text" id="bdHouseNumber" name="home" placeholder="номер будинку" value="{{ $address['home'] }}">
                    </div>
                    <div class="col-3 learts-mb-20">
                        <label for="bdApartment">№ Квартири</label>
                        <input type="text" id="bdApartment" name="apartment" placeholder="номер квартири" value="{{ $address['apartment'] }}">
                    </div>
                    <div class="col-12 learts-mb-40">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="callMe" name="callMe">
                            <label class="form-check-label" for="callMe">Передзвонити Вам?</label>
                        </div>
                    </div>
                    <div class="col-12 learts-mb-20">
                        <label for="bdOrderNote">Примітки до замовлення</label>
                        <textarea id="bdOrderNote" name="bdOrderNote" placeholder="Примітки щодо вашого замовлення, наприклад спеціальні примітки для доставки"></textarea>
                    </div>
                </div>
                <div class="col-lg-12 order-lg-1 learts-mb-30">
                    <div class="order-payment">
                        <div class="payment-method">
                            <div class="accordion" id="paymentMethod">
                                @foreach($payment_kinds as $payment_kind)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_type" id="paymentType{{ $payment_kind->id }}" value="{{ $payment_kind->id }}" {{ $payment_kind->id == $user->kind_payment_id ? 'checked' : '' }}>
                                        <label class="form-check-label" for="paymentType{{ $payment_kind->id }}">
                                            {{ $payment_kind->name }}
                                        </label>
                                        <div id="checkPayments{{ $payment_kind->id }}" class="collapse" data-bs-parent="#paymentMethod">
                                            <div class="card-body">
                                                <p>{{ $payment_kind->comment }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="text-center">
                            <p class="payment-note">Ваші особисті дані використовуватимуться для обробки вашого замовлення, підтримки вашого досвіду на цьому веб-сайті та для інших цілей, описаних у нашій політиці конфіденційності.</p>
                            <button class="btn btn-dark btn-outline-hover-dark" type="submit">Зробити замовлення</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Checkout Section End -->
@endsection
