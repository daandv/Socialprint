@component('mail::message')
# Printopdracht geweigerd

Helaas, je printopdracht is geweigerd en zal niet worden afgedrukt.

@component('mail::button', ['url' => $url])
Bekijk
@endcomponent

Vriendelijke groeten,<br>
{{ config('app.name') }}
@endcomponent
