<div class="alert alert-{{ $type }}">
    @if (is_array($message))
        <ul>
            @foreach ($message as $val)
                <li>{{ $val }}</li>
            @endforeach
        </ul>
    @else
        {{ $message }}
    @endif
</div>