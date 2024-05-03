@extends('layouts.app')

@section('content')

    <!-- Page Title/Header Start -->
    <div class="page-title">
        <h1 class="title">Редагування підкатегорії</h1>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('forum_categories.index') }}">Категорії</a></li>
            <li class="breadcrumb-item"><a href="{{ route('forum_sub_categories.index') }}">Підкатегорії</a></li>
            @isset($sub_category)
                <li class="breadcrumb-item">
                    <a href="{{ route('forum_categories.show', ['forum_category' => $sub_category->forum_category_id]) }}">
                        {{ $sub_category->forum_category->name }}
                    </a>
                </li>
                <li class="breadcrumb-item active">{{ $sub_category->name }}</li>
            @endisset
        </ul>
    </div>
    <!-- Page Title/Header End -->

    <div class="section section-padding border-bottom">
        <div class="row learts-mb-n40">
            <div class="container">
                <form method="post" action="{{ route('forum_sub_categories.update', ['forum_sub_category' => $forum_sub_category->id]) }}">
                    @csrf
                    @method('put')
                    <label for="forum_category_id">Категорія</label>
                    <select id="forum_category_id" name="forum_category_id">
                        @foreach($categories as $id => $name)
                            <option value="{{ $id }}" {{ $sub_category->forum_category_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    <br><br>
                    <label for="name">Назва підкатегорії</label>
                    <input id="name" name="name" value="{{$sub_category->name}}">
                    <br><br>

                    <button class="btn btn-dark btn-outline-hover-dark mb-3" type="submit">Зберегти</button>
                </form>
            </div>
@endsection
