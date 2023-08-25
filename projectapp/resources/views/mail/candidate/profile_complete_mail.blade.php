 <?php
	 $user=$details["user"];
	 $visitUrl=route('admin.dashboard');
?>	
	
@component('mail::message')
# Hello! {{$user->name}}

{{$details["welcomeMesage"]}}


@component('mail::button', ['url' => $visitUrl])
Go to your Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent