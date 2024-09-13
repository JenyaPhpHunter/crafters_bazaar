@extends('layouts.app')

@section('content')
    <!-- Page Title/Header Start -->
    <div class="page-title-section section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-title" style="display: flex; align-items: center; justify-content: space-between;">
                        <h1 class="title" style="margin-bottom: 0;">ФОРУМ</h1>
                    </div>
                    <div class="breadcrumb-container" style="display: flex; align-items: center; justify-content: space-between; margin-top: 20px;">
                        <ul class="breadcrumb" style="margin-bottom: 0;">
                            <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('forum_categories.index') }}">Категорії</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('forum_sub_categories.index') }}">Підкатегорії</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('forum_topics.index') }}">Теми</a></li>
                        </ul>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: flex-end; margin-top: 20px;">
                        <a class="btn btn-primary2" href="{{ route('forum_categories.create') }}" style="margin-bottom: 10px;">Створити категорію</a>
                        <a class="btn btn-primary2" href="{{ route('forum_sub_categories.create') }}" style="margin-bottom: 10px;">Створити підкатегорію</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Title/Header End -->

    <div class="section section-padding pt-0">
        <div class="section section-fluid learts-mt-70">
            <div class="container">
                <div class="row learts-mb-n50">
                    <div class="col-lg-9 col-12 learts-mb-50">
                        @foreach($categories as $category)
                            <div style="display: flex; align-items: center;"> <!-- Контейнер для категорії та карандаша -->
                                <span>{{ $category->name }}</span> <!-- Категорія -->
                                @if($user && $user->role_id < 4)
                                    <a href="{{ route('forum_categories.edit', ['forum_category' => $category->id]) }}">
                                        &nbsp;&nbsp;<i class="fas fa-pencil-alt ml-2"></i> <!-- Карандаш -->
                                    </a>
                                @endif
                            </div>
                            @foreach($sub_categories as $sub_category)
                                @if($sub_category->forum_category_id == $category->id)
                                    <div style="margin-left: 20px; display: flex; align-items: center;"> <!-- Контейнер для підкатегорії та карандаша -->
                                        <a href="{{ route('forum_sub_categories.show', ['forum_sub_category' => $sub_category->id]) }}">
                                            <span>{{ $sub_category->name }}</span>
                                        </a>
                                        @if($user && $user->role_id < 4)
                                            <a href="{{ route('forum_sub_categories.edit', ['forum_sub_category' => $sub_category->id]) }}">
                                                &nbsp;&nbsp;<i class="fas fa-pencil-alt ml-2"></i> <!-- Карандаш -->
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
@endsection
