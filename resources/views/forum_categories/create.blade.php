@extends('layouts.app')

@section('content')
    <div class="section section-padding border-bottom">
        <div class="container">
            <div class="row learts-mb-n40">
                <div class="col-lg-6 col-12 learts-mb-40">
                        <form method="post" action="{{ route('forum_categories.store') }}">
                            @csrf
                            <label for="name">Назва категорії</label>
                            <input id="name" name="name" type="text" class="category-title"
                                   placeholder="Введіть назву категорії">
                            <br><br>
                            <button class="btn btn-dark btn-outline-hover-dark mb-3" type="submit">Зберегти</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
@endsection

