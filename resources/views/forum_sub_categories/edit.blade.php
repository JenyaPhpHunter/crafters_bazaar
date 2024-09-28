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
        <div class="row learts-mb-n40">
            <div class="container">
                <form method="post" action="{{ route('forum_sub_categories.update', ['forum_sub_category' => $sub_category->id]) }}">
                    @csrf
                    @method('put')
                    <label for="forum_category_id">Категорія</label>
                    <select id="forum_category_id" name="forum_category_id">
                        @foreach($categories as $id => $name)
                            <option value="{{ $id }}" {{ $sub_category->forum_category_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    <br><br>
                    <label for="name">Назва підкатегорії</label>
                    <input id="name" name="name" value="{{$sub_category->name}}">
                    <br><br>

                    <button class="btn btn-dark btn-outline-hover-dark mb-3" type="submit">Зберегти</button>
                </form>
            </div>
@endsection
