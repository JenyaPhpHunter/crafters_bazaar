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
                        @foreach($categories as $category)
                            <div class="category-container" id="category-{{ $category->id }}">
                                <!-- Контейнер для категорії та карандаша -->
                                <a href="{{ route('forum_categories.show', ['forum_category' => $category->id]) }}">
                                    <span>{{ $category->name }}</span>
                                </a>
                                @isset($user)
                                    @can('edit', $category)
                                        <a href="{{ route('forum_categories.edit', ['forum_category' => $category->id]) }}">
                                            <i class="fas fa-pencil-alt"></i> <!-- Карандаш -->
                                        </a>
                                    @endcan
                                @endisset
                                <!-- Підкатегорії -->
                                <div class="subcategories" id="subcategories-{{ $category->id }}">
                                    @foreach($category->forum_sub_categories as $subcategory)
                                        <div class="subcategory-item">
                                            <a href="{{ route('forum_sub_categories.show', ['forum_sub_category' => $subcategory->id]) }}">
                                                <span>{{ $subcategory->name }}</span>
                                            </a>
                                            @isset($user)
                                            @if($user->role_id < 4)
                                                <a href="{{ route('forum_sub_categories.edit', ['forum_sub_category' => $subcategory->id]) }}">
                                                    <i class="fas fa-pencil-alt"></i> <!-- Карандаш -->
                                                </a>
                                            @endif
                                            @endisset
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
@endsection
