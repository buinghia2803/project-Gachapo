<div class="p-2 alert alert-{{$type}} pt-0 pb-0 message-booking">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    @if ($messages && is_array($messages))
        @foreach($messages as $key => $message)
            <p class="mb-1">{!! $message !!}</p>
        @endforeach
    @endif

    @if ($messages && !is_array($messages))
        @if(is_string($messages))
            <p class="mb-1">{!! $messages !!}</p>
        @elseif ($messages->any())
            @foreach($messages->all() as $key => $message)
                <p class="mb-1">{!! $message !!}</p>
            @endforeach
        @endif
    @endif
</div>
