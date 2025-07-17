<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Вас видалено з бренду</title>
</head>
<body>
<h1>Вас видалено з бренду</h1>

<p>Вас було видалено з бренду <strong>"{{ $brand->title }}"</strong> автором бренду.</p>

@if(auth()->check() && auth()->user()->id !== $brand->creator_id)
    <p>Цей бренд більше недоступний для вас.</p>
@endif

<p>
    <a href="{{ route('brands.index') }}"
       style="display:inline-block;padding:10px 20px;background:#3490dc;color:#fff;text-decoration:none;border-radius:5px;">
        Переглянути бренди
    </a>
</p>

<p>З повагою,<br>{{ config('app.name') }}</p>
</body>
</html>
