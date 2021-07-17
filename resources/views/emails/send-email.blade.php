@component('mail::message')
<h2>Sende Bize Katılmalısın!</h2>

Scotium ailesine katılıp benimle beraber yükselmek için aşağıdaki <code>Davet Kodunu</code> kullanabilirsin.
Bu sayede ikimizde kazanç sağlayabiliriz.

<h3 style="margin-top: 30px">Davet Kodunuz:</h3>
<div style="height: auto;width: 100%;background-color: rgba(224,218,203,0.79);display: flex;justify-content: center;align-items: center;margin-bottom: 30px">
<h1>{{$code}}</h1>
</div>

En yakın zamanda görüşmek dileğiyle,
<br>
{{ config('app.name') }}
@endcomponent