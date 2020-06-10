@component('mail::message')
# Nieuwe printopdracht

Iemand wil iets bij je afprinten!

@component('mail::button', ['url' => $url])
Bekijk
@endcomponent

Vriendelijke groeten,<br>
{{ config('app.name') }}
@endcomponent
