<div class="mini-thumbs-row">
    @foreach($header_products as $item)
        @php $photo = $item->productPhotos->first(); @endphp
        @if($photo)
            <div class="mini-thumb">
                <a href="{{ route('products.show', $item) }}" style="position:relative; display:block;">
                    <img src="{{ $photo->small_url }}" alt="{{ $item->title }}" loading="lazy">

                    @if($item->discount)
                        <span class="badge badge-sale">-{{ $item->discount }}%</span>
                    @elseif($item->is_new)
                        <span class="badge badge-new">new</span>
                    @endif
                </a>
            </div>
        @endif
    @endforeach
</div>
