<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Запрошення скасовано</title>
</head>
<body>
<h1>Запрошення скасовано</h1>

<p>Ваше запрошення до бренду <strong>"{{ $brand->title }}"</strong> було скасовано автором бренду.</p>

<p>Ви більше не зможете приєднатися за цим запрошенням.</p>

<p>
    <a href="{{ route('brands.index') }}"
       style="display:inline-block;padding:10px 20px;background:#3490dc;color:#fff;text-decoration:none;border-radius:5px;">
        Переглянути бренди
    </a>
</p>

<p>З повагою,<br>{{ config('app.name') }}</p>
</body>
</html>
