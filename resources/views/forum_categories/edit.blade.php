@extends('layouts.app')

@section('content')

    <!-- Page Title/Header Start -->
    <div class="page-title">
        <h1 class="title">Редагування категорії</h1>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('forum_categories.index') }}">Категорії</a></li>
            @isset($category)
                <li class="breadcrumb-item active">{{ $category->name }}</li>
            @endisset
        </ul>
    </div>
    <!-- Page Title/Header End -->

    <div class="section section-padding border-bottom">
        <div class="row learts-mb-n40">
            <div class="container">
                <form method="post" action="{{ route('forum_categories.update', ['forum_category' => $category->id]) }}">
                    @csrf
                    @method('put')
                    <label for="name">Назва категорії</label>
                    <input id="name" name="name" value="{{$category->name}}">
                    <br><br>

                    <button class="btn btn-dark btn-outline-hover-dark mb-3" type="submit">Зберегти</button>
                </form>
            </div>
@endsection
