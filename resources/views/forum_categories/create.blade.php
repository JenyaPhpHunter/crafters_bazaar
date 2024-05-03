@extends('layouts.app')

@section('content')

    <!-- Page Title/Header Start -->
    <div class="page-title">
        <h1 class="title">Створення категорії форуму</h1>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('forum_categories.index') }}">Категорії</a></li>
        </ul>
    </div>
    <!-- Page Title/Header End -->

    <div class="section section-padding border-bottom">
        <div class="container">
            <div class="row learts-mb-n40">
                <div class="col-lg-6 col-12 learts-mb-40">
                        <form method="post" action="{{ route('forum_categories.store') }}">
                            @csrf
                            <label for="name">Назва категорії</label>
                            <input id="name" name="name" type="text" class="category-title"
                                   placeholder="Введіть назву категорії">
                            <br><br>
                            <button class="btn btn-dark btn-outline-hover-dark mb-3" type="submit">Зберегти</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
@endsection

