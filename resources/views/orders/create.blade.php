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
                                <td width="150"><img src="{{ asset( $cartItem->product->productphotos[0]->path . '/' . $cartItem->product->productphotos[0]->filename) }}" alt="Product Image"></td>
                                <td class="name"><a href="{{route('products.show', ['product' => $cartItem->product->id]) }}">{{ $cartItem->product->name }}&nbsp; <strong class="quantity">×&nbsp;{{ $cartItem->quantity }}</strong></td>
                                <td class="total"><span>{{ $cartItem->price * $cartItem->quantity }} грн</span></td>
                                @php
                                    $subtotal = $subtotal + $cartItem->price;
                                    $total = $total + $cartItem->price;
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
{{--                    <div class="col-12 learts-mb-20">--}}
{{--                        <label for="bdCountry">Країна <abbr class="required">*</abbr></label>--}}
{{--                        <select id="bdCountry" class="select2-basic">--}}
{{--                            <option value="">Виберіть країну…</option>--}}
{{--                            @foreach($countries as $countryCode => $countryName)--}}
{{--                                <option value="{{ $countryCode }}" {{ $countryCode === 'UA' ? 'selected' : '' }}>{{ $countryName }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </div>--}}
                    <!-- HTML для поля областей -->
                    <label style="text-align: center; font-weight: bold; font-style: italic;">Місце доставки <abbr class="required">*</abbr></label>
                    <div class="col-6 learts-mb-20">
                        <input type="text" id="bdTownOrRegion" name="region" placeholder="Область">
                        <ul id="regionList"></ul>
                    </div>

                    <!-- HTML для поля міст -->
                    <div class="col-6 learts-mb-20">
                        <input type="text" id="bdTownOrCity" name="city" placeholder="Населенний пункт (місто/село)">
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
                        {{--const regionsAndCities = @json($arr_region_cities);--}}

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

                        {{--// Селектор для поля областей--}}
                        {{--const townOrRegionInput = document.getElementById("bdTownOrRegion");--}}
                        {{--const regionList = document.getElementById("regionList");--}}

                        {{--// Селектор для поля міст--}}
                        {{--const townOrCityInput = document.getElementById("bdTownOrCity");--}}
                        {{--const cityList = document.getElementById("cityList");--}}

                        {{--// Масив областей та міст (ваші дані з бази)--}}
                        {{--const regionsAndCities = <?= json_encode($arr_region_cities) ?>;--}}

                        {{--// Функція фільтрації списку областей--}}
                        {{--function filterRegions() {--}}
                        {{--    const searchText = townOrRegionInput.value.toLowerCase();--}}
                        {{--    const filteredRegions = Object.keys(regionsAndCities).filter(region => region.toLowerCase().includes(searchText));--}}

                        {{--    // Очищаємо список областей--}}
                        {{--    regionList.innerHTML = "";--}}

                        {{--    // Додаємо знайдені області до списку--}}
                        {{--    filteredRegions.forEach(region => {--}}
                        {{--        const li = document.createElement("li");--}}
                        {{--        li.textContent = region;--}}
                        {{--        li.addEventListener("click", () => {--}}
                        {{--            townOrRegionInput.value = region;--}}
                        {{--            regionList.innerHTML = ""; // Сховати список після вибору--}}
                        {{--        });--}}
                        {{--        regionList.appendChild(li);--}}
                        {{--    });--}}
                        {{--}--}}

                        {{--// Функція фільтрації списку міст--}}
                        {{--function filterCities() {--}}
                        {{--    const searchText = townOrCityInput.value.toLowerCase();--}}
                        {{--    const selectedRegion = townOrRegionInput.value;--}}
                        {{--    const citiesInRegion = regionsAndCities[selectedRegion] || [];--}}
                        {{--    const filteredCities = citiesInRegion.filter(city => city.toLowerCase().includes(searchText));--}}

                        {{--    // Очищаємо список міст--}}
                        {{--    cityList.innerHTML = "";--}}

                        {{--    // Додаємо знайдені міста до списку--}}
                        {{--    filteredCities.forEach(city => {--}}
                        {{--        const li = document.createElement("li");--}}
                        {{--        li.textContent = city;--}}
                        {{--        li.addEventListener("click", () => {--}}
                        {{--            townOrCityInput.value = city;--}}
                        {{--            cityList.innerHTML = ""; // Сховати список після вибору--}}
                        {{--        });--}}
                        {{--        cityList.appendChild(li);--}}
                        {{--    });--}}
                        {{--}--}}

                        {{--// Обробники подій--}}
                        {{--townOrRegionInput.addEventListener("input", filterRegions);--}}
                        {{--townOrCityInput.addEventListener("input", filterCities);--}}

                        {{--document.addEventListener("click", (event) => {--}}
                        {{--    if (event.target !== townOrRegionInput) {--}}
                        {{--        regionList.innerHTML = "";--}}
                        {{--    }--}}
                        {{--    if (event.target !== townOrCityInput) {--}}
                        {{--        cityList.innerHTML = "";--}}
                        {{--    }--}}
                        {{--});--}}

                    </script>
                    <div class="col-6 learts-mb-20">
                        <label for="bdAddress1">Вулиця</label>
                        <input type="text" id="bdAddress1" name="street" placeholder="назва вулиці">
                    </div>
                    <div class="col-3 learts-mb-20">
                        <label for="bdHouseNumber">№ Будинку</label>
                        <input type="text" id="bdHouseNumber" name="home" placeholder="номер будинку">
                    </div>
                    <div class="col-3 learts-mb-20">
                        <label for="bdApartment">№ Квартири</label>
                        <input type="text" id="bdApartment" name="apartment" placeholder="номер квартири">
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
{{--                            <div class="payment-method">--}}
{{--                                <div class="accordion" id="paymentMethod">--}}
{{--                                    <div class="card active">--}}
{{--                                        <div class="card-header">--}}
{{--                                            <button data-bs-toggle="collapse" data-bs-target="#checkPayments">Чекові платежі</button>--}}
{{--                                        </div>--}}
{{--                                        <div id="checkPayments" class="collapse show" data-bs-parent="#paymentMethod">--}}
{{--                                            <div class="card-body">--}}
{{--                                                <p>Будь ласка, надішліть чек на назву магазину, вулицю магазину, місто магазину, штат/округ магазину, поштовий індекс магазину.</p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="card">--}}
{{--                                        <div class="card-header">--}}
{{--                                            <button data-bs-toggle="collapse" data-bs-target="#cashkPayments">Накладений платіж </button>--}}
{{--                                        </div>--}}
{{--                                        <div id="cashkPayments" class="collapse" data-bs-parent="#paymentMethod">--}}
{{--                                            <div class="card-body">--}}
{{--                                                <p>Оплата готівкою при доставці.</p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="card">--}}
{{--                                        <div class="card-header">--}}
{{--                                            <button data-bs-toggle="collapse" data-bs-target="#payPalPayments">PayPal <img src="assets/images/others/pay-2.webp" alt=""></button>--}}
{{--                                        </div>--}}
{{--                                        <div id="payPalPayments" class="collapse" data-bs-parent="#paymentMethod">--}}
{{--                                            <div class="card-body">--}}
{{--                                                <p>Оплата через PayPal; Ви можете оплатити кредитною карткою, якщо у вас немає облікового запису PayPal.</p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="text-center">
                                <p class="payment-note">Ваші особисті дані використовуватимуться для обробки вашого замовлення, підтримки вашого досвіду на цьому веб-сайті та для інших цілей, описаних у нашій політиці конфіденційності.</p>
{{--                                <button class="btn btn-dark btn-outline-hover-dark">Зробити замовлення</button>--}}
                                <button class="btn btn-dark btn-outline-hover-dark" type="submit">Зробити замовлення</button>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div>
    <!-- Checkout Section End -->

{{--<a href="{{route('home')}}">Повернутися на головну сторінку</a>--}}
{{--<br><br>--}}
{{--    <h1>Оформлення замовлення</h1>--}}
{{--    @if ($errors->any())--}}
{{--        <div class="alert alert-danger">--}}
{{--            <ul>--}}
{{--                @foreach ($errors->all() as $error)--}}
{{--                    <li>{{ $error }}</li>--}}
{{--                @endforeach--}}
{{--            </ul>--}}
{{--        </div>--}}
{{--    @endif--}}
{{--    <form method="post" action="{{ route('orders.store') }}">--}}
{{--        @csrf--}}
{{--        <label for="surname">Прізвище</label>--}}
{{--        <br>--}}
{{--        <input id="surname" name="surname" value="{{ $user->surname ?? '' }}">--}}
{{--        <br><br>--}}

{{--        <label for="name">Ім'я</label>--}}
{{--        <br>--}}
{{--        <input id="name" name="name" value="{{ $user->name ?? '' }}">--}}
{{--        <br><br>--}}

{{--        <label for="secondname">По батькові</label>--}}
{{--        <br>--}}
{{--        <input id="secondname" name="secondname" value="{{ $user->secondname ?? '' }}">--}}
{{--        <br><br>--}}

{{--        <label for="phone">Телефон</label>--}}
{{--        <br>--}}
{{--        <input id="phone" name="phone" type="tel" pattern="[0-9]+" value="{{ $user->phone ?? '' }}" required>--}}
{{--        <br><br>--}}

{{--        <label for="email">Email</label>--}}
{{--        <br>--}}
{{--        <input id="email" name="email" value="{{ $user->email }}" autofocus readonly>--}}
{{--        <br><br>--}}

{{--        <label for="delivery_id">Спосіб доставки</label>--}}
{{--        <br>--}}
{{--        <select id="delivery_id" name="delivery_id">--}}
{{--            @foreach($deliveries as $delivery)--}}
{{--                @if(!empty($user->delivery_id))--}}
{{--                    <option value="{{ $delivery->id }}" {{ $user->delivery_id == $delivery->id ? 'selected' : '' }}>--}}
{{--                        {{ $user->delivery_id == $delivery->id ? $user->delivery->name : $delivery->name }}--}}
{{--                    </option>--}}
{{--                @else--}}
{{--                    <option value="{{ $delivery->id }}">{{ $delivery->name }}</option>--}}
{{--                @endif--}}
{{--            @endforeach--}}
{{--        </select>--}}
{{--        <br><br>--}}

{{--        <label for="city">Місто</label>--}}
{{--        <br>--}}
{{--        <input id="city" name="city" value="{{ $user->city ?? '' }}">--}}
{{--        <br><br>--}}

{{--        <label for="address">Адреса</label>--}}
{{--        <br>--}}
{{--        <input id="address" name="address" value="{{ $user->address ?? '' }}">--}}
{{--        <br><br>--}}

{{--        <label for="paymentkind_id">Спосіб оплати</label>--}}
{{--        <br>--}}
{{--        <select id="paymentkind_id" name="paymentkind_id">--}}
{{--            @foreach($payment_kinds as $payment_kind)--}}
{{--                @if(!empty($user->paymentkind_id))--}}
{{--                    <option value="{{ $payment_kind->id }}" {{ $user->paymentkind_id == $payment_kind->id ? 'selected' : '' }}>--}}
{{--                        {{ $user->paymentkind_id == $payment_kind->id ? $user->paymentKind->name : $payment_kind->name }}--}}
{{--                    </option>--}}
{{--                @else--}}
{{--                    <option value="{{ $payment_kind->id }}">{{ $payment_kind->name }}</option>--}}
{{--                @endif--}}
{{--            @endforeach--}}
{{--        </select>--}}
{{--        <br><br>--}}

{{--        <label for="comment">Коментар до замовлення</label>--}}
{{--        <br>--}}
{{--        <textarea id="comment" name="comment" rows="10" cols="50"></textarea>--}}
{{--        <br><br>--}}
{{--@php--}}
{{--$total = 0;--}}
{{--@endphp--}}
{{--        @foreach($baskets as $basket)--}}
{{--            @php--}}
{{--                $total = $total + $basket->sum;--}}
{{--            @endphp--}}
{{--            <hr>--}}
{{--            <div class="product-image">--}}
{{--                <img src="{{ asset($basket->product->image_path) }}" alt="Фото сумки">--}}
{{--            </div>--}}

{{--        <label for="name_product">Назва</label>--}}
{{--        <br>--}}
{{--        <input id="name_product" name="name_product" value="{{ $basket->product->name }}">--}}
{{--        <br><br>--}}

{{--        <label for="quantity">Кількість</label>--}}
{{--        <br>--}}
{{--        <input id="quantity" name="quantity" value="{{ $basket->quantity }}">--}}
{{--        <br><br>--}}

{{--        <label for="sum">Сума</label>--}}
{{--        <br>--}}
{{--        <input id="sum" name="sum" value="{{ $basket->sum }}">--}}
{{--        <br><br>--}}
{{--        @endforeach--}}
{{--        <h2>Разом до сплати = {{$total}}</h2>--}}
{{--        <br><br>--}}

{{--        <input type="submit" value="Відправити замовлення">--}}
{{--        <span style="display: inline-block; width: 100px;"></span>--}}
{{--    </form>--}}

@endsection
