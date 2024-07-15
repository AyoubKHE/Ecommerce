@if (session()->has('message'))

    @if (isset(session('message')['error']))
        <x-messages.alert type="{{ session('message')['type'] }}" text="{{ session('message')['text'] }}"
            error="{{ session('message')['error'] }}" file="{{ session('message')['file'] }}"
            line="{{ session('message')['line'] }}" />
    @else
        <x-messages.alert type="{{ session('message')['type'] }}" text="{{ session('message')['text'] }}" />
    @endif


@endif
