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

        @isset($statuses_orders)
        @foreach($statuses_orders as $status)
            <a href="{{ route('admin_orders.index',  ['status_orders' => $status->id]) }}"> Показати замовлення зі статусом {{ $status->name }}</a>
            <br><br>
        @endforeach
        @endisset
{{--    <div class="container">--}}
        <h1>Замовлення @if(isset($status_orders)) зі статусом "{{ $status_orders->name }}": @endif</h1>
        {{--        <!-- Пошукове вікно -->--}}
        {{--        <form action="{{ route('search') }}" method="GET">--}}
        {{--            <input type="text" name="query" placeholder="Пошук товару за назвою">--}}
        {{--            <button type="submit">Знайти</button>--}}
        {{--        </form>--}}

                <div class="order">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Замовлення №</th>
                            <th>Email</th>
                            <th>Телефон</th>
                            <th>Спосіб доставки</th>
                            <th>Спосіб оплати</th>
                            <th>Місто</th>
                            <th>Адреса</th>
                            <th>Адреса нової пошти</th>
                            <th>Промокод</th>
                            <th>Вартість доставки</th>
                            <th>Загальна знижка</th>
                            <th>Загальна вартість замовлення</th>
                            <th>Коментар</th>
                            <th>Створено замовлення</th>
                            <th>Оновлено замовлення</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td><a href="{{ route('admin_orders.show', ['admin_order' => $order->id]) }}">{{ $order->id }}</a></td>
                                <td><a href="{{ route('admin_orders.show', ['admin_order' => $order->id]) }}">{{ $order->user->email }}</a></td>
                                <td><a href="{{ route('admin_orders.show', ['admin_order' => $order->id]) }}">{{ $order->user->phone }}</a></td>
                                <td><a href="{{ route('admin_orders.show', ['admin_order' => $order->id]) }}">{{ $order->delivery->name }}</a></td>
                                <td><a href="{{ route('admin_orders.show', ['admin_order' => $order->id]) }}">{{ $order->kind_payment->name }}</a></td>
                                <td><a href="{{ route('admin_orders.show', ['admin_order' => $order->id]) }}">{{ $order->city->name }}</a></td>
                                <td><a href="{{ route('admin_orders.show', ['admin_order' => $order->id]) }}">{{ $order->address }}</a></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{ $order->comment }}</td>
                                <td>{{ $order->created_at }}</td>
                                <td>{{ $order->updated_at }}</td>
                            </tr>
                        @empty
                            <h2>Відсутні</h2>
                        @endforelse
                        </tbody>
                    </table>
                </div>
{{--    </div>--}}
@endsection

