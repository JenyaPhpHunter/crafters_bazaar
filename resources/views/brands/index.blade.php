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
                    <div class="row g-2 align-items-end flex-wrap">
                        <div class="col-auto" style="max-width: 300px;">
                            <input type="text" name="search" class="form-control" placeholder="Пошук..." value="{{ $search }}">
                        </div>

                        <div class="col-auto" style="max-width: 180px;">
                            <select name="rating" class="form-select">
                                <option value="">Всі рейтинги</option>
{{--                                @foreach($availableRatings as $key => $value)--}}
{{--                                    <option value="{{ $key }}" {{ $ratingFilter == $key ? 'selected' : '' }}>--}}
{{--                                        {{ $value }}--}}
{{--                                    </option>--}}
{{--                                @endforeach--}}
                            </select>
                        </div>

                        <!-- per_page select -->
                        <div class="col-auto" style="max-width: 200px;">
                            <select name="per_page" class="form-select">
                                @foreach([10, 25, 50, 100] as $value)
                                    <option value="{{ $value }}" {{ $perPage == $value ? 'selected' : '' }}>
                                        {{ $value }} на сторінку
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- checkbox with wrapped label -->
                        <div class="col-auto d-flex align-items-center">
                            <div class="form-check mb-0 text-wrap" style="max-width: 110px;">
                                <input type="checkbox" class="form-check-input" id="with_trashed" name="with_trashed" {{ request('with_trashed') ? 'checked' : '' }}>
                                <label class="form-check-label" for="with_trashed">
                                    Показати<br>видалені
                                </label>
                            </div>
                        </div>

                        <div class="col-auto d-flex gap-2">
                            <button type="submit" class="btn btn-info">
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
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                    <tr>
                        <th style="width: 20%" class="align-middle text-center">
                            @include('partials.sort-header', [
                                'field' => 'title',
                                'label' => 'Назва',
                                'currentField' => $sortField,
                                'currentDirection' => $sortDirection
                            ])
                        </th>
                        <th style="width: 10%" class="align-middle text-center">Зображення</th>
                        <th style="width: 15%" class="align-middle text-center">
                            @include('partials.sort-header', [
                                'field' => 'rating',
                                'label' => 'Рейтинг',
                                'currentField' => $sortField,
                                'currentDirection' => $sortDirection
                            ])
                        </th>
                        <th style="width: 15%" class="align-middle text-center">
                            @include('partials.sort-header', [
                                'field' => 'users_count',
                                'label' => 'Користувачі',
                                'currentField' => $sortField,
                                'currentDirection' => $sortDirection
                            ])
                        </th>
                        <th style="width: 15%" class="align-middle text-center">
                            @include('partials.sort-header', [
                                'field' => 'creator',
                                'label' => 'Створено',
                                'currentField' => $sortField,
                                'currentDirection' => $sortDirection
                            ])
                        </th>
                        <th style="width: 15%" class="align-middle text-center">
                            @include('partials.sort-header', [
                                'field' => 'created_at',
                                'label' => 'Дата створення',
                                'currentField' => $sortField,
                                'currentDirection' => $sortDirection
                            ])
                        </th>
                        <th style="width: 10%" class="align-middle text-center">Дії</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($brands as $brand)
                        <tr>
                            <td class="align-middle text-center">{{ $brand->title }}</td>
                            <td class="align-middle text-center">
                                @if($brand->image_path)
                                    <img src="{{ asset('storage/' . $brand->image_path) }}" alt="{{ $brand->title }}" class="img-thumbnail" style="max-height: 50px; cursor: pointer;"
                                         data-bs-toggle="modal" data-bs-target="#imageModal"
                                         onclick="showImageModal('{{ asset('storage/' . $brand->image_path) }}')">
                                @else
                                    <span class="text-muted">Немає</span>
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                @if($brand->rating && isset($availableRatings[$brand->rating]))
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $brand->rating)
                                            <i class="fas fa-star text-warning"></i>
                                        @else
                                            <i class="far fa-star text-muted"></i>
                                        @endif
                                    @endfor
                                @endif
                            </td>
                            <td class="align-middle text-center">{{ $brand->users_count }}</td>
                            <td class="align-middle text-center">{{ $brand->creator->name ?? '—' }}</td>
                            <td class="align-middle text-center">{{ $brand->created_at->format('d.m.Y H:i') }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('brands.show', $brand) }}" class="btn btn-sm btn-outline-primary" title="Переглянути">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @can('update', $brand)
                                    <a href="{{ route('brands.edit', $brand) }}" class="btn btn-sm btn-outline-secondary" title="Редагувати">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan
                                @can('delete', $brand)
                                    @php $isTrashed = $brand->trashed(); @endphp
                                    @if($isTrashed)
                                        <form action="{{ route('brands.restore', $brand->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-success" title="Відновити бренд">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('brands.destroy', $brand) }}" method="POST" class="d-inline" onsubmit="return confirm('Ви впевнені, що хочете видалити цей бренд?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Видалити">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">Бренди не знайдено</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($brands->hasPages())
                <div class="card-footer d-flex justify-content-center bg-light py-3">
                    {{ $brands->links() }}
                </div>
            @endif
        </div>
    </div>
    @include('brands.include.image_modal')
@endsection
