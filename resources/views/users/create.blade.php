@extends('layouts.main')

@section('content')

    <a href="{{route('welcome')}}">Повернутися на головну сторінку</a>
    <br><br>
    <h1>Додавання користувача</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
{{--    <form method="post" action="{{ route('users.store') }}">--}}
{{--        @csrf--}}
{{--        <label for="surname">Прізвище</label>--}}
{{--        <br>--}}
{{--        <input id="surname" name="surname" value="">--}}
{{--        <br><br>--}}

{{--        <label for="name">Ім'я</label>--}}
{{--        <br>--}}
{{--        <input id="name" name="name" value="">--}}
{{--        <br><br>--}}

{{--        <label for="secondname">По батькові</label>--}}
{{--        <br>--}}
{{--        <input id="secondname" name="secondname" value="">--}}
{{--        <br><br>--}}


{{--        <label for="email">Email</label>--}}
{{--        <br>--}}
{{--        <input id="email" name="email" value="">--}}
{{--        <br><br>--}}

{{--        <label for="password">Пароль</label>--}}
{{--        <br>--}}
{{--        <input id="password" name="password">--}}
{{--        <br><br>--}}

{{--        <label for="phone">Телефон</label>--}}
{{--        <br>--}}
{{--        <input id="phone" name="phone" type="tel" pattern="[0-9]+" value="" required>--}}
{{--        <br><br>--}}

{{--        <label for="delivery_id">Спосіб доставки</label>--}}
{{--        <br>--}}
{{--        <select id="delivery_id" name="delivery_id">--}}
{{--            @foreach($deliveries as $delivery)--}}
{{--                <option value="{{ $delivery->id }}">{{ $delivery->name }}</option>--}}
{{--            @endforeach--}}
{{--        </select>--}}
{{--        <br><br>--}}

{{--        <label for="city">Місто</label>--}}
{{--        <br>--}}
{{--        <input id="city" name="city" value="">--}}
{{--        <br><br>--}}

{{--        <label for="address">Адреса</label>--}}
{{--        <br>--}}
{{--        <input id="address" name="address" value="">--}}
{{--        <br><br>--}}

{{--        <label for="paymentkind_id">Спосіб оплати</label>--}}
{{--        <br>--}}
{{--        <select id="paymentkind_id" name="paymentkind_id">--}}
{{--            @foreach($payment_kinds as $payment_kind)--}}
{{--                <option value="{{ $payment_kind->id }}">{{ $payment_kind->name }}</option>--}}
{{--            @endforeach--}}
{{--        </select>--}}
{{--        <br><br>--}}

{{--        <label for="role_id">Роль користувача</label>--}}
{{--        <br>--}}
{{--        <select id="role_id" name="role_id">--}}
{{--            @foreach($roles as $role)--}}
{{--                <option value="{{ $role->id }}">{{ $role->name }}</option>--}}
{{--            @endforeach--}}
{{--        </select>--}}
{{--        <br><br>--}}

{{--        <input type="submit" value="Зберегти">--}}
{{--        <span style="display: inline-block; width: 100px;"></span>--}}

{{--    </form>--}}

@endsection
