@extends('layouts.app')

@section('content')

    <!-- Page Title/Header Start -->
    <div class="page-title">
        <h1 class="title">Створення теми форуму</h1>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('forum_categories.index') }}">Категорії</a></li>
            @isset($selected_category)
                <li class="breadcrumb-item">
                    <a href="{{ route('forum_categories.show', ['forum_category' => $selected_category->id]) }}">{{ $selected_category->name }}</a>
                </li>
            @endisset
            <li class="breadcrumb-item"><a href="{{ route('forum_sub_categories.index') }}">Підкатегорії</a></li>
            @isset($selected_sub_category)
                <li class="breadcrumb-item">
                    <a href="{{ route('forum_sub_categories.show', ['forum_sub_category' => $selected_sub_category->id]) }}">{{ $selected_sub_category->name }}</a>
                </li>
            @endisset
            <li class="breadcrumb-item"><a href="{{ route('forum_topics.index') }}">Теми</a></li>
        </ul>
    </div>
    <!-- Page Title/Header End -->

    <div class="section section-padding border-bottom">
        <div class="container">
            <div class="row learts-mb-n40">
                <div class="col-lg-6 col-12 learts-mb-40">
                    <form method="post" action="{{ route('forum_topics.store') }}">
                        @csrf
                        <label for="forum_category_id">Категорія</label>
                        <select id="forum_category_id" name="forum_category_id">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                @isset($selected_category){{ $selected_category->id == $category->id ? 'selected' : '' }}@endisset>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <br><br>
                        <label for="forum_sub_category_id">Підкатегорія</label>
                        <select id="forum_sub_category_id" name="forum_sub_category_id">
                            @foreach($sub_categories as $sub_category)
                                <option value="{{ $sub_category->id }}"
                                @isset($selected_category->id){{ $selected_sub_category->id == $sub_category->id ? 'selected' : '' }}@endisset>
                                    {{ $sub_category->name }}
                                </option>
                            @endforeach
                        </select>
                        <br><br>
                        <label for="name">Назва теми</label>
                        <input id="name" name="name" type="text" class="topic-title"
                               placeholder="Введіть назву теми">
                        <br><br>

                        <button class="btn btn-dark btn-outline-hover-dark mb-3" type="submit">Зберегти</button>
                    </form>
                </div>
            </div>
        </div>
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

