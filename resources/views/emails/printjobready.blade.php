@component('mail::message')
# De prints zijn klaar. Geweldig!

Spreek snel af om deze op te halen!

@component('mail::button', ['url' => $url])
Bekijk
@endcomponent

Vriendelijke groeten,<br>
{{ config('app.name') }}
@endcomponent
