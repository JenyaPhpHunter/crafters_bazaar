<div class="form-section animate__animated animate__fadeIn">
    <label for="title" class="form-label">Назва</label>
    <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" placeholder="Введіть назву товару">
</div>

<div class="form-section animate__animated animate__fadeIn">
    <label for="price" class="form-label">Вартість, грн</label>
    <input type="number" step="0.01" id="price" name="price" class="form-control" value="{{ old('price') }}" placeholder="Вкажіть ціну за одиницю">
</div>
