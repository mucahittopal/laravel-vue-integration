@component('mail::message')
    <div>
        {{$data['message']}}
    </div>
    <div>
        <div>Customer contact details:</div>
        <div>Email: {{$data['email']}}</div>
        <div>Phone no. : {{$data['phone']}}</div>
    </div>

    Thanks,
    <div>{{ config('app.name') }}</div>
@endcomponent