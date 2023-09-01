<!DOCTYPE html>
<html>
<head>
    <title>Підтвердження замовлення</title>
</head>
<body>
<h1>Ваше замовлення прийняте</h1>

<p>Шановний {{ $data['name'] }},</p>

<p>Ваше замовлення було підтверджено. Нижче деталі Вашого замовлення:</p>
@foreach($data['basket'] as $item)
<ul>
    <li>Кількість: {{ $item['quantity'] }}</li>
    <li>Назва товару: {{ $item['product'] }}</li>
    <li>Вартість: {{ $item['total'] }}</li>
</ul>
    <hr>
@endforeach
<h1>Загальна сума замовлення становить {{ $data['sum_order'] }} гривень</h1>
<p>Дякуємо за Ваше замовлення!</p>
</body>
</html>
