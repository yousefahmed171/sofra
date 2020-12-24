@component('mail::message')
# Introduction


Blood Bank Reset Password


<p>Hello {{$sofra->name}}</p>


@component('mail::button', ['url' => '', 'color' => 'success'])
Reset Password
@endcomponent


<p>Your Reset Code Is : {{$sofra->pin_code}}</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
