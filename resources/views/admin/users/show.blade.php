@extends('admin.layouts.app')

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
                                <p>На інформаційній панелі свого облікового запису ви можете переглядати свої <span>останні замовлення</span>, керувати Вашими <span>адресами доставки</span>, а також <span>редагувати пароль і дані облікового запису</span>.</p>
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
                                            <th>Order</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Aug 22, 2018</td>
                                            <td>Pending</td>
                                            <td>$3000</td>
                                            <td><a href="shopping-cart.html">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>July 22, 2018</td>
                                            <td>Approved</td>
                                            <td>$200</td>
                                            <td><a href="shopping-cart.html">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>June 12, 2017</td>
                                            <td>On Hold</td>
                                            <td>$990</td>
                                            <td><a href="shopping-cart.html">View</a></td>
                                        </tr>
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
                                            <p><strong>Alex Tuntuni</strong></p>
                                            <p>1355 Market St, Suite 900 <br>
                                                San Francisco, CA 94103</p>
                                            <p>Mobile: (123) 456-7890</p>
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
                                            {{--                                            <div class="col-12 learts-mb-30">--}}
                                            {{--                                                <label for="display-name">Display Name <abbr class="required">*</abbr></label>--}}
                                            {{--                                                <input type="text" id="display-name" value="didiv91396">--}}
                                            {{--                                                <p>This will be how your name will be displayed in the account section and in reviews</p>--}}
                                            {{--                                            </div>--}}
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Отримати ідентифікатор вкладки з URL
            var hash = window.location.hash;

            // Перевірити, чи існує вкладка з таким ідентифікатором
            if ($(hash).length) {
                // Активувати вкладку та здійснити плавний перехід
                $('.myaccount-tab-list a[href="' + hash + '"]').tab('show');
            }
        });
    </script>
@endsection



