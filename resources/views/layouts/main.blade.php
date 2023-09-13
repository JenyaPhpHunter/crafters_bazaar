<html>
<head>
    <title>{{ config('app.name', 'Craft Bazaar') }}</title>
    <link rel="stylesheet" href="{{ asset('/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('/js/styles.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

</head>
<body>
{{-- @include('архив.partials.header',[
    'hello' => $hello
/]) --}}

{{--<div class="container">--}}
@yield('content')
@yield('script')
{{--</div>--}}

<!-- BEGIN: Page JS-->
@yield('page-script')
<!-- END: Page JS-->

</body>
</html>
