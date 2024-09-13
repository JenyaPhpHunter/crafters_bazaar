@if {{ $bread }}
  <ol class="breadcrumb">
    @foreach ($bread as $forbr)
      <li class="active">
          <strong>{$br.name}</strong>
      </li>
    @else
      <li>
          <a href="{$br.url}">{$br.name}</a>
      </li>
      {/if}
    @endforeach

  </ol>
@endif
