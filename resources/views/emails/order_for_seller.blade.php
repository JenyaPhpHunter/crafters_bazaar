<!DOCTYPE html>
<html>
<head>
    <title>Замовлення № {{  $data['order'] }}</title>
</head>
<body>
<h1>Замовлення № {{  $data['order'] }}</h1>

<h2>Замовник {{ $data['client'] }}, номер телефону {{ $data['phone_client'] }}</h2>

<p>Замовлення було підтверджено замовнику {{ $data['client'] }}
    з доставкою в місто {{ $data['city_client'] }}
    за адресою {{ $data['address_client'] }}
    @if($data['comment'])
    з коментарем: {{ $data['comment'] }}
    @endif
    Зателефонуйте йому за номером {{ $data['phone_client'] }} та узгодьте доставку товара.
    Нижче деталі його замовлення:</p>
@foreach($data['basket'] as $item)
    <ul>
        <li>Назва товару: {{ $item['product'] }}</li>
        <li>Кількість: {{ $item['quantity'] }}</li>
        <li>Вартість: {{ $item['total'] }}</li>
    </ul>
    <hr>
@endforeach
<h1>Загальна сума замовлення становить {{ $data['sum_order'] }} гривень</h1>
</body>
</html>
