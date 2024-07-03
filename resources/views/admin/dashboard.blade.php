@extends('admin.layouts.app')

@section('content')

    <div class="p-6 text-gray-900">
        <table class="table">
            <thead>
            <tr>
                <th>Замовлення №</th>
                <th>Email користувача</th>
                <th>Телефон користувача</th>
                <th>Спосіб доставки</th>
                <th>Спосіб оплати</th>
                <th>Адреса доставки</th>
{{--                <th>Адреса нової пошти</th>--}}
{{--                <th>Вартість доставки</th>--}}
{{--                <th>Загальна знижка</th>--}}
                <th>Загальна вартість замовлення</th>
                <th>Коментар</th>
                <th>Статус замовлення</th>
                <th>Створено замовлення</th>
                <th>Оновлено замовлення</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->email }}</td>
                    <td>{{ $order->user->phone }}</td>
                    <td>{{ $order->delivery->name }}</td>
                    <td>{{ $order->kind_payment->name }}</td>
                    <td>{{ $order->city }}, {{ $order->address }}</td>
                    <td>{{ $order->sum_order }}</td>
                    <td>{{ $order->comment }}</td>
                    <td>{{ $order->status_order->name }}</td>
                    <td>{{ $order->created_at }}</td>
                    <td>{{ $order->updated_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>


@endsection

@section('page-script')
    <script src="{{ asset('js/plugins/scrollax.min.js') }}"></script>
    <script src="{{ asset('js/plugins/instafeed.min.js') }}"></script>
@endsection


