<!DOCTYPE html>
<html>
<head>
    <title>Створено новий товар з № {{  $product->id }}</title>
</head>
<body>
<h1>Товар № {{  $product->id }}</h1>

<h2>Замовник {{ $product->user->name }}, номер телефону {{ $product->user->phone }}</h2>

<p>Клієнт стоврив новий товар і хоче додати його в категорію {{ $product->kind_product->title }} та підкатегорію {{ $product->sub_kind_product->title }}</p>
<br>
<p>Зв'яжіться з {{ $product->user->name }} за телефоном {{ $product->user->phone }} і уточніть:
    <br>
Вартість {{ $product->price }}
    <br>
Кількість {{ $product->stock_balance }}
    <br>
Колір {{ $product->color->name }}
    <br>
</p>

Перейдіть за посиланням на його товар, відкорегуйте або підтвердіть правильність даних та відправьте його на продаж.
<div class="col-auto learts-mb-20"><a href="{{ route('admin_products.edit', ['admin_product' => $product->id]) }}" class="btn btn-info">Посилання на товар</a></div>

</body>
</html>
