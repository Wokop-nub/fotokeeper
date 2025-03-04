<ul class="album-children">
    @foreach ($albums as $album)
        <li>
            <div class="album-header" data-album-id="{{ $album->id }}">
                <span class="toggle-icon">▶</span>
                {{ $album->name }}
            </div>
            <div class="hidden">
                @if (isset($album->child) && count($album->child) > 0)
                    <ul class="album-children">
                        @include('block.albumTree', ['albums' => $album->child])
                    </ul>
                @endif

                @if ($album->photos && count($album->photos) > 0)
                    <ul class="album-photos">
                        @foreach ($album->photos as $photo)
                            <li><img
                                src="/storage/uploads/{{ $photo->filename }}"
                                alt=""
                                data-photo-id="{{$photo->id}}"
                                draggable="true"
                            ></li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </li>
    @endforeach
</ul>
