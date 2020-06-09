@component('mail::message')
# Printopdracht aanvaard

Men zal je bestanden nu afdrukken!

@component('mail::button', ['url' => $url])
Bekijk
@endcomponent

Vriendelijke groeten,<br>
{{ config('app.name') }}
@endcomponent
