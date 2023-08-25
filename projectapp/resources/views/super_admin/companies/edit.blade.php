@extends('layouts.app')
@section('content') 
<?php
$tabArr=["company","salary_system"];
$activeTab="company";
if(session()->has('activeTab')){
	 $activeTab=session()->get('activeTab');
}
$errorsArr = session('errors');
if ($errorsArr) {
    $fields_tabs = [
        ['name', 'email', 'website_link', 'address', 'logo', 'website', 'phone'], 
        ['dep_id', 'post_id', 'company_id', 'basic_wage', 'other_contractual', 'guaranteed_wage', 'service_charge', 'additional_bonus', 'bonus_level', 'bonus_personam', 'total_salary', 'incentive_type', 'contract_length', 'vacation_month', 'status']
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
<!--script src="https://cdn.tiny.cloud/1/0g9zrhnit6qjem3iiq3ygq0lhtj0dc93c1ts8gncj6p3887k/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
   tinymce.init({
     selector: 'textarea#loi_input', // Replace this CSS selector to match the placeholder element for TinyMCE
     plugins: 'powerpaste advcode table lists checklist',
     toolbar: 'undo redo | blocks| bold italic | bullist numlist checklist | code | table'
   });
</script-->
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
									@if(session()->has('error'))
										<div class="alert alert-danger">
											{{ session()->get('error') }}
										</div>
									@endif
							</div>
							<nav>
							  <div class="nav nav-tabs" id="nav-tab" role="tablist">
								<button class="nav-link @if( $activeTab=='company') active @endif" id="nav-company-tab" data-bs-toggle="tab" data-bs-target="#nav-company" type="button" role="tab" aria-controls="nav-company" @if( $activeTab=='company') aria-selected="true" @else aria-selected="false" @endif>Comapny Details</button>
								<button class="nav-link @if( $activeTab=='salary_system') active @endif" id="nav-salary_system-tab" data-bs-toggle="tab" data-bs-target="#nav-salary_system" type="button" role="tab" aria-controls="nav-salary_system" @if( $activeTab=='salary_system') aria-selected="true" @else aria-selected="false" @endif>Salary System</button>
							</div>
							</nav>
							<div class="col-12">
							<div class="tab-content" id="nav-tabContent">
							<div class="tab-pane fade @if( $activeTab=='company') show active @endif" id="nav-company" role="tabpanel" aria-labelledby="nav-company-tab">
									  <div class="card">
											<div class="card-header">Comapny Details</div>
											<div class="card-body">
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
							 <div class="tab-pane fade @if( $activeTab=='salary_system') show active @endif" id="nav-salary_system" role="tabpanel" aria-labelledby="nav-salary_system-tab">
									  <div class="card">
											<div class="card-header">Salary System</div>

											<div class="card-body">
														<div class="row">
												  <div class="col-sm-12">
													 <div class="accordion" id="salary_system_accordion">
													  <a href="javascript:void(0)" class="salary_systemaccordian_tab @if( $activeTab!='salary_system') collapsed @endif"  type="button" data-toggle="collapse" data-target="#salary_system_collapse" aria-expanded="false" aria-controls="salary_system_collapse">
														  Add Salary System
													  </a>
														<div id="salary_system_collapse" class="collapse @if( $activeTab=='salary_system') show @endif" aria-labelledby="headingThree" data-parent="#salary_system_accordion">
															 <form method="POST" action="{{route('admin.company',['param'=>'save_salary'])}}" >
																@csrf
																 <input type="hidden" name="company_id" value="{{ $company->id }}"> 
															  
																<div class="row mb-3">
																	<label for="dep_id" class="col-md-4 col-form-label text-md-end">{{ __('Department') }}</label>

																	<div class="col-md-6">
																	<select class="form-control department_options" data-action="{{route('admin.company',['param'=>'getPost'])}}"  name="dep_id">
																	<option value="">Choose any one option</option>
																		@if(!empty($departments))
																			@foreach($departments as $department)
																				<option value="{{ $department->id }}">{{$department->name}}</option>
																			@endforeach

																		@endif
																	</select>

																		@error('dep_id')
																			<span class="invalid-feedback" role="alert">
																				<strong>{{ $message }}</strong>
																			</span>
																		@enderror
																	</div>
																</div>	
																<div class="row mb-3">
																	<label for="dep_id" class="col-md-4 col-form-label text-md-end">{{ __('Posts') }}</label>

																	<div class="col-md-6">
																	<select class="form-control post_options" name="post_id">
																	<option value="">Choose Department First</option>
																	</select>

																		@error('post_id')
																			<span class="invalid-feedback" role="alert">
																				<strong>{{ $message }}</strong>
																			</span>
																		@enderror
																	</div>
																</div>
																<div class="row mb-3">
																	<label for="basic_wage" class="col-md-4 col-form-label text-md-end">{{ __('Basic Wage') }}</label>

																	<div class="col-md-6">
																	
																	<input id="basic_wage" type="text" class="form-control @error('basic_wage') is-invalid @enderror" name="basic_wage" value="{{ old('basic_wage') }}"  autocomplete="basic_wage" autofocus>

																		@error('basic_wage')
																			<span class="invalid-feedback" role="alert">
																				<strong>{{ $message }}</strong>
																			</span>
																		@enderror
																	</div>
																</div>
																<div class="row mb-3">
																	<label for="other_contractual" class="col-md-4 col-form-label text-md-end">{{ __('Other Contractual') }}</label>

																	<div class="col-md-6">
																	
																	<input id="other_contractual" type="text" class="form-control @error('other_contractual') is-invalid @enderror" name="other_contractual" value="{{ old('other_contractual') }}"  autocomplete="other_contractual" autofocus>

																		@error('other_contractual')
																			<span class="invalid-feedback" role="alert">
																				<strong>{{ $message }}</strong>
																			</span>
																		@enderror
																	</div>
																</div>
																<div class="row mb-3">
																	<label for="guaranteed_wage" class="col-md-4 col-form-label text-md-end">{{ __('Guaranteed Wage') }}</label>

																	<div class="col-md-6">
																	
																	<input id="guaranteed_wage" type="text" class="form-control @error('guaranteed_wage') is-invalid @enderror" name="guaranteed_wage" value="{{ old('guaranteed_wage') }}"  autocomplete="guaranteed_wage" autofocus>

																		@error('guaranteed_wage')
																			<span class="invalid-feedback" role="alert">
																				<strong>{{ $message }}</strong>
																			</span>
																		@enderror
																	</div>
																</div>
																<div class="row mb-3">
																	<label for="service_charge" class="col-md-4 col-form-label text-md-end">{{ __('Service Charge') }}</label>

																	<div class="col-md-6">
																	
																	<input id="service_charge" type="text" class="form-control @error('service_charge') is-invalid @enderror" name="service_charge" value="{{ old('service_charge') }}"  autocomplete="service_charge" autofocus>

																		@error('service_charge')
																			<span class="invalid-feedback" role="alert">
																				<strong>{{ $message }}</strong>
																			</span>
																		@enderror
																	</div>
																</div>
																<div class="row mb-3">
																	<label for="additional_bonus" class="col-md-4 col-form-label text-md-end">{{ __('Additional Bonus') }}</label>

																	<div class="col-md-6">
																	
																	<input id="additional_bonus" type="text" class="form-control @error('additional_bonus') is-invalid @enderror" name="additional_bonus" value="{{ old('additional_bonus') }}"  autocomplete="additional_bonus" autofocus>

																		@error('additional_bonus')
																			<span class="invalid-feedback" role="alert">
																				<strong>{{ $message }}</strong>
																			</span>
																		@enderror
																	</div>
																</div>
																<div class="row mb-3">
																	<label for="bonus_level" class="col-md-4 col-form-label text-md-end">{{ __('Bonus Level') }}</label>

																	<div class="col-md-6">
																	
																	<input id="bonus_level" type="text" class="form-control @error('bonus_level') is-invalid @enderror" name="bonus_level" value="{{ old('bonus_level') }}"  autocomplete="bonus_level" autofocus>

																		@error('bonus_level')
																			<span class="invalid-feedback" role="alert">
																				<strong>{{ $message }}</strong>
																			</span>
																		@enderror
																	</div>
																</div>
																<div class="row mb-3">
																	<label for="bonus_personam" class="col-md-4 col-form-label text-md-end">{{ __('Bonus Personam') }}</label>

																	<div class="col-md-6">
																	
																	<input id="bonus_personam" type="text" class="form-control @error('bonus_personam') is-invalid @enderror" name="bonus_personam" value="{{ old('bonus_personam') }}"  autocomplete="bonus_personam" autofocus>

																		@error('bonus_personam')
																			<span class="invalid-feedback" role="alert">
																				<strong>{{ $message }}</strong>
																			</span>
																		@enderror
																	</div>
																</div>
																<div class="row mb-3">
																	<label for="total_salary" class="col-md-4 col-form-label text-md-end">{{ __('Total Salary') }}</label>

																	<div class="col-md-6">
																	
																	<input id="total_salary" type="text" class="form-control @error('total_salary') is-invalid @enderror" name="total_salary" value="{{ old('total_salary') }}"  autocomplete="total_salary" autofocus>

																		@error('total_salary')
																			<span class="invalid-feedback" role="alert">
																				<strong>{{ $message }}</strong>
																			</span>
																		@enderror
																	</div>
																</div>
																<div class="row mb-3">
																	<label for="incentive_type" class="col-md-4 col-form-label text-md-end">{{ __('Incentive Type') }}</label>

																	<div class="col-md-6">
																	
																	<input id="incentive_type" type="text" class="form-control @error('incentive_type') is-invalid @enderror" name="incentive_type" value="{{ old('incentive_type') }}"  autocomplete="incentive_type" autofocus>

																		@error('incentive_type')
																			<span class="invalid-feedback" role="alert">
																				<strong>{{ $message }}</strong>
																			</span>
																		@enderror
																	</div>
																</div>
																<div class="row mb-3">
																	<label for="contract_length" class="col-md-4 col-form-label text-md-end">{{ __('Contract Length') }}</label>

																	<div class="col-md-6">
																	
																	<input id="contract_length" type="text" class="form-control @error('contract_length') is-invalid @enderror" name="contract_length" value="{{ old('contract_length') }}"  autocomplete="contract_length" autofocus>

																		@error('contract_length')
																			<span class="invalid-feedback" role="alert">
																				<strong>{{ $message }}</strong>
																			</span>
																		@enderror
																	</div>
																</div>
																<div class="row mb-3">
																	<label for="vacation_month" class="col-md-4 col-form-label text-md-end">{{ __('Vacation Month') }}</label>

																	<div class="col-md-6">
																	
																	<input id="vacation_month" type="text" class="form-control @error('vacation_month') is-invalid @enderror" name="vacation_month" value="{{ old('vacation_month') }}"  autocomplete="vacation_month" autofocus>

																		@error('vacation_month')
																			<span class="invalid-feedback" role="alert">
																				<strong>{{ $message }}</strong>
																			</span>
																		@enderror
																	</div>
																</div>
																<div class="row mb-3">
																	<label for="status" class="col-md-4 col-form-label text-md-end">{{ __('Status') }}</label>

																	<div class="col-md-6">
																	
																	<input id="status" type="text" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') }}"  autocomplete="status" autofocus>

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
																	</div>  
																</div>
															</form>
										
														</div>
													</div>
												<div class="table-responsive">
													<table class="table table-striped">
													  <thead>
														<tr>
														<th>Department</th>
														<th>Posts</th>
														<th>Basic Wage</th>
														<th>Other Contractual</th>
														<th>Guaranteed Wage</th>
														<th>Service Charge</th>
														<th>Additional Bonus</th>
														<th>Bonus Level</th>
														<th>Bonus Personam</th>
														<th>Total Salary</th>
														<th>Incentive Type</th>
														<th>Contract Length</th>
														<th>Vacation Month</th>
														<th>Status</th>
														<th>Action</th>

														</tr>
													  </thead>
													  <tbody>
														@if(isset($company_salary_system) && !empty($company_salary_system))
														@foreach($company_salary_system as $item)
															<tr>
																<td>{{ \App\Models\Department::find($item->dep_id)->name }}</td>
																<td>{{ \App\Models\Posts::find($item->post_id)->name }}</td>
																<td>{{ $item->basic_wage }}</td>
																<td>{{ $item->other_contractual }}</td>
																<td>{{ $item->guaranteed_wage }}</td>
																<td>{{ $item->service_charge }}</td>
																<td>{{ $item->additional_bonus }}</td>
																<td>{{ $item->bonus_level }}</td>
																<td>{{ $item->bonus_personam }}</td>
																<td>{{ $item->total_salary }}</td>
																<td>{{ $item->incentive_type }}</td>
																<td>{{ $item->contract_length }}</td>
																<td>{{ $item->vacation_month }}</td>
																<td>{{ $item->status }}</td>				
																<td class="td-action-icons"> 
																<a href="{{ route('admin.company') }}/salary_system?id={{$item->id}}" class="btn-info h3"><i class="menu-icon mdi mdi-pencil"></i></a> 
																<span class="delete_record btn-danger h3" data-id="{{$item->id}}" data-action="{{ route('admin.company') }}/delete_salary"><i class="menu-icon mdi mdi-delete"></i></span>
																</td>
															</tr>
														@endforeach
													@endif
													  </tbody>
													</table>
													
											  </div>
										  
												  </div>
												</div>	
											</div>
										</div>
				  </div>
	

							</div>
							</div>
						</div>
                    
				</div>
			</div>
		</div>
	</div>
@endsection