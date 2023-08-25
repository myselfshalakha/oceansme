 <?php
	 $event=$details["event"];
	 $user=$details["user"];
	 if(isset($details["visitUrl"])){
		$visitUrl=$details["visitUrl"];
	 }else{
		$visitUrl=route('admin.events',['param'=>'apply'])."?id=".$event->ev_id; 
	 }
	$company=get_company_infoby_Id($event->company_id);
	$companyContent="";										
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

Event Details

Name: {{$event->name}}

{{$details["welcomeMesage"]}}{{get_after_action_response("candidateMessage","jobMailText",$event->uev_status)}}

{{$details["welcomeContent"]}}

@component('mail::button', ['url' => $visitUrl])
Go to your Dashboard
@endcomponent

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
