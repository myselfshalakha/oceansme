 <?php
	 $event=$details["event"];
	 $user=$details["user"];
	 $schedule=$details["schedule"];
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

Schedule Timings : {{ date("d-m-Y H:i a" , strtotime($schedule->schedule)) ?? "n/a" }}

Schedule Location Address: {{ $schedule->location ?? "n/a" }}

Google Map : <a href="{{ generateGoogleMapURL($schedule->location)}}" >Click here </a>


Thanks,

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
