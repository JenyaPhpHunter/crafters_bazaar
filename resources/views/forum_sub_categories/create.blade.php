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

