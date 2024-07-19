@extends('layouts.app')

@section('content')

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
                        <div class="tab-pane fade" id="address">
                            <div class="myaccount-content address">
                                <p>Ця адреса буде використовуватись на сторінці оформлення замовлення за замовчуванням.</p>
                                <div class="row learts-mb-n30">
                                    <div class="col-md-6 col-12 learts-mb-30">
                                        <h4 class="title">Адреса доставки <a href="#" class="edit-link">редагувати</a></h4>
                                        <address>
                                            <p><strong>{{ isset($user->name) ? $user->name : '' }} {{ isset($user->secondname) ? $user->secondname : '' }} {{ isset($user->surname) ? $user->surname : '' }}</strong></p>
                                            @isset($user->region))
                                                <p>{{ $user->region->name }}<br>
                                            @endisset
                                            @isset($user->city)
                                                <p>{{ $user->city->name }}<br>
                                            @endisset
                                            @isset($user->address)
                                                {{ $user->address }}</p>
                                            @endisset
                                            @isset($user->phone)
                                                <p>Телефон: {{ $user->phone }}</p>
                                            @endisset
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Single Tab Content End -->

                        <!-- Single Tab Content Start -->
                        <div class="tab-pane fade" id="account-info">
                            <div class="myaccount-content account-details">
                                <div class="account-details-form">
                                    <form action="#">
                                        <div class="row learts-mb-n30">
                                            <div class="col-md-6 col-12 learts-mb-30">
                                                <div class="single-input-item">
                                                    <label for="first-name">Прізвище <abbr class="required">*</abbr></label>
                                                    <input type="text" id="first-name" value={{ $user->surname }}>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 learts-mb-30">
                                                <div class="single-input-item">
                                                    <label for="surname">Ім'я <abbr class="required">*</abbr></label>
                                                    <input type="text" id="surname" value={{ $user->name }}>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 learts-mb-30">
                                                <div class="single-input-item">
                                                    <label for="secondname">По-батькові</label>
                                                    <input type="text" id="secondname" value={{ $user->secondname }}>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 learts-mb-30">
                                                <div class="single-input-item">
                                                    <label for="email">Email<abbr class="required">*</abbr></label>
                                                    <input type="email" id="email" value={{ $user->email }} readonly>
                                                </div>
                                            </div>
                                            <div class="col-12 learts-mb-30 learts-mt-30">
                                                <fieldset>
                                                    <legend>Зміна паролю</legend>
                                                    <div class="row learts-mb-n30">
                                                        <div class="col-12 learts-mb-30">
                                                            <label for="current-pwd">Поточний пароль (залиште порожнім, щоб залишити без змін)</label>
                                                            <input type="password" id="current-pwd">
                                                        </div>
                                                        <div class="col-12 learts-mb-30">
                                                            <label for="new-pwd">Новий пароль (залиште порожнім, щоб залишити без змін)</label>
                                                            <input type="password" id="new-pwd">
                                                        </div>
                                                        <div class="col-12 learts-mb-30">
                                                            <label for="confirm-pwd">Підтвердження нового паролю</label>
                                                            <input type="password" id="confirm-pwd">
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-12 learts-mb-30">
                                                <button class="btn btn-dark btn-outline-hover-dark">Зберегти зміни</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> <!-- Single Tab Content End -->

                    </div>
                </div> <!-- My Account Tab Content End -->
            </div>
        </div>
    </div>
    <!-- My Account Section End -->
    <script>
        // Функція для активації вкладки згідно ідентифікатора в URL
        function activateTabFromHash() {
            var hash = window.location.hash;
            if ($(hash).length) {
                $('.myaccount-tab-list a[href="' + hash + '"]').tab('show');
            }
        }

        // Викликати функцію після завантаження сторінки
        document.addEventListener('DOMContentLoaded', function() {
            activateTabFromHash();
        });

        // Викликати функцію при зміні хеша в URL
        window.addEventListener('hashchange', function() {
            activateTabFromHash();
        });
    </script>

{{--    <script>--}}
{{--        $(document).ready(function () {--}}
{{--            // Отримати ідентифікатор вкладки з URL--}}
{{--            var hash = window.location.hash;--}}

{{--            // Перевірити, чи існує вкладка з таким ідентифікатором--}}
{{--            if ($(hash).length) {--}}
{{--                // Активувати вкладку та здійснити плавний перехід--}}
{{--                $('.myaccount-tab-list a[href="' + hash + '"]').tab('show');--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}
@endsection



