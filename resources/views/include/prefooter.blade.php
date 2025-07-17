<div class="card-footer text-muted">
    Створено {{ $object->created_at->format('d.m.Y H:i') }}  користувачем {{ $object->creator->name }} |
    Оновлено {{ $object->updated_at->format('d.m.Y H:i') }}
</div>
