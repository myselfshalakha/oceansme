 <?php
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

# Hello! {{$agency->name}}

Event Details

Name: {{$event->name}}
Description: {{$event->description}}

This is Csv Report of all selected users for above event.

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
