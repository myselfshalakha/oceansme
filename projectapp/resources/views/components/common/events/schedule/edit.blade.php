@extends('layouts.app')

@section('content')
<?php
$tabArr=["schedule"];
$activeTab="schedule";
if(session()->has('activeTab')){
	 $activeTab=session()->get('activeTab');
}
$errorsArr = session('errors');
if ($errorsArr) {
    $fields_tabs = [
        ['schedule', 'location']
    ];
    foreach ($fields_tabs as $tab => $fields) {
        foreach ($fields as $field) {
            if ($errorsArr->has($field)) {
                $activeTab = $tabArr[$tab];
                break;
            }
        }
    }
}
?>
<div class="cstm_schedule_admin_edit cstm_common_admin">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

					@if ($errors->any())
									<div class="alert alert-danger">
										<strong>Whoops!</strong> There were some problems with your input.<br><br>
										<ul>
											@foreach ($errors->all() as $error)
												<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
							@endif
							@if(session()->has('success'))
								<div class="alert alert-success">
									{{ session()->get('success') }}
								</div>
							@endif
			</div>
				<div class="col-md-12">
					<div class="tab-content" id="nav-tabContent">
					  <div class="tab-pane fade @if( $activeTab=='schedule') show active @endif" id="nav-schedule" role="tabpanel" aria-labelledby="nav-home-tab">
							  <div class="card">
								<div class="card-header">Update Event #{{$event->id}} Schedule</div>
								<div class="card-body">
								 <form method="POST" action="{{route('admin.schedule',['param'=>'save'])}}" >
									@csrf
									 <input type="hidden" name="event_id" value="{{ $event->id }}"> 
									 <input type="hidden" name="id" value="{{ $schedule->id }}"> 
										<input type="hidden" name="start_date" id="start_date" value="@if(isset($event)){{ date('m/d/Y',strtotime($event->start_date)) }}@else{{ old('start_date') }}@endif" >
										<input type="hidden" name="start_date" id="start_date" value="@if(isset($event)){{ date('m/d/Y',strtotime($event->start_date)) }}@else{{ old('start_date') }}@endif" >
									<div class="row mb-3">
										<label for="schedule" class="col-md-4 col-form-label text-md-end">{{ __('Schedule') }}</label>

										<div class="col-md-6">
											<input id="schedule_date" data-start="@if(isset($event)){{ date('m/d/Y',strtotime($event->start_date)) }}@endif" data-end="@if(isset($event)){{ date('m/d/Y',strtotime($event->end_date)) }}@endif" type="text" class="form-control @error('schedule') is-invalid @enderror" name="schedule" value="@if(isset($schedule)){{ date('m/d/Y',strtotime($schedule->schedule)) }}@else{{ old('schedule') }}@endif" autocomplete="schedule" autofocus>

											@error('schedule')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
									</div> 
									<div class="row mb-3">
										<label for="schedule_time" class="col-md-4 col-form-label text-md-end">{{ __('Schedule Time') }}</label>

										<div class="col-md-6">
											<input id="schedule_time" type="text" class="form-control @error('schedule_time') is-invalid @enderror" name="schedule_time" value="@if(isset($schedule)){{ date('h:i:s a',strtotime($schedule->schedule)) }}@else{{ old('schedule_time') }}@endif" autocomplete="schedule_time" autofocus>

											@error('schedule_time')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
									</div>   
									<div class="row mb-3">
										<label for="location_link" class="col-md-4 col-form-label text-md-end">{{ __('Location Map Link') }}</label>

										<div class="col-md-6">
											<input id="location_link" type="text" class="form-control @error('location_link') is-invalid @enderror" name="location_link" value="@if(isset($schedule)){{ $schedule->location_link }}@else{{ old('location_link') }}@endif"  autocomplete="location_link" autofocus>

											@error('location_link')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
									</div>
									 <div class="row mb-3">
										<label for="location" class="col-md-4 col-form-label text-md-end">{{ __('Location Full Address') }}</label>

										<div class="col-md-6">
											<input id="location" type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="@if(isset($schedule)){{ $schedule->location }}@else{{ old('location') }}@endif"  autocomplete="location" autofocus>

											@error('location')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
									</div>
									  <div class="row mb-0 submit_btn_row">
										<div class="col-md-12 d-flex">
											<button type="submit" class="btn btn-primary">
												Submit
											</button> 
											<a href="{{ route('admin.events') }}/edit?id={{$event->id}}" class="btn btn-secondary">
												Cancel
											</a>
										</div>  
									</div>
								</form>
							</div>
						</div>
				  </div>
				</div>
			  </div>
	   </div>
	</div>
	@endsection
</div>
