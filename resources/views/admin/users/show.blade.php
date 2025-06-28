@extends('admin.layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- My Account Section Start -->
    <div class="section section-padding">
        <div class="container">
            <div class="row learts-mb-n30">

                <!-- My Account Tab List Start -->
                <div class="col-lg-4 col-12 learts-mb-30">
                    <div class="myaccount-tab-list nav">
                        <a href="#dashboad" class="active" data-bs-toggle="tab">Dashboard <i class="far fa-home"></i></a>
                        <a href="#orders" data-bs-toggle="tab">Замовлення <i class="far fa-file-alt"></i></a>
                        <a href="#download" data-bs-toggle="tab">Завантажити <i class="far fa-arrow-to-bottom"></i></a>
                        <a href="#address" data-bs-toggle="tab">Адреса <i class="far fa-map-marker-alt"></i></a>
                        <a href="#account-info" data-bs-toggle="tab">Дані користувача <i class="far fa-user"></i></a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Вихід <i class="far fa-sign-out-alt"></i></a>
                    </div>
                </div>
                <!-- My Account Tab List End -->

                <!-- My Account Tab Content Start -->
                <div class="col-lg-8 col-12 learts-mb-30">
                    <div class="tab-content">

                        <!-- Single Tab Content Start -->
                        <div class="tab-pane fade show active" id="dashboad">
                            <div class="myaccount-content dashboad">
                                <p>Вітаю, <strong>{{ $user->name }} !</strong></p>
                                <p>На інформаційній панелі свого облікового запису ви можете переглядати свої
                                    <span><a href="#orders">останні замовлення</a></span>,
                                    керувати Вашими
                                    <span><a href="#address">адресами доставки</a></span>,
                                    а також
                                    <span><a href="#account-info">редагувати пароль і дані облікового запису</a></span>.
                                </p>
                            </div>
                        </div>
                        <!-- Single Tab Content End -->

                        <!-- Single Tab Content Start -->
                        <div class="tab-pane fade" id="orders">
                            <div class="myaccount-content order">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Замовлення</th>
                                            <th>Дата</th>
                                            <th>Статус</th>
                                            <th>Всього</th>
                                            {{--                                            <th>Дія</th>--}}
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $counter = 1;
                                        @endphp
                                        @foreach($orders as $order)
                                            <tr>
                                                <td><a href="{{ route('orders.show',['order' => $order->id]) }}">{{ $counter }}</a></td>
                                                <td><a href="{{ route('orders.show',['order' => $order->id]) }}">{{ $order->updated_at }}</a></td>
                                                <td><a href="{{ route('orders.show',['order' => $order->id]) }}">{{ $order->status_order->name }}</a></td>
                                                <td><a href="{{ route('orders.show',['order' => $order->id]) }}">{{ $order->sum_order }}</a></td>
                                                {{--                                                <td><a href="shopping-cart.html">View</a></td>--}}
                                                @php
                                                    $counter ++;
                                                @endphp
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Single Tab Content End -->

                        <!-- Single Tab Content Start -->
                        <div class="tab-pane fade" id="download">
                            <div class="myaccount-content download">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Date</th>
                                            <th>Expire</th>
                                            <th>Download</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Haven - Free Real Estate PSD Template</td>
                                            <td>Aug 22, 2018</td>
                                            <td>Yes</td>
                                            <td><a href="#"><i class="far fa-arrow-to-bottom mr-1"></i> Download File</a></td>
                                        </tr>
                                        <tr>
                                            <td>HasTech - Profolio Business Template</td>
                                            <td>Sep 12, 2018</td>
                                            <td>Never</td>
                                            <td><a href="#"><i class="far fa-arrow-to-bottom mr-1"></i> Download File</a></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Single Tab Content End -->

                        <!-- Single Tab Content Start -->
                        <div class="tab-pane fade {{ session('activeTab') == 'address' ? 'show active' : '' }}" id="address">
                            <div class="myaccount-content address">
                                <p>Ця адреса буде використовуватись на сторінці оформлення замовлення за замовчуванням.
                                    <br>
                                    Але це не заважає змінити її в момент оформлення замовлення.</p>
                                <div class="account-address-form">
                                    <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="address" value="1">
                                        <div class="row learts-mb-n30">
                                            <div class="col-6 learts-mb-20">
                                                <input type="text" id="bdTownOrRegion" name="region" placeholder="Область"
                                                       @if(!empty($user))
                                                           @if($user->region) value="{{ old('region', $user->region->title ?? '') }}"
                                                       @else value="{{ old('region') }}"
                                                       @endif
                                                       @endif
                                                       class="form-control @error('region') is-invalid @enderror">
                                                @error('region')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                                <ul id="regionList"></ul>
                                            </div>

                                            <!-- HTML для поля міст -->
                                            <div class="col-6 learts-mb-20">
                                                <input type="text" id="bdTownOrCity" name="city" placeholder="Населений пункт (місто/село)"
                                                       @if(!empty($user))
                                                           @if($user->city) value="{{ old('city', $user->city->title ?? '') }}"
                                                       @else value="{{ old('city') }}"
                                                       @endif
                                                       @endif
                                                       class="form-control @error('city') is-invalid @enderror">
                                                @error('city')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
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
                                                    const filteredRegions = regionsAndCities.filter(region => region.region_title.toLowerCase().includes(searchText));

                                                    // Очищаємо список областей
                                                    regionList.innerHTML = "";

                                                    // Додаємо знайдені області до списку
                                                    filteredRegions.forEach(region => {
                                                        const li = document.createElement("li");
                                                        li.textContent = region.region_title;
                                                        li.addEventListener("click", () => {
                                                            townOrRegionInput.value = region.region_title;
                                                            regionList.innerHTML = ""; // Сховати список після вибору
                                                        });
                                                        regionList.appendChild(li);
                                                    });
                                                }

                                                // Функція фільтрації списку міст
                                                function filterCities() {
                                                    const searchText = townOrCityInput.value.toLowerCase();
                                                    const selectedRegion = townOrRegionInput.value;
                                                    const citiesInRegion = regionsAndCities.find(region => region.region_title === selectedRegion)?.cities || [];
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
                                                <input type="text" id="bdAddress1" name="street" placeholder="назва вулиці"
                                                       value="{{ old('street', $address['street'] ?? '') }}"
                                                       class="form-control @error('street') is-invalid @enderror">
                                                @error('street')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="col-3 learts-mb-20">
                                                <label for="bdHouseNumber">№ Будинку</label>
                                                <input type="text" id="bdHouseNumber" name="home" placeholder="номер будинку"
                                                       value="{{ old('home', $address['home'] ?? '') }}"
                                                       class="form-control @error('home') is-invalid @enderror">
                                                @error('home')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="col-3 learts-mb-20">
                                                <label for="bdApartment">№ Квартири</label>
                                                <input type="text" id="bdApartment" name="apartment" placeholder="номер квартири"
                                                       value="{{ $address['apartment'] }}">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-12 learts-mb-30">
                                            <button type="submit" class="btn btn-dark btn-outline-hover-dark">Зберегти зміни</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Single Tab Content End -->
                    </div>
                </div> <!-- My Account Tab Content End -->
            </div>
        </div>
    </div>
    <!-- My Account Section End -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function activateTabFromHash() {
                var hash = window.location.hash;
                if (hash && document.querySelector(hash)) {
                    // Видаляємо активний клас з інших вкладок
                    document.querySelectorAll('.myaccount-tab-list a').forEach(function(tab) {
                        tab.classList.remove('active');
                    });

                    // Додаємо активний клас до поточної вкладки
                    var targetTab = document.querySelector('.myaccount-tab-list a[href="' + hash + '"]');
                    if (targetTab) {
                        targetTab.classList.add('active');
                        var targetPane = document.querySelector(hash);
                        if (targetPane) {
                            // Видаляємо активний клас з інших панелей
                            document.querySelectorAll('.tab-pane').forEach(function(pane) {
                                pane.classList.remove('show', 'active');
                            });

                            // Додаємо активний клас до поточної панелі
                            targetPane.classList.add('show', 'active');
                        }
                    }
                }
            }

            activateTabFromHash();

            // Виклик функції при зміні хеша
            window.addEventListener('hashchange', function() {
                activateTabFromHash();
            });
        });

    </script>

@endsection



