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
