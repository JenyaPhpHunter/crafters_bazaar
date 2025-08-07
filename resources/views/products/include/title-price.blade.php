{{--<label for="title">Назва</label>--}}
{{--<input id="title" name="title" type="text" class="form-control mb-3" placeholder="Введіть назву товару" value="{{ old('title') }}">--}}
{{--@error('title') <div class="alert alert-danger">{{ $message }}</div> @enderror--}}

{{--<label for="price">Вартість, грн</label>--}}
{{--<input id="price" name="price" type="number" min="0" step="1" class="form-control mb-3" placeholder="Введіть вартість товару" value="{{ old('price') }}">--}}
{{--@error('price') <div class="alert alert-danger">{{ $message }}</div> @enderror--}}

{{--<label for="content">Інформація про товар</label>--}}
{{--<textarea id="content" name="content" rows="6" class="form-control mb-3" placeholder="Введіть опис товару, щоб зацікавити покупця">{{ old('content') }}</textarea>--}}
{{--@error('content') <div class="alert alert-danger">{{ $message }}</div> @enderror--}}
<div class="form-section">
    <label for="title" class="form-label">Назва</label>
    <input type="text" id="title" name="title" class="form-control"
           value="{{ old('title') }}" placeholder="Введіть назву товару">
</div>

<div class="form-section">
    <label for="price" class="form-label">Вартість, грн</label>
    <input type="number" step="0.01" id="price" name="price" class="form-control"
           value="{{ old('price') }}" placeholder="Вкажіть ціну за одиницю">
</div>
