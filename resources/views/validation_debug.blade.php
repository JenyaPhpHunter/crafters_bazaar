<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validation Debug</title>
</head>
<body>
<h1>Validation Debug</h1>

@if ($errors->any())
    <h2>Validation Errors:</h2>
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

@if (session('message'))
    <h2>Flash Message:</h2>
    <p>{{ session('message') }}</p>
@endif

<h2>Form Data:</h2>
<pre>
        {{ print_r(request()->all(), true) }}
    </pre>
</body>
</html>
