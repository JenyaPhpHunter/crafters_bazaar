@extends('layouts.app')

@section('content')

    <div class="offcanvas-overlay"></div>

    <!-- Page Title/Header Start -->
    <div class="page-title-section section" data-bg-image="{{ asset('images/bg/page-title-1.webp') }}">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-title">
                        <h1 class="title">ФОРУМ</h1>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('forum_categories.index') }}">Категорії</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('forum_sub_categories.index') }}">Підкатегорії</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('forum_topics.index') }}">Теми</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Title/Header End -->

    <div class="section section-padding pt-0">
        <div class="section section-fluid learts-mt-70">
            <div style="text-align: right;">
                <a class="btn btn-primary2 mr-3" href="{{ route('forum_posts.create', ['topic_id' => $topic->id]) }}">Створити пост</a>
            </div>
            <div class="container">
                <div class="row learts-mb-n50">
                    <div class="col-lg-9 col-12 learts-mb-50">
                        <h1>
                            <a href="{{ route('forum_categories.show', ['forum_category' => $topic->forum_sub_category->forum_category_id]) }}">
                                {{ $topic->forum_sub_category->forum_category->name }}
                            </a> /
                            <a href="{{ route('forum_sub_categories.show', ['forum_sub_category' => $topic->forum_sub_category_id]) }}">
                                {{ $topic->forum_sub_category->name }}
                            </a> /
                            {{ $topic->name }}
                        </h1>
                            <br><hr>
                        @isset($topic->forum_posts)
                            @foreach($topic->forum_posts as $post)
                                @if($post->answer_to)
                                    Відповідь на пост користувача {{ $post->answerTo->user->name }}<br>
                                    {{ $post->answerTo->content }}
                                @endif
                                <h3>
                                    {{ $post->name }}
                                    @if($user->role_id < 4)
                                        <a href="{{ route('forum_posts.edit', ['forum_post' => $post->id]) }}">
                                            <i class="fas fa-pencil-alt"></i> <!-- Карандаш -->
                                        </a>
                                    @endif
                                    <br>
                                    {{ $post->content }}
                                    <form action="{{ route('forum_posts.create') }}" method="GET">
                                        @csrf
                                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                                        <input type="hidden" name="topic_id" value="{{ $post->forum_topic_id }}">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-pencil-alt"></i> Відповісти
                                        </button>
                                    </form>
                                </h3>
                                <hr>
                            @endforeach
                        @endisset
                    </div>
                </div>
            </div>
        </div>
@endsection
