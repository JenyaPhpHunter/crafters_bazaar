@extends('layouts.app')

@section('content')
    <!-- My Account Section Start -->
    <div class="section section-padding">
        <div class="container">
            <div class="row learts-mb-n30">

                <!-- My Account Tab List Start -->
                <div class="col-lg-4 col-12 learts-mb-30">
                    <div class="myaccount-tab-list nav">
                        <a href="#dashboad" class="{{ session('activeTab') == 'dashboad' ? 'active' : '' }}" data-bs-toggle="tab">Dashboard <i class="far fa-home"></i></a>
                        <a href="#orders" class="{{ session('activeTab') == 'orders' ? 'active' : '' }}" data-bs-toggle="tab">Замовлення <i class="far fa-file-alt"></i></a>
                        <a href="#download" class="{{ session('activeTab') == 'download' ? 'active' : '' }}" data-bs-toggle="tab">Завантажити <i class="far fa-arrow-to-bottom"></i></a>
                        <a href="#address" class="{{ session('activeTab') == 'address' ? 'active' : '' }}" data-bs-toggle="tab">Адреса <i class="far fa-map-marker-alt"></i></a>
                        <a href="#account-info" class="{{ session('activeTab') == 'account-info' ? 'active' : '' }}" data-bs-toggle="tab">Дані користувача <i class="far fa-user"></i></a>
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
                        <div class="tab-pane fade {{ session('activeTab') == 'dashboad' ? 'show active' : '' }}" id="dashboad">
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
                        <div class="tab-pane fade {{ session('activeTab') == 'orders' ? 'show active' : '' }}" id="orders">
                            <div class="myaccount-content order">
                                <div class="table-responsive">
                                    @if($orders->isNotEmpty() && $sendingss->isNotEmpty())
                                        <table class="table">
                                            @if($orders->isNotEmpty())
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
                                            @else
                                                У Вас ще немає замовлень
                                            @endif
                                            @if($orders->isNotEmpty())
                                                <thead>
                                                <tr>
                                                    <th>Відправлення</th>
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
                                                @foreach($sendings as $sending)
                                                    <tr>
                                                        <td>  1 </td>>
                                                        <td>  1 </td>>
                                                        <td>  1 </td>>
                                                        <td>  1 </td>>
                                                        @php
                                                            $counter ++;
                                                        @endphp
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            @else
                                                У Вас ще немає відправок
                                            @endif
                                        </table>
                                    @else
                                        У Вас ще немає замовлень та відправок
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Single Tab Content End -->

                        <!-- Single Tab Content Start -->
                        <div class="tab-pane fade {{ session('activeTab') == 'download' ? 'show active' : '' }}" id="download">
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
                                                       @php
                                                           $regionValue = old('region', $user->region->title ?? '');
                                                       @endphp

                                                       @if(!empty($user))
                                                           value="{{ $regionValue }}"
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
                                            @php
                                                $addressParts = $user->getAddressParts();
                                            @endphp
                                            <div class="col-6 learts-mb-20">
                                                <label for="bdAddress1">Вулиця</label>
                                                <input type="text" id="bdAddress1" name="street" placeholder="вулиця"
                                                       value="{{ old('street', $addressParts['street'] ?? '') }}"
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
                                                       value="{{ old('home', $addressParts['home'] ?? '') }}"
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
                                                       value="{{ old('apartment', $addressParts['apartment'] ?? '') }}">
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
                        <!-- Single Tab Content Start -->
                        <div class="tab-pane fade {{ session('activeTab') == 'account-info' ? 'show active' : '' }}" id="account-info">
                            <div class="myaccount-content account-details">
                                <div class="account-details-form">
                                    <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="previous_page" value="{{ session('previous_page') }}">
                                        <div class="row learts-mb-n30">
                                            <div class="col-md-6 col-12 learts-mb-30">
                                                <div class="single-input-item">
                                                    <label for="surname">Прізвище <abbr class="required">*</abbr></label>
                                                    <input type="text" id="surname" name="surname" value="{{ $user->surname }}">
                                                </div>
                                                @error('surname')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 col-12 learts-mb-30">
                                                <div class="single-input-item">
                                                    <label for="name">Ім'я <abbr class="required">*</abbr></label>
                                                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}">
                                                </div>
                                                @error('name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror

                                            </div>
                                            <div class="col-md-12 col-12 learts-mb-30">
                                                <div class="single-input-item">
                                                    <label for="secondname">По-батькові</label>
                                                    <input type="text" id="secondname" name="secondname" value="{{ old('secondname', $user->secondname) }}">
                                                </div>
                                                @error('secondname')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 col-12 learts-mb-30">
                                                <div class="single-input-item">
                                                    <label for="email">Email <abbr class="required">*</abbr></label>
                                                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" readonly>
                                                </div>
                                                @error('email')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 col-12 learts-mb-30">
                                                <div class="single-input-item">
                                                    <label for="phone">Телефон <abbr class="required">*</abbr></label>
                                                    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                                </div>
                                                @error('phone')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12 learts-mb-30 learts-mt-30">
                                                <fieldset>
                                                    <legend>Зміна паролю</legend>
                                                    <div class="row learts-mb-n30">
                                                        <div class="col-12 learts-mb-30">
                                                            <label for="current-pwd">Поточний пароль (залиште порожнім, щоб залишити без змін)</label>
                                                            <input type="password" id="current-pwd" name="current_password">
                                                        </div>
                                                        <div class="col-12 learts-mb-30">
                                                            <label for="new-pwd">Новий пароль (залиште порожнім, щоб залишити без змін)</label>
                                                            <input type="password" id="new-pwd" name="new_password">
                                                        </div>
                                                        <div class="col-12 learts-mb-30">
                                                            <label for="confirm-pwd">Підтвердження нового паролю</label>
                                                            <input type="password" id="confirm-pwd" name="new_password_confirmation">
                                                        </div>
                                                        @error('new_password_confirmation')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-12 learts-mb-30">
                                                <button type="submit" class="btn btn-dark btn-outline-hover-dark">Зберегти зміни</button>
                                            </div>
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



