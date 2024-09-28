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
