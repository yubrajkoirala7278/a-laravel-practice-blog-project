@component('mail::message')
# Title: {{ $blog['title'] }}
# Email: {{ $blog['email'] }}
# Name: {{ $blog['author'] }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
