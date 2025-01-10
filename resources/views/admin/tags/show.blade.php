@extends('admin.layouts.app')

@section('content')
    <div class="section section-padding pt-0">
        <div class="section section-fluid learts-mt-70">
            <div class="container">
                <div class="row learts-mb-n50">
                    <div class="col-lg-9 col-12 learts-mb-50">
                        <div class="category-container" id="category-{{ $tag->id }}">
                            <div style="display: flex; align-items: center;"> <!-- Контейнер для категорії та карандаша -->
                                <span>{{ $tag->title }}</span>
                                @isset($user)
                                    @can('edit', $tag)
                                        <a href="{{ route('admin_tags.edit', ['admin_tag' => $tag->id]) }}">
                                            &nbsp;&nbsp;<i class="fas fa-pencil-alt ml-2"></i> <!-- Карандаш -->
                                        </a>
                                    @endcan
                                @endisset
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

