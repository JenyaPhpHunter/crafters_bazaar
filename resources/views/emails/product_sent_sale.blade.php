<!DOCTYPE html>
<html>
<head>
    <title>Ваш товар № {{  $product->id }} відправлено на продаж</title>
</head>
<body>
@if($re_updating)
    <h1>Товар № {{  $product->id }}  було відредаговано </h1>

    <h2>Дані товара @if($difference_editing)редагував @endif менеджер {{ $product->admin->name }}, номер телефону {{ $product->admin->phone }}</h2>
@else
    <h1>Товар № {{  $product->id }}  відправлено на продаж </h1>

    <h2>Дані товара перевірив @if($difference_editing)і  підкорегував @endif менеджер {{ $product->admin->name }}, номер телефону {{ $product->admin->phone }}</h2>
@endif

<br>
<p>Перевірте, будь ласка,  дані вашого товару:
    @if($difference_editing)
        @foreach($difference_editing as $key=>$difference)
            Було змінено: {{ $key }} на значення {{ $difference }} <br>
        @endforeach
    @endif
    Вид товару: {{ $product->kind_product->name }}
    <br>
    Підид товару: {{ $product->sub_kind_product->name }}
    <br>
    Вартість: {{ $product->price }}
    <br>
    Опис: {{ $product->content }}
    <br>
    Кількість: {{ $product->quantity }}
    <br>
    Розмір: {{ $product->size->name }}
    <br>
    Колір: {{ $product->color->name }}
    <br>
</p>

Перейти за посиланням на сторінку Вашого товаруви можете тут
<div class="col-auto learts-mb-20"><a href="{{ route('admin_products.edit', ['admin_product' => $product->id]) }}" class="btn btn-info">Посилання на товар</a></div>

</body>
</html>
