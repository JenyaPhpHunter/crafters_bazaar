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
                    <div class="breadcrumb-container" style="margin-top: 20px;">
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
                        <a class="btn btn-primary2" href="{{ route('forum_topics.create') }}" style="margin-bottom: 10px;">Створити тему</a>
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
                        @isset($sub_category)
                            <h1>
                            <a href="{{ route('forum_categories.index') }}">
                                Всі категорії /
                            </a>
                            <a href="{{ route('forum_categories.show', ['forum_category' => $sub_category->forum_category->id]) }}">
                                {{ $sub_category->forum_category->name }}
                            </a>
                            </h1>
                                <br><hr>
                            <h3>
                                <a href="{{ route('forum_topics.index', ['sub_category_id' => $sub_category->id]) }}">
                                    <span>{{ $sub_category->name }}</span>
                                </a>
                                @if($user->role_id < 4)
                                    <a href="{{ route('forum_sub_categories.edit', ['forum_sub_category' => $sub_category->id]) }}">
                                        &nbsp;&nbsp;<i class="fas fa-pencil-alt ml-2"></i> <!-- Карандаш -->
                                    </a>
                                @endif
                            </h3>
                        @endisset
                        @foreach($categories as $category)
                                <div class="category-container">
                                    <h1>
                                    <a href="{{ route('forum_categories.show', ['forum_category' => $category->id]) }}">
                                        <span>{{ $category->name }}</span>
                                    </a>
                                    @if($user->role_id < 4)
                                        <a href="{{ route('forum_categories.edit', ['forum_category' => $category->id]) }}">
                                            <i class="fas fa-pencil-alt"></i> <!-- Карандаш -->
                                        </a>
                                    @endif
                                    </h1>
                                </div>
                            @isset($category->forum_sub_categories)
                                @foreach($category->forum_sub_categories as $sub_category)
                                    <div class="sub_category-container">
                                        <h2>
                                        <a href="{{ route('forum_sub_categories.show', ['forum_sub_category' => $sub_category->id]) }}">
                                            <span>{{ $sub_category->name }}</span>
                                        </a>
                                        @if($user->role_id < 4)
                                            <a href="{{ route('forum_sub_categories.edit', ['forum_sub_category' => $sub_category->id]) }}">
                                                <i class="fas fa-pencil-alt"></i> <!-- Карандаш -->
                                            </a>
                                        @endif
                                        </h2>
                                    </div>
                                    @isset($sub_category->forum_topics)
                                        @foreach($sub_category->forum_topics as $topic)
                                            <div class="topic-container">
                                                <h3>
                                                <a href="{{ route('forum_topics.show', ['forum_topic' => $topic->id]) }}">
                                                    <span>{{ $topic->name }}</span>
                                                </a>
                                                @if($user->role_id < 4)
                                                    <a href="{{ route('forum_topics.edit', ['forum_topic' => $topic->id]) }}">
                                                        <i class="fas fa-pencil-alt"></i> <!-- Карандаш -->
                                                    </a>
                                                @endif
                                                </h3>
                                            </div>
                                        @endforeach
                                    @endisset
                                @endforeach
                            @endisset
                                <br><br><hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
@endsection
