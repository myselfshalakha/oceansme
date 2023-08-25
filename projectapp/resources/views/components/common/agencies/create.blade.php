@extends('layouts.app')
@section('content') 
<div class="row justify-content-center">
  @if(!Auth::user()->hasRole('hr_manager'))
      <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="template-demo">
                    <div class="btn-group">
                      <button type="button" class="btn btn-primary">Agency Settings</button>
                      <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuSplitButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton1">
                        <a class="dropdown-item" href="{{ route('admin.agency') }}/add">Add</a>
                        <a class="dropdown-item" href="{{ route('admin.agency') }}">List</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
        </div>
		@endif
		 <div class="col-12 grid-margin stretch-card">
		   <div class="card">
                <div class="card-header">@if(isset($agency)) Agency Changes @else Add Agency @endif</div>

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
								<form action="{{route('admin.agency',['param'=>'save'])}}" method="post">
								
								
									{{csrf_field()}}
									@if(isset($agency)) <input type="hidden" name="id" value="{{ $agency->id }}"> @endif
									<input type="hidden" name="event_id" value="{{ $agency->event_id }}">
									
									<div class="row mb-3">
										<label for="name" class="col-md-4 col-form-label text-md-end">Name<span class="required_star">*</span></label>
										<div class="col-md-6">
										<input type="text" name="name" class="form-control" placeholder="Name" value="@if(isset($agency)) {{ $agency->name }} @endif">
										</div>
									</div>
									<div class="row mb-3">
										<label for="email" class="col-md-4 col-form-label text-md-end">Email<span class="required_star">*</span></label>
										<div class="col-md-6">
										<input type="text" name="email" class="form-control" placeholder="Email" value="@if(isset($agency)) {{ $agency->email }} @endif">
										</div>
									</div>
									<div class="row mb-3">
										<label for="phone" class="col-md-4 col-form-label text-md-end">Phone<span class="required_star">*</span></label>
										<div class="col-md-6">
										<input type="text" name="phone" class="form-control" placeholder="Phone" value="@if(isset($agency)) {{ $agency->phone }} @endif">
										</div>
									</div>
									<div class="row mb-3">
										<label for="address" class="col-md-4 col-form-label text-md-end">Address<span class="required_star">*</span></label>
										<div class="col-md-6">
										<textarea name="address" class="form-control" placeholder="Address"> @if(isset($agency)) {{ $agency->address }}@endif</textarea>
										</div>
									</div>
									<div class="row mb-3">
										<label for="country_id" class="col-md-4 col-form-label text-md-end">Countries<span class="required_star">*</span></label>
										<div class="col-md-6">
										<?php
									$country_idArr=array();
									if(!empty($agency->country_id)){
										$country_idArr= unserialize($agency->country_id);
									}
									?>
										<select class="form-control @error('country_id') is-invalid @enderror" name="country_id[]" id="agency_country_id" multiple="multiple">
												@if(!empty($countries))
													@foreach($countries as $country)
														<option @if(in_array($country->id,$country_idArr)) selected  @endif value="{{ $country->id }}">{{$country->name}}</option>
													@endforeach

												@endif
											</select>
										</div>
									</div>
									
									<div class="row mb-0 submit_btn_row">
										<div class="col-md-12 d-flex">
											<button type="submit" class="btn btn-primary">
												Submit
											</button> 
											  @if(Auth::user()->hasRole('hr_manager'))
												<a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
												Cancel
											</a>
												@else 
											<a href="{{ route('admin.agency') }}" class="btn btn-secondary">
												Cancel
											</a>
											@endif 
										</div>  
									</div>
								</form>
							</div>
						</div>
                    
				</div>
			</div>
		</div>
	</div>
@endsection