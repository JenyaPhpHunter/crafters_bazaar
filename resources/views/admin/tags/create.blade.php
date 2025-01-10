@extends('admin.layouts.app')

@section('content')
    <div class="section section-padding border-bottom">
        <div class="container">
            <div class="row learts-mb-n40">
                <div class="col-lg-6 col-12 learts-mb-40">
                    <form method="post" action="{{ route('admin_tags.store') }}">
                        @csrf
                        <label for="title">Назва тегу</label>
                        <input id="title" name="title" type="text" class="tag-title"
                               placeholder="Введіть назву тегу">
                        <br><br>
                        <button class="btn btn-dark btn-outline-hover-dark mb-3" type="submit">Зберегти</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
