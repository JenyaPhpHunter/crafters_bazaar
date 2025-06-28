@props([
    'field' => '',
    'label' => '',
    'currentField' => '',
    'currentDirection' => 'asc'
])

@php
    $direction = ($currentField == $field && $currentDirection == 'asc') ? 'desc' : 'asc';
    $icon = '';

    if ($currentField == $field) {
        $icon = $currentDirection == 'asc' ? '↑' : '↓';
    }
@endphp

<a href="{{ request()->fullUrlWithQuery([
    'sort_by' => $field,
    'sort_dir' => $direction,
    'page' => null
]) }}" class="text-decoration-none text-dark">
    {{ $label }} {!! $icon !!}
</a>
