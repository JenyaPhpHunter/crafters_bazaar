<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Новий учасник бренду</title>
</head>
<body>
<h1>Привіт, {{ $brand->creator->name ?? 'Користувачу' }}!</h1>

<p>До вашого бренду <strong>{{ $brand->title }}</strong> щойно приєднався користувач <strong>{{ $user->name }}</strong> ({{ $user->email }}).</p>

<p>
    <a href="{{ route('brands.show', $brand) }}"
       style="display:inline-block;padding:10px 20px;background:#3490dc;color:#fff;text-decoration:none;border-radius:5px;">
        Переглянути бренд
    </a>
</p>

<p>З повагою,<br>{{ config('app.name') }}</p>
</body>
</html>
