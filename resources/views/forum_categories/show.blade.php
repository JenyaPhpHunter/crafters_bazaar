@extends('layouts.app')

@section('content')
    <div class="section section-padding pt-0">
        <div class="section section-fluid learts-mt-70">
            <div class="container">
                <div class="row learts-mb-n50">
                    <div class="col-lg-9 col-12 learts-mb-50">
                        <h1>
                            {{ $category->name }}
                        </h1>
                            <br><hr>
                        @foreach($category->forum_sub_categories as $sub_category)
                        <h3>
                            <a href="{{ route('forum_sub_categories.show', ['forum_sub_category' => $sub_category->id]) }}">
                                <span>{{ $sub_category->name }}</span>
                            </a>
                            @if($user->role_id < 4)
                                <a href="{{ route('forum_sub_categories.edit', ['forum_sub_category' => $sub_category->id]) }}">
                                    <i class="fas fa-pencil-alt"></i> <!-- Карандаш -->
                                </a>
                            @endif
                        </h3>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
@endsection
