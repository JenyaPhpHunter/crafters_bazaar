@extends('admin.layouts.app')

@section('content')
    <div class="section section-padding pt-0">
        <div class="section section-fluid learts-mt-70">
            <div class="container">
                <div class="row learts-mb-n50">
                    <div class="col-lg-9 col-12 learts-mb-50">
                        @foreach($tags as $tag)
                            <div class="category-container" id="category-{{ $tag->id }}">
                                <!-- Контейнер для категорії та карандаша -->
                                <a href="{{ route('admin_tags.show', ['admin_tag' => $tag->id]) }}">{{ $tag->title }}</a>
                                @isset($user)
                                    @can('edit', $tag)
                                        <span style="display: inline-block; width: 30px;"></span>
                                        <a href="{{ route('admin_tags.edit', ['admin_tag' => $tag->id]) }}">
                                            <i class="fas fa-pencil-alt"></i> <!-- Карандаш -->
                                        </a>
                                    @endcan
                                    @can('delete', $tag)
                                        <!-- Додаємо відступ між іконками -->
                                        <span style="display: inline-block; width: 30px;"></span>
                                        <!-- Іконка для видалення -->
                                        <form action="{{ route('admin_tags.destroy', ['admin_tag' => $tag->id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="border:none; background:none; padding:0; margin:0; color:red;" title="Видалити тег" onclick="return confirm('Ви впевнені, що хочете видалити цeй тег?');">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @endcan
                                @endisset
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
  @endsection

