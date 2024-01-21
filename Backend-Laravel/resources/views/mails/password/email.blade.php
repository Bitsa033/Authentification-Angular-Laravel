<x-mail::message>
# Introduction

Bonjour veuillez confirmer votre adresse email

<x-mail::button :url="''">
Cliquez ici
</x-mail::button>

Merci,<br>
{{ config('app.name') }}
</x-mail::message>
