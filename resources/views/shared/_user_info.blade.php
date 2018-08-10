<a href="{{ route('users.show', $user->id) }}">
    <img src="{{ $user->gravatar()['0'] }}" alt="{{ $user->name }}" title="{{$user->gravatar()[1]}}" class="gravatar"/>
</a>
<h1>{{ $user->name }}</h1>