<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Користувач покинув бренд</title>
</head>
<body>
<h1>Користувач покинув бренд</h1>

<p>Користувач <strong>{{ $user->getFullName() }}</strong> ({{ $user->email }}) щойно покинув бренд <strong>"{{ $brand->title }}"</strong>.</p>

@if($brand->users->count())
    <p>Бренд зараз має {{ $brand->users->count() }} учасників.</p>
@else
    <p>Наразі в бренді немає учасників.</p>
@endif

<p>
    <a href="{{ route('brands.show', $brand) }}"
       style="display:inline-block;padding:10px 20px;background:#3490dc;color:#fff;text-decoration:none;border-radius:5px;">
        Переглянути бренд
    </a>
</p>

<p>Дякуємо,<br>{{ config('app.name') }}</p>
</body>
</html>
