@extends('layouts.app')
@section('content') 
<div class="row justify-content-center">
     
		 <div class="col-12 grid-margin stretch-card">
		   <div class="card">
                <div class="card-header">@if(isset($event)) Event Changes @else Add Event @endif</div>

                <div class="card-body">
					<div class="row">
							<div class="col-12">
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
								<form action="{{route('admin.events',['param'=>'save'])}}" method="post"   enctype="multipart/form-data">
								
								
									{{csrf_field()}}
									@if(isset($event)) <input type="hidden" name="id" value="{{ $event->id }}"> @endif
									
									<div class="row mb-3">
										<label for="name" class="col-md-4 col-form-label text-md-end">Event Name<span class="required_star">*</span></label>
										<div class="col-md-6">
										<input type="text" name="name" class="form-control" placeholder="Event Name" value="@if(isset($event)) {{ $event->name }} @else{{ old('name') }}@endif">
										@error('name')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
										</div>
									</div>
									<div class="row mb-3">
										<label for="start_date" class="col-md-4 col-form-label text-md-end">Start Date<span class="required_star">*</span> </label>
										<div class="col-md-6">
										<input type="text" name="start_date" id="start_date" class="form-control" placeholder="Event Start Date" value="@if(isset($event)){{ date('m/d/Y',strtotime($event->start_date)) }}@else{{ old('start_date') }}@endif" autocomplete="off">
										@error('start_date')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
										</div>
									</div>	
									<div class="row mb-3">
										<label for="end_date" class="col-md-4 col-form-label text-md-end">End Date<span class="required_star">*</span></label>
										<div class="col-md-6">
										<input type="text" name="end_date" id="end_date" class="form-control" placeholder="Event End Date" value="@if(isset($event)){{ date('m/d/Y',strtotime($event->end_date)) }}@else{{ old('end_date') }}@endif"  autocomplete="off">
										@error('end_date')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
										</div>
									</div>
									<div class="row mb-3">
										<label  class="col-md-4 col-form-label text-md-end">Featured Image</label>
										<div class="col-md-6">
											@if(isset($event) && !empty($event->featured_image))
											<img src="{{ url('/') }}/assets/images/events/{{$event->featured_image}}"  class="frm-img frm-featured-img"> 
											@endif
											<input type="file" name="featured_image" id="featured_image" class="form-control">
											@error('featured_image')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror

										</div>
									</div>
									<div class="row mb-3">
										<label for="post" class="col-md-4 col-form-label text-md-end">Post</label>
										<div class="col-md-6">
										<?php
											$postname=array();
											if(!empty($event->post_id)){
												$postname= unserialize($event->post_id);
											}
										?>
										<select class="form-control" name="post[]" id="ev_post" multiple="multiple">
											@if(!empty($posts))
												@foreach($posts as $post)
													<option @if(in_array($post->id,$postname)) selected  @endif value="{{ $post->id }}">{{$post->name}}</option>
												@endforeach

											@endif
										</select>
										@error('post')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
										</div>
									</div>
									<div class="row mb-3">
										<label for="restrictedCountries" class="col-md-4 col-form-label text-md-end">Restricted Countries</label>
										<div class="col-md-6">
										<?php
											$restrictedCountriesArr=array();
											if(!empty($event->restrictedCountries)){
												$restrictedCountriesArr= unserialize($event->restrictedCountries);
											}
										?>
										<select class="form-control" name="restrictedCountries[]" id="restrictedCountries" multiple="multiple">
											@if(!empty($countries))
												@foreach($countries as $country)
													<option @if(in_array($country->id,$restrictedCountriesArr)) selected  @endif value="{{ $country->id }}">{{$country->name}}</option>
												@endforeach

											@endif
										</select>
										@error('restrictedCountries')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
										</div>
									</div>
									<div class="row mb-3">
										<label for="company" class="col-md-4 col-form-label text-md-end">Company</label>
										<div class="col-md-6">
										<select class="form-control" name="company" id="ev_company">
											@if(!empty($companies))
												@foreach($companies as $company)
													<option @if(isset($event) && $event->company_id == $company->id) selected  @endif value="{{ $company->id }}">{{$company->name}}</option>
												@endforeach

											@endif
										</select>
										</div>
									</div>
									<div class="row mb-3">
										<label for="restrictedExperience" class="col-md-4 col-form-label text-md-end">Experience Required </label>
										<div class="col-md-6">
										<input type="number" name="restrictedExperience" class="form-control" placeholder="Ex: 0, 1.5 and so on" value="@if(isset($event)){{ $event->restrictedExperience }}@else{{ old('restrictedExperience') }}@endif" required>
										</div>
										@error('restrictedExperience')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									</div>
								<div class="row mb-3">
										<label for="evaluator" class="col-md-4 col-form-label text-md-end">Evaluator</label>
										<div class="col-md-6">
											<select class="form-control" name="evaluator[]" id="ev_evaluator" multiple="multiple">
											@if(!empty($evaluators))
												@foreach($evaluators as $user)
													@php
													$selected="";
													@endphp
													@if(!empty($event_evaluators))
														@foreach($event_evaluators as $item)
															@if($user->id==$item->id)
																@php
																$selected="selected";
																@endphp
															@endif
														@endforeach
													@endif
													<option value="{{ $user->id }}" {{$selected}}>{{$user->name}}</option>
												@endforeach

											@endif
										</select>
										@error('evaluator')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
										</div>
									</div>
									<div class="row mb-3">
										<label for="description" class="col-md-4 col-form-label text-md-end">Description</label>
										<div class="col-md-6">
										<textarea class="form-control" name="description" rows="10">@if(isset($event)) {{ $event->description }} @else{{ old('description') }}@endif</textarea>
										@error('description')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
										</div>
									</div>
									<div class="row mb-3">
										<label for="status" class="col-md-4 col-form-label text-md-end">Status</label>
										<div class="col-md-6">
										<select class="form-control" name="status" id="ev_status">
										<?php
										$status=get_event_status();
										?>
											@if(!empty($status))
												@foreach($status as $k=>$v)
													<option @if(isset($event) && $event->status == $k) selected  @endif value="{{ $k }}">{{$v}}</option>
												@endforeach
											@endif
										</select>
										@error('status')
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
											<a href="{{ route('admin.events') }}" class="btn btn-secondary">
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
		@if(isset($event))
		 <div class="col-12 grid-margin stretch-card">
		   <div class="card">
                <div class="card-header">Additional field</div>

                <div class="card-body">
					<div class="row">
							<div class="col-12">
								<div class="row">
										<div class="col-md-12 d-flex">
											<a href="{{ route('admin.events') }}/custom_form?id={{$event->id}}" class="btn btn-primary">
												Custom Fileds 
											</a>
										</div>  
								</div>
							</div>
					</div>
					<div class="row">
							<div class="col-12">
							<div class="event-form-build-wrap form-wrapper-div" id="event-form-build-wrap"></div>

							</div>
					</div>
				</div>
                    
			</div>
		</div>
		@endif
		
	</div>
@endsection

@section('footer')
<?php
$formdata=[];
if(isset($event->form_elements) && !empty($event->form_elements)){
	$formdata=json_encode(unserialize($event->form_elements));
?>
		<script>
		
		
    jQuery(function() {

  var code = document.getElementById("event-form-build-wrap");
  var formData ='<?php echo $formdata ?>';	
   var addLineBreaks = html => html.replace(new RegExp("><", "g"), ">\n<");

  var $markup = $("<div/>");
  $markup.formRender({ formData });

  code.innerHTML = addLineBreaks($markup.formRender("html")); 

});
		
	</script>
<?php
}
?>
@endsection
