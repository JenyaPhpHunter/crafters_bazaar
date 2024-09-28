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
