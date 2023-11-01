@extends('layouts.app')

@section('seo_title', 'Главная страница')

@section('content')

@endsection

@section('page-script')
    <script src="{{ asset('js/plugins/scrollax.min.js') }}"></script>
    <script src="{{ asset('js/plugins/instafeed.min.js') }}"></script>
@endsection
