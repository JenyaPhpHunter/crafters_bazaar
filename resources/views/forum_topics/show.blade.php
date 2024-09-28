@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="section section-padding pt-0">
        <div class="section section-fluid learts-mt-70">
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
