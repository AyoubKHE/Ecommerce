{{-- @php
    dd($username);
@endphp --}}
<x-dashboard.master :username="$username">

    <div style="margin: auto;">
        <p> Welcome to dashboard</p>
    </div>

    <x-slot:js>
    </x-slot>

</x-dashboard.master>
