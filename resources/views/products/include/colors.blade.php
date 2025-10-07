<div class="product-variations mb-4 animate__animated animate__fadeIn">
    <div class="d-flex align-items-center mb-2" style="gap: 0.25rem;">
        <label for="selectedColor" class="form-label m-0">
            <strong>Колір</strong>
        </label>
        <i class="fas fa-info-circle" style="color: $turquoise; font-size: 0.9rem; cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="right" title="До якого кольору ближчий ваш товар?"></i>
    </div>

    <input type="hidden" name="color_id" id="selectedColor" value="{{ old('color_id') }}">

    <div class="d-flex flex-wrap gap-2" style="margin-left: 0.5rem; margin-top: 0.5rem;">
        @foreach($colors as $key => $color)
            <div class="circle" id="circle{{ $key + 1 }}" data-name="Колір {{ $key + 1 }}" data-color="{{ $color->code }}" data-id="{{ $color->id }}" onclick="selectColor(this)" style="background-color: {{ $color->code }}; width: 26px; height: 26px; border-radius: 50%; cursor: pointer; border: 2px solid #00CED1; transition: all 0.3s ease;">
            </div>
        @endforeach
    </div>
</div>

<script>
    function selectColor(element) {
        document.querySelectorAll('.circle').forEach(c => c.classList.remove('selected'));
        element.classList.add('selected');
        element.style.transform = 'scale(1.1)';
        document.getElementById('selectedColor').value = element.dataset.id;
        setTimeout(() => element.style.transform = 'scale(1)', 200);
    }
</script>
