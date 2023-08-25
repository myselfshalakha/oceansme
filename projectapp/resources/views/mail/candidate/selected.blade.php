 <?php
	 $event=$details["event"];
	 $user=$details["user"];
	 $acceptUrl=route('admin.events',['param'=>'userResponse'])."?uev_id=".$event->uev_id."&status=9";
	 $declineUrl=route('admin.events',['param'=>'userResponse'])."?uev_id=".$event->uev_id."&status=5";
	 $company=get_company_infoby_Id($event->company_id);
?>
@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
{{ config('app.name') }}
@endcomponent
@endslot

@if(isset($company) && !empty($company->logo))
<table style="width:100%;">
<tr style="width:100%;">
<td style="float:left;"><img src="{{ url('/') }}/assets/images/company/{{$company->logo}}" style="height:100px;"></td>
<td style="float:right;"><strong>{{$company->name}}</strong><br><strong>{{$company->phone}}</strong><br><strong>{{$company->email}}</strong><br><strong>{{$company->website_link}}</strong><br></td>
</tr>
</table>
@endif

# Hello! {{$user->name}}

{{$details["welcomeMesage"]}}{{get_after_action_response("candidateMessage","jobMailText",$event->uev_status)}}

{{$details["welcomeContent"]}}

Event Details

Name: {{$event->name}}

Please give your response as soon as poossible.
<div style="display:flex">
<div style="width:50%">
@component('mail::button', ['url' => $acceptUrl])
Attending
@endcomponent
</div>
<div style="width:50%">
@component('mail::button', ['url' => $declineUrl, 'color' => 'error'])
Decline
@endcomponent
</div>
</div>
Thanks,

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
