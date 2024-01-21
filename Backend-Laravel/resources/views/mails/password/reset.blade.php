<x-mail::message>
# Salut

Cliquez sur le lien ci-dessous pour réinitialiser votre mot de passe

<x-mail::button :url="'http://localhost:4200/reset-password?id=1'">
Cliquez ici
</x-mail::button>

Merci,<br>
{{ config('app.name') }}
</x-mail::message>
