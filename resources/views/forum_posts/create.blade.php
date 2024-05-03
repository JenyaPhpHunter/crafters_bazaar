@extends('layouts.app')

@section('content')

    <!-- Page Title/Header Start -->
    <div class="page-title">
        <h1 class="title">Створення поста</h1>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('forum_categories.index') }}">Категорії</a></li>
            @isset($topic)
                <li class="breadcrumb-item">
                    <a href="{{ route('forum_categories.show', ['forum_category' => $topic->forum_sub_category->forum_category_id]) }}">
                        {{ $topic->forum_sub_category->forum_category->name }}
                    </a>
                </li>
            @endisset
            <li class="breadcrumb-item"><a href="{{ route('forum_sub_categories.index') }}">Підкатегорії</a></li>
            @isset($topic)
                <li class="breadcrumb-item">
                    <a href="{{ route('forum_sub_categories.show', ['forum_sub_category' => $topic->forum_sub_category_id]) }}">
                        {{ $topic->forum_sub_category->name }}
                    </a>
                </li>
            @endisset
            <li class="breadcrumb-item"><a href="{{ route('forum_topics.index') }}">Теми</a></li>
            @isset($topic)
                <li class="breadcrumb-item">
                    <a href="{{ route('forum_topics.show', ['forum_topic' => $topic->forum_sub_category->forum_category_id]) }}">
                        {{ $topic->name }}
                    </a>
                </li>
            @endisset
        </ul>
    </div>
    <!-- Page Title/Header End -->
    @if($answer_post)
        <h1>Ви пишете відповідь користувачу {{ $answer_post->user->name }}</h1>
        <h2>на його пост </h2>
        <h3>{{ $answer_post->content }}</h3>
    @endif
    <div class="section section-padding border-bottom">
        <div class="container">
            <div class="row learts-mb-n40">
                <div class="col-lg-6 col-12 learts-mb-40">
                    <form method="post" action="{{ route('forum_posts.store') }}">
                        @if($answer_post)
                        <input type="hidden" name="answer_post_id" value="{{ $answer_post->id }}">
                        @endif
                        @csrf
                        <label for="forum_category_id">Категорія</label>
                        <input type="text" id="forum_category_id" name="forum_category_id"
                               value="{{ $topic->forum_sub_category->forum_category->name }}" readonly>
                        <br><br>
                        <label for="forum_sub_category_id">Підкатегорія</label>
                        <input type="text" id="forum_sub_category_id" name="forum_sub_category_id"
                               value="{{ $topic->forum_sub_category->name }}" readonly>
                        <br><br>
                        <label for="forum_topic_id">Тема</label>
                        @if($answer_post)
                            <input type="text" id="forum_topic_id" name="forum_topic_id"
                                   value="{{ $answer_post->forum_topic->name }}" readonly>
                        @else
                            <select id="forum_topic_id" name="forum_topic_id">
                                @foreach($topics as $topic_item)
                                    <option value="{{ $topic_item->id }}" {{ $topic->id == $topic_item->id ? 'selected' : '' }}>
                                        {{ $topic_item->name }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                        <br><br>
                        <label for="content">Повідомлення</label>
                        <input id="content" name="content" type="text" class="post-title"
                               placeholder="{{ $answer_post ? 'Введіть текст відповіді' : 'Введіть текст' }}">
                        <br><br>

                        <button class="btn btn-dark btn-outline-hover-dark mb-3" type="submit">{{ $answer_post ? 'Відповісти' : 'Опублікувати' }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var categorySelect = document.getElementById('forum_category_id');
            var subcategorySelect = document.getElementById('forum_sub_category_id');
            var topicSelect = document.getElementById('forum_topic_id');
            var categories = {!! $categories->toJson() !!}; // Перетворюємо колекцію категорій в масив JavaScript
            var subcategories = {!! $sub_categories->toJson() !!}; // Перетворюємо колекцію підкатегорій в масив JavaScript
            var topics = {!! $topics->toJson() !!}; // Перетворюємо колекцію тем в масив JavaScript

            // Функція для фільтрації підкатегорій за обраною категорією
            function filterSubcategories() {
                var categoryId = categorySelect.value;
                subcategorySelect.innerHTML = ''; // Очистимо список підкатегорій

                // Фільтруємо підкатегорії за обраною категорією
                var filteredSubcategories = subcategories.filter(function(subcategory) {
                    return subcategory.forum_category_id == categoryId;
                });

                // Додаємо підкатегорії до випадаючого списку
                filteredSubcategories.forEach(function(subcategory) {
                    var option = document.createElement('option');
                    option.value = subcategory.id;
                    option.textContent = subcategory.name;
                    subcategorySelect.appendChild(option);
                });
            }

            categorySelect.addEventListener('change', function() {
                filterSubcategories(); // Фільтруємо підкатегорії після зміни категорії
                filterTopics(); // Фільтруємо теми після зміни категорії
            });

            subcategorySelect.addEventListener('change', function() {
                filterTopics(); // Фільтруємо теми після зміни підкатегорії
            });

            // Функція для фільтрації тем за обраними категорією і підкатегорією
            function filterTopics() {
                var categoryId = categorySelect.value;
                var subcategoryId = subcategorySelect.value;
                topicSelect.innerHTML = ''; // Очистимо список тем

                // Фільтруємо теми за обраними категорією і підкатегорією
                var filteredTopics = topics.filter(function(topic) {
                    return topic.forum_category_id == categoryId && topic.forum_sub_category_id == subcategoryId;
                });

                // Додаємо теми до випадаючого списку
                filteredTopics.forEach(function(topic) {
                    var option = document.createElement('option');
                    option.value = topic.id;
                    option.textContent = topic.name;
                    topicSelect.appendChild(option);
                });
            }

            // При завантаженні сторінки застосовуємо фільтри за обраними категорією і підкатегорією
            // filterSubcategories();
            // filterTopics();
        });
    </script>
@endsection

