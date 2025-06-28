@extends('layouts.app')

@section('content')
    <div class="section section-padding border-bottom">
        <div class="row learts-mb-n40">
            <div class="container">
                <form method="post" action="{{ route('forum_categories.update', ['forum_category' => $category->id]) }}">
                    @csrf
                    @method('put')
                    <label for="name">Назва категорії</label>
                    <input id="name" name="name" value="{{$category->name}}">
                    <br><br>

                    <button class="btn btn-dark btn-outline-hover-dark mb-3" type="submit">Зберегти</button>
                </form>
            </div>
@endsection
