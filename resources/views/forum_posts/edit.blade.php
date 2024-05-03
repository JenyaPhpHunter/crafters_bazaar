@extends('layouts.app')

@section('content')

    <!-- Page Title/Header Start -->
    <div class="page-title">
        <h1 class="title">Редагування поста</h1>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('forum_categories.index') }}">Категорії</a></li>
            @isset($post)
                <li class="breadcrumb-item">
                    <a href="{{ route('forum_categories.show', ['forum_category' => $post->forum_topic->forum_sub_category->forum_category_id]) }}">
                        {{ $post->forum_topic->forum_sub_category->forum_category->name }}
                    </a>
                </li>
            @endisset
            <li class="breadcrumb-item"><a href="{{ route('forum_sub_categories.index') }}">Підкатегорії</a></li>
            @isset($post)
                <li class="breadcrumb-item">
                    <a href="{{ route('forum_sub_categories.show', ['forum_sub_category' => $post->forum_topic->forum_sub_category_id]) }}">
                        {{ $post->forum_topic->forum_sub_category->name }}
                    </a>
                </li>
            @endisset
            <li class="breadcrumb-item"><a href="{{ route('forum_topics.index') }}">Теми</a></li>
            @isset($post)
                <li class="breadcrumb-item">
                    <a href="{{ route('forum_topics.show', ['forum_topic' => $post->forum_topic->forum_sub_category->forum_category_id]) }}">
                        {{ $post->forum_topic->name }}
                    </a>
                </li>
                <li class="breadcrumb-item active">{{ $post->name }}</li>
            @endisset
        </ul>
    </div>
    <!-- Page Title/Header End -->

    <div class="section section-padding border-bottom">
        <div class="container">
            <div class="row learts-mb-n40">
                <div class="col-lg-6 col-12 learts-mb-40">
                    <form method="post" action="{{ route('forum_posts.update', ['forum_post' => $post->id]) }}">
                        @csrf
                        @method('put')
                        <label for="forum_category_id">Категорія</label>
                        <input type="text" id="forum_category_id" name="forum_category_id"
                               value="{{ $post->forum_topic->forum_sub_category->forum_category->name }}" readonly>
                        <br><br>
                        <label for="forum_sub_category_id">Підкатегорія</label>
                        <input type="text" id="forum_sub_category_id" name="forum_sub_category_id"
                               value="{{ $post->forum_topic->forum_sub_category->name }}" readonly>
                        <br><br>
                        <label for="forum_topic_id">Тема</label>
                        <select id="forum_topic_id" name="forum_topic_id">
                            @foreach($topics as $topic_item)
                                <option value="{{ $topic_item->id }}" {{ $post->forum_topic->id == $topic_item->id ? 'selected' : '' }}>
                                    {{ $topic_item->name }}
                                </option>
                            @endforeach
                        </select>
                        <br><br>
                        <label for="content">Повідомлення</label>
                        <input id="content" name="content" type="text" class="post-title"
                               value="{{ $post->content }}">
                        <br><br>

                        <button class="btn btn-dark btn-outline-hover-dark mb-3" type="submit">Зберегти</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
