
@foreach(['danger','warning','success','info'] as $msg)
    @if(session()->has($msg))
    <div class="flash-message" style="margin:100px auto;">
        <p class="alert alert-{{ $msg }}">
            {{ session()->get($msg) }}
        </p>
    </div>
    @endif
@endforeach