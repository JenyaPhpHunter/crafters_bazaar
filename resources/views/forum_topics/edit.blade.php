@extends('layouts.app')

@section('content')

    <!-- Page Title/Header Start -->
    <div class="page-title">
        <h1 class="title">Редагування теми</h1>
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
                <li class="breadcrumb-item active">{{ $topic->name }}</li>
            @endisset
        </ul>
    </div>
    <!-- Page Title/Header End -->

    <div class="section section-padding border-bottom">
        <div class="row learts-mb-n40">
            <div class="container">
                <form method="post" action="{{ route('forum_topics.update', ['forum_topic' => $topic->id]) }}">
                    @csrf
                    @method('put')
                    <label for="forum_category_id">Категорія</label>
                    <input type="text" name="forum_category_id" id="forum_category_id"
                           value="{{ $topic->forum_sub_category->forum_category->name }}" readonly>
                    <br><br>
                    <label for="forum_sub_category_id">Підкатегорія</label>
                    <select id="forum_sub_category_id" name="forum_sub_category_id">
                        @foreach($sub_categories as $id => $name)
                            <option value="{{ $id }}" {{ $topic->forum_sub_category->id == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    <br><br>
                    <label for="name">Назва теми</label>
                    <input id="name" name="name" type="text" value="{{$topic->name}}">
                    <br><br>

                    <button class="btn btn-dark btn-outline-hover-dark mb-3" type="submit">Зберегти</button>
                </form>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var categorySelect = document.getElementById('forum_category_id');
                    var subcategorySelect = document.getElementById('forum_sub_category_id');
                    var subcategories = {!! $sub_categories->toJson() !!}; // Перетворюємо колекцію підкатегорій в масив JavaScript

                    categorySelect.addEventListener('change', function() {
                        var categoryId = this.value;
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
                    });
                });
            </script>
@endsection
