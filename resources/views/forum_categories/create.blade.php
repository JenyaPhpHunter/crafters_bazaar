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

