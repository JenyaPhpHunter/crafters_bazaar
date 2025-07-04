@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Управління брендами</h1>
            <a href="{{ route('brands.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Додати бренд
            </a>
        </div>

        <!-- Форма фільтрації -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('brands.index') }}">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control"
                                   placeholder="Пошук..." value="{{ $search }}">
                        </div>

                        <div class="col-md-3">
                            <select name="rating" class="form-select">
                                <option value="">Всі рейтинги</option>
                                @foreach($availableRatings as $key => $value)
                                    <option value="{{ $key }}" {{ $ratingFilter == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <select name="per_page" class="form-select">
                                @foreach([10, 25, 50, 100] as $value)
                                    <option value="{{ $value }}" {{ $perPage == $value ? 'selected' : '' }}>
                                        {{ $value }} на сторінку
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 d-flex">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-filter"></i> Фільтрувати
                            </button>
                            <a href="{{ route('brands.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-sync-alt"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Таблиця з брендами -->
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                        <tr>
                            <th>
                                @include('partials.sort-header', [
                                    'field' => 'title',
                                    'label' => 'Назва',
                                    'currentField' => $sortField,
                                    'currentDirection' => $sortDirection
                                ])
                            </th>
                            <th>Зображення</th>
                            <th>
                                @include('partials.sort-header', [
                                    'field' => 'rating',
                                    'label' => 'Рейтинг',
                                    'currentField' => $sortField,
                                    'currentDirection' => $sortDirection
                                ])
                            </th>
                            <th>
                                @include('partials.sort-header', [
                                    'field' => 'users_count',
                                    'label' => 'Кількість користувачів',
                                    'currentField' => $sortField,
                                    'currentDirection' => $sortDirection
                                ])
                            </th>
                            <th>
                                @include('partials.sort-header', [
                                    'field' => 'created_at',
                                    'label' => 'Створено',
                                    'currentField' => $sortField,
                                    'currentDirection' => $sortDirection
                                ])
                            </th>
                            <th>Дії</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($brands as $brand)
                            <tr>
                                <td>{{ $brand->title }}</td>
                                <td>
                                    @if($brand->image_path)
                                        <img src="{{ asset('storage/' . $brand->image_path) }}"
                                             alt="{{ $brand->title }}"
                                             class="img-thumbnail"
                                             style="max-height: 50px; cursor: pointer;"
                                             data-bs-toggle="modal"
                                             data-bs-target="#imageModal"
                                             onclick="showImageModal('{{ asset('storage/' . $brand->image_path) }}')">
                                    @else
                                        <span class="text-muted">Немає</span>
                                    @endif
                                </td>
                                <td>
                                    @if($brand->rating && isset($availableRatings[$brand->rating]))
                                        <div class="mb-4">
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
                                </td>
                                <td>{{ $brand->users_count }}</td>
                                @if($brand->creator)
                                    <td>{{ $brand->creator->name }}</td>
                                @endif

                                <td>{{ $brand->created_at->format('d.m.Y H:i') }}</td>
                                <td class="text-nowrap">
                                    @can('view', $brand)
                                        <a href="{{ route('brands.show', $brand) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           title="Переглянути">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @endcan
                                    @can('update', $brand)
                                        <a href="{{ route('brands.edit', $brand) }}"
                                           class="btn btn-sm btn-outline-secondary"
                                           title="Редагувати">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan
                                    @can('delete', $brand)
                                        <form action="{{ route('brands.destroy', $brand) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Ви впевнені, що хочете видалити цей бренд?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    title="Видалити">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">Бренди не знайдено</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($brands->hasPages())
                <div class="card-footer">
                    {{ $brands->links() }}
                </div>
            @endif
        </div>
    </div>
    @include('brands.include.image_modal')
@endsection

