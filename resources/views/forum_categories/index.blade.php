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
