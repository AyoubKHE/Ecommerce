@props(['type', 'header', 'text', 'error', 'file', 'line'])
<div class="alert alert-{{ $type }} my-3"
    style="margin: auto; border-radius: 10px; width: 70%; text-align: center;" role="alert">
    @if (!empty($header))
        <strong>{{ $header }}</strong>
        <br>
    @endif
    {{ $text }}
</div>


{{-- for logging errors --}}

{{-- @if (!empty($error))
<div style="background-color: #b74242;color: white;padding: 20px;width: 80%;margin: auto;border-radius: 15px;">
    <strong style="color: yellow;">Error :</strong>
    <p> {{ $error }}</p>

    <strong style="color: yellow;">File :</strong>
    <p> {{ $file }}</p>

    <strong style="color: yellow;">Line :</strong> <span>{{ $line }}</span>
</div>
@endif --}}
