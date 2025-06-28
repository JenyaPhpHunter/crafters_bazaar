@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>{{ $brand->title }}</h1>
            </div>

            <div class="card-body">
                @if($brand->image_path)
                    <img src="{{ asset('storage/' . $brand->image_path) }}"
                         alt="{{ $brand->title }}"
                         class="img-fluid mb-4"
                         style="max-height: 300px; cursor: pointer;"
                         data-bs-toggle="modal"
                         data-bs-target="#imageModal"
                         onclick="showImageModal('{{ asset('storage/' . $brand->image_path) }}')">
                @endif
                @if($brand->rating && config('others.rating.' . $brand->rating))
                    <div class="mb-4">
                        <h4>Рейтинг:</h4>
                        <div>
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $brand->rating)
                                    <i class="fas fa-star text-warning"></i> {{-- Заповнена зірка --}}
                                @else
                                    <i class="far fa-star text-muted"></i> {{-- Порожня зірка --}}
                                @endif
                            @endfor
                        </div>
                    </div>
                @endif
                @if($brand->creator)
                    <p><strong>Створено користувачем:</strong> {{ $brand->creator->name }}</p>
                @endif


                    <div class="mb-4">
                    <h4>Опис:</h4>
                    <p>{{ $brand->content ?? 'Опис відсутній' }}</p>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('brands.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> До списку
                    </a>

                    @can('update', $brand)
                        <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit"></i> Редагувати
                        </a>
                    @endcan
                </div>
            </div>

            <div class="card-footer text-muted">
                Створено: {{ $brand->created_at->format('d.m.Y H:i') }} |
                Оновлено: {{ $brand->updated_at->format('d.m.Y H:i') }}
            </div>
        </div>
    </div>

    @include('brands.include.image_modal')

@endsection
