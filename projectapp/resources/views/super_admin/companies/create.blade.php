@extends('layouts.app')
@section('content') 
<!--script src="https://cdn.tiny.cloud/1/0g9zrhnit6qjem3iiq3ygq0lhtj0dc93c1ts8gncj6p3887k/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
   tinymce.init({
     selector: 'textarea#loi_input', // Replace this CSS selector to match the placeholder element for TinyMCE
     plugins: 'powerpaste advcode table lists checklist',
     toolbar: 'undo redo | blocks| bold italic | bullist numlist checklist | code | table'
   });
</script-->
<div class="cstm_companies_admin_add cstm_common_admin">
	<div class="row justify-content-center">
	   
			 <div class="col-12 grid-margin stretch-card">
			   <div class="card">
					<div class="card-header">@if(isset($company)) Company Changes @else Add Company @endif</div>

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
									<form action="{{route('admin.company',['param'=>'save'])}}" method="post"  enctype="multipart/form-data">
									
									
										{{csrf_field()}}
										@if(isset($company)) <input type="hidden" name="id" value="{{ $company->id }}"> @endif
										
										<div class="row mb-3">
											<label for="name" class="col-md-4 col-form-label text-md-end">Name<span class="required_star">*</span></label>
											<div class="col-md-6">
											<input type="text" name="name" class="form-control" placeholder="Company Name" value="@if(isset($company)){{ $company->name }}@else{{ old('name') }}@endif">
											 @error('name')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
											</div>
										</div>
										<div class="row mb-3">
											<label for="name" class="col-md-4 col-form-label text-md-end">Email<span class="required_star">*</span></label>
											<div class="col-md-6">
											<input type="email" name="email" class="form-control" placeholder="Company Email" value="@if(isset($company)){{ $company->email }}@else{{ old('email') }}@endif">
											 @error('email')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
											</div>
										</div>
										
										<div class="row mb-3">
											<label for="phone" class="col-md-4 col-form-label text-md-end">Phone<span class="required_star">*</span></label>
											<div class="col-md-6">
											<input type="text" name="phone" class="form-control" placeholder="Company Phone" value="@if(isset($company)){{ $company->phone }}@else{{ old('phone') }}@endif">
											 @error('phone')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
											</div>
										</div>
										<div class="row mb-3">
											<label for="logo" class="col-md-4 col-form-label text-md-end">Logo</label>
											<div class="col-md-6">
											@if(isset($company) && !empty($company->logo))
												<img src="{{ url('/') }}/assets/images/company/{{$company->logo}}"  class="frm-img frm-logo-img"> 
											@endif
											<input type="file" name="logo" id="comp_logo" class="form-control">
											 @error('logo')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror

											</div>
										</div>
										<div class="row mb-3">
											<label for="country" class="col-md-4 col-form-label text-md-end">Country</label>
											<div class="col-md-6">
											<select class="form-control country_options" data-action="{{route('admin.company',['param'=>'getState'])}}" name="country" id="comp_country">
												<option value="">Choose any one option</option>
												@if(!empty($countries))
													@foreach($countries as $country)
														<option @if(isset($company) && $company->country_id == $country->id) selected  @endif value="{{ $country->id }}">{{$country->name}}</option>
													@endforeach
													<option value="other" @if(isset($company) && $company->country_id == "other") selected @endif>Other</option>
												@endif
											</select>
											 @error('country')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
											</div>
										</div>
										<div class="row mb-3">
											<label for="state" class="col-md-4 col-form-label text-md-end">State</label>
											<div class="col-md-6">
											<select class="form-control state_options" data-action="{{route('admin.company',['param'=>'getCity'])}}"  name="state" id="comp_state">
												@if(isset($states)&&!empty($states))
														<option value="">Choose any one option</option>
														@foreach($states as $state)
															<option @if(isset($company) && $company->state_id == $state->id) selected  @endif value="{{ $state->id }}">{{$state->name}}</option>
														@endforeach
														<option value="other" @if(isset($company) && $company->state_id == "other") selected @endif>Other</option>
												@elseif(isset($company) && $company->state_id == "other")
												<option value="">Choose any one option</option>
												<option value="other" selected>Other</option>
												@else
												<option value="">Choose Country First</option>
												@endif
											</select>
											 @error('state')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
											</div>
										</div>
										<div class="row mb-3">
											<label for="city" class="col-md-4 col-form-label text-md-end">City</label>
											<div class="col-md-6">
											<select class="form-control city_options" name="city" id="comp_city">
												@if(isset($cities)&&!empty($cities))
													<option value="">Choose any one option</option>
													@foreach($cities as $city)
														<option @if(isset($company) && $company->city_id == $city->id) selected  @endif value="{{ $city->id }}">{{$city->name}}</option>
													@endforeach
													<option value="other" @if(isset($company) && $company->city_id == "other") selected @endif>Other</option>
												@elseif(isset($company) && $company->city_id == "other")
												<option value="">Choose any one option</option>
												<option value="other" selected>Other</option>
												@else
												<option value="">Choose State First</option>
												@endif
											</select>
											 @error('city')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
											</div>
										</div>
										<div class="row mb-3">
											<label for="address" class="col-md-4 col-form-label text-md-end">Address<span class="required_star">*</span></label>
											<div class="col-md-6">
											<textarea class="form-control" name="address" rows="10">@if(isset($company)){{ $company->address }}@else{{ old('address') }}@endif</textarea>
											 @error('address')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
											</div>
										</div>
										<div class="row mb-3">
											<label for="landmark" class="col-md-4 col-form-label text-md-end">Landmark</label>
											<div class="col-md-6">
											<textarea class="form-control" name="landmark" rows="10">@if(isset($company)){{ $company->address2 }}@else{{ old('landmark') }}@endif</textarea>
											 @error('landmark')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
											</div>
										</div>
										<div class="row mb-3">
											<label for="description" class="col-md-4 col-form-label text-md-end">Description</label>
											<div class="col-md-6">
											<textarea class="form-control" name="description" rows="10">@if(isset($company)){{ $company->description }}@else{{ old('description') }}@endif</textarea>
											 @error('description')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
											</div>
										</div>
										<div class="row mb-3">
											<label for="website" class="col-md-4 col-form-label text-md-end">Website<span class="required_star">*</span></label>
											<div class="col-md-6">
											<input type="text" name="website" class="form-control" placeholder="https://example.com or http://www.example.com" value="@if(isset($company)){{ $company->website_link }}@else{{ old('website') }}@endif">
											 @error('website')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
											</div>
										</div>
										 <div class="row mb-3">
                                    <label for="evaluate_by_company" class="col-md-4 col-form-label text-md-end">Evaluate by company<span class="required_star">*</span></label>
                                    <div class="col-md-6">
                                        <select class="form-control city_options" name="evaluate_by_company" id="evaluate_by_company">
                                          <option value="">Choose any one option</option>
                                          <option @if(isset($company) && $company->evaluate_by_company == 'yes') selected  @endif value="yes">Yes</option>
                                          <option @if(isset($company) && $company->evaluate_by_company == 'no') selected  @endif value="no">No</option>
                                         
                                       </select>
                                       @error('evaluate_by_company')
                                       <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                       </span>
                                       @enderror
                                    </div>
                                 </div>
										<!--div class="row mb-3">
											<label for="loi_input" class="col-md-4 col-form-label text-md-end">LOI<span class="required_star">*</span></label>
											<div class="col-md-6">
											<textarea id="loi_input" name="loi">@if(isset($company)){{ $company->loi }}@else{{ old('loi') }}@endif</textarea>
											 @error('loi')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
											</div>
										</div-->
										<div class="row mb-0 submit_btn_row">
											<div class="col-md-12 d-flex">
												<button type="submit" class="btn btn-primary">
													Submit
												</button> 
												<a href="{{ route('admin.company') }}" class="btn btn-secondary">
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