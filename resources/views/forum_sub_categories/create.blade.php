@extends('layouts.app')

@section('content')

    <!-- Page Title/Header Start -->
    <div class="page-title">
        <h1 class="title">Створення підкатегорії форуму</h1>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('forum_categories.index') }}">Категорії</a></li>
            <li class="breadcrumb-item"><a href="{{ route('forum_sub_categories.index') }}">Підкатегорії</a></li>
            @isset($selected_category)
                <li class="breadcrumb-item active">{{ $selected_category->name }}</li>
            @endisset
            <li class="breadcrumb-item"><a href="{{ route('forum_topics.index') }}">Теми</a></li>
        </ul>
    </div>
    <!-- Page Title/Header End -->

    <div class="section section-padding border-bottom">
        <div class="container">
            <div class="row learts-mb-n40">
                <div class="col-lg-6 col-12 learts-mb-40">
                        <form method="post" action="{{ route('forum_sub_categories.store') }}">
                            @csrf
                            <label for="forum_category_id">Категорія</label>
                            <select id="forum_category_id" name="forum_category_id">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{$selected_category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <br><br>
                            <label for="name">Назва підкатегорії</label>
                            <input id="name" name="name" type="text" class="sub_category-title"
                                   placeholder="Введіть назву підкатегорії">
                            <br><br>

                            <button type="submit" name="action" value="save"
                                    class="btn btn-dark btn-outline-hover-dark">
                                <i class="fas fa-save"></i> {{ $action_types['save'] }}
                            </button>
                        </form>
                </div>
            </div>
        </div>
    </div>
@endsection

