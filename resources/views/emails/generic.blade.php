<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $titleEmail }}</title>
</head>
<body>
<h1><b>Відображення на всіх листах</b></h1>
{!! $content !!}
{{--<img src="{{ asset('photos/20240212_172557_11.jpg') }}" alt="Example Image" style="width: 300px; height: auto;">--}}
<img src="{{ url('https://static-cse.canva.com/blob/847064/29.0368567e.avif') }}" alt="Example Image" style="width: 300px; height: auto;">
</body>
</html>
