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
                        <a class="btn btn-primary2 mr-3" href="{{ route('forum_topics.create', ['sub_category_id' => $sub_category->id]) }}">Створити тему</a>
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
                        <h1>
                            <a href="{{ route('forum_categories.show', ['forum_category' => $sub_category->forum_category_id]) }}">
                                {{ $sub_category->forum_category->name }}
                            </a>
                            / {{ $sub_category->name }}
                        </h1>
                        <hr>
                        <h2>
                       @foreach($sub_category->forum_topics as $topic)
                                <a href="{{ route('forum_topics.show', ['forum_topic' => $topic->id]) }}">
                                    {{ $topic->name }}
                                </a>
                                @if($user->role_id < 4)
                                    <a href="{{ route('forum_topics.edit', ['forum_topic' => $topic->id]) }}">
                                        <i class="fas fa-pencil-alt"></i> <!-- Карандаш -->
                                    </a>
                                @endif
                           <br>
                       @endforeach
                        </h2>
                    </div>
                </div>
            </div>
        </div>
@endsection
