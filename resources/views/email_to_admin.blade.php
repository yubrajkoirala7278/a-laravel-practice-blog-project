@component('mail::message')
# Name: {{ $name }}
# Email: {{ $email }}<br>
Subject: {{ $sub }} <br><br>
Message:<br> {{ $mess }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
