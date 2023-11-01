@extends('layouts.app')

@section('content')
    <!-- Page Title/Header Start -->
    <div class="page-title-section section" data-bg-image="assets/images/bg/page-title-1.webp">
        <div class="container">
            <div class="row">
                <div class="col">

                    <div class="page-title">
                        <h1 class="title">Корзина</h1>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active">Корзина</li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Page Title/Header End -->

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
                <h2 class="title">Дані замовника</h2>
            </div>
                <form class="checkout-form learts-mb-50" method="post" action="{{ route('orders.store') }}">
                    @csrf
                <div class="row">
                    <div class="col-md-6 col-12 learts-mb-20">
                        <label for="bdFirstName">Ім'я <abbr class="required">*</abbr></label>
                        <input type="text" id="bdFirstName">
                    </div>
                    <div class="col-md-6 col-12 learts-mb-20">
                        <label for="bdSecondName">По-батькові</label>
                        <input type="text" id="bdSecondName">
                    </div>
                    <div class="col-12 learts-mb-20">
                        <label for="bdLastName">Прізвище <abbr class="required">*</abbr></label>
                        <input type="text" id="bdLastName">
                    </div>
                    <div class="col-12 learts-mb-20">
                        <label for="bdCountry">Країна <abbr class="required">*</abbr></label>
                        <select id="bdCountry" class="select2-basic">
                            <option value="">Виберіть країну…</option>
                            @foreach($countries as $countryCode => $countryName)
                                <option value="{{ $countryCode }}" {{ $countryCode === 'UA' ? 'selected' : '' }}>{{ $countryName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 learts-mb-20">
                        <label for="bdTownOrCity">Населенний пункт(місто/село) <abbr class="required">*</abbr></label>
                        <input type="text" id="bdTownOrCity">
                    </div>
                    @if()
                        <div class="col-12 learts-mb-20">
                            <label for="bdDistrict">District <abbr class="required">*</abbr></label>
                            <select id="bdDistrict" class="select2-basic">
                                <option value="">Select an option…</option>
                                <option value="BD-05">Bagerhat</option>
                                <option value="BD-01">Bandarban</option>
                                <option value="BD-02">Barguna</option>
                            </select>
                        </div>
                    @endif
                    <div class="col-12 learts-mb-20">
                        <label for="bdAddress1">Вулиця <abbr class="required">*</abbr></label>
                        <input type="text" id="bdAddress1" placeholder="назва вулиці">
                    </div>
                    <div class="col-12 learts-mb-20">
                        <label for="bdHouseNumber">№ Будинку <abbr class="required">*</abbr></label>
                        <input type="text" id="bdHouseNumber" placeholder="номер будинку (optional) ">
                    </div>
                    <div class="col-12 learts-mb-20">
                        <label for="bdPostcode">Postcode / ZIP (optional)</label>
                        <input type="text" id="bdPostcode">
                    </div>
                    <div class="col-md-6 col-12 learts-mb-20">
                        <label for="bdEmail">Email address <abbr class="required">*</abbr></label>
                        <input type="text" id="bdEmail">
                    </div>
                    <div class="col-md-6 col-12 learts-mb-30">
                        <label for="bdPhone">Phone <abbr class="required">*</abbr></label>
                        <input type="text" id="bdPhone">
                    </div>
                    <div class="col-12 learts-mb-40">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Create an account?</label>
                        </div>
                    </div>
                    <div class="col-12 learts-mb-20">
                        <label for="bdOrderNote">Order Notes (optional)</label>
                        <textarea id="bdOrderNote" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                    </div>
                </div>
            </form>
            <div class="section-title2 text-center">
                <h2 class="title">Your order</h2>
            </div>
            <div class="row learts-mb-n30">
                <div class="col-lg-6 order-lg-2 learts-mb-30">
                    <div class="order-review">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="name">Product</th>
                                <th class="total">Subtotal</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="name">Walnut Cutting Board&nbsp; <strong class="quantity">×&nbsp;1</strong></td>
                                <td class="total"><span>£100.00</span></td>
                            </tr>
                            <tr>
                                <td class="name">Pizza Plate Tray&nbsp; <strong class="quantity">×&nbsp;1</strong></td>
                                <td class="total"><span>£22.00</span></td>
                            </tr>
                            <tr>
                                <td class="name">Minimalist Ceramic Pot - Pearl river, Large&nbsp; <strong class="quantity">×&nbsp;1</strong></td>
                                <td class="total"><span>£120.00</span></td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr class="subtotal">
                                <th>Subtotal</th>
                                <td><span>£242.00</span></td>
                            </tr>
                            <tr class="total">
                                <th>Total</th>
                                <td><strong><span>£242.00</span></strong></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col-lg-6 order-lg-1 learts-mb-30">
                    <div class="order-payment">
                        <div class="payment-method">
                            <div class="accordion" id="paymentMethod">
                                <div class="card active">
                                    <div class="card-header">
                                        <button data-bs-toggle="collapse" data-bs-target="#checkPayments">Check payments</button>
                                    </div>
                                    <div id="checkPayments" class="collapse show" data-bs-parent="#paymentMethod">
                                        <div class="card-body">
                                            <p>Please send a check to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <button data-bs-toggle="collapse" data-bs-target="#cashkPayments">Cash on delivery </button>
                                    </div>
                                    <div id="cashkPayments" class="collapse" data-bs-parent="#paymentMethod">
                                        <div class="card-body">
                                            <p>Pay with cash upon delivery.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <button data-bs-toggle="collapse" data-bs-target="#payPalPayments">PayPal <img src="assets/images/others/pay-2.webp" alt=""></button>
                                    </div>
                                    <div id="payPalPayments" class="collapse" data-bs-parent="#paymentMethod">
                                        <div class="card-body">
                                            <p>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal account.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <p class="payment-note">Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our privacy policy.</p>
                            <button class="btn btn-dark btn-outline-hover-dark">place order</button>
                        </div>
                    </div>
                </div>
            </div>
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
