@extends('layouts.app')
@section('content') 
<script src="https://cdn.tiny.cloud/1/0g9zrhnit6qjem3iiq3ygq0lhtj0dc93c1ts8gncj6p3887k/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
   tinymce.init({
     selector: 'textarea#loi_input', // Replace this CSS selector to match the placeholder element for TinyMCE
     plugins: 'powerpaste advcode table lists checklist',
     toolbar: 'undo redo | blocks| bold italic | bullist numlist checklist | code | table'
   });
</script>
<div class="row justify-content-center">
		 <div class="col-12 grid-margin stretch-card">
		   <div class="card">
                <div class="card-header">Update Salary System</div>

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
								 <form method="POST" action="{{route('admin.company',['param'=>'save_salary'])}}" >
											@csrf
											 <input type="hidden" name="company_id" value="{{ $company_salary_system->company_id }}"> 
											 <input type="hidden" name="id" value="{{ $company_salary_system->id }}"> 
										  
											<div class="row mb-3">
												<label for="dep_id" class="col-md-4 col-form-label text-md-end">{{ __('Department') }}</label>

												<div class="col-md-6">
												<select class="form-control department_options" data-action="{{route('admin.company',['param'=>'getPost'])}}"  name="dep_id">
													@if(!empty($departments))
														@foreach($departments as $department)
															<option value="{{ $department->id }}" @if($company_salary_system->dep_id == $department->id) selected @endif>{{$department->name}}</option>
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
												<option value="">Choose any one option</option>
												@if(!empty($posts))
														@foreach($posts as $post)
															<option value="{{ $post->id }}" @if($company_salary_system->post_id == $post->id) selected @endif>{{$post->name}}</option>
														@endforeach
													@endif
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
												
												<input id="basic_wage" type="text" class="form-control @error('basic_wage') is-invalid @enderror" name="basic_wage"  value="@if(isset($company_salary_system)){{ $company_salary_system->basic_wage }}@else{{ old('basic_wage') }}@endif" autocomplete="basic_wage" autofocus>

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
												
												<input id="other_contractual" type="text" class="form-control @error('other_contractual') is-invalid @enderror" name="other_contractual"  value="@if(isset($company_salary_system)){{ $company_salary_system->other_contractual }}@else{{ old('other_contractual') }}@endif"  autocomplete="other_contractual" autofocus>

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
												
												<input id="guaranteed_wage" type="text" class="form-control @error('guaranteed_wage') is-invalid @enderror" name="guaranteed_wage"   value="@if(isset($company_salary_system)){{ $company_salary_system->guaranteed_wage }}@else{{ old('guaranteed_wage') }}@endif"  autocomplete="guaranteed_wage" autofocus>

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
												
												<input id="service_charge" type="text" class="form-control @error('service_charge') is-invalid @enderror" name="service_charge"   value="@if(isset($company_salary_system)){{ $company_salary_system->service_charge }}@else{{ old('service_charge') }}@endif"  autocomplete="service_charge" autofocus>

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
												
												<input id="additional_bonus" type="text" class="form-control @error('additional_bonus') is-invalid @enderror" name="additional_bonus"   value="@if(isset($company_salary_system)){{ $company_salary_system->additional_bonus }}@else{{ old('additional_bonus') }}@endif"  autocomplete="additional_bonus" autofocus>

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
												
												<input id="bonus_level" type="text" class="form-control @error('bonus_level') is-invalid @enderror" name="bonus_level"   value="@if(isset($company_salary_system)){{ $company_salary_system->bonus_level }}@else{{ old('bonus_level') }}@endif"   autocomplete="bonus_level" autofocus>

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
												
												<input id="bonus_personam" type="text" class="form-control @error('bonus_personam') is-invalid @enderror" name="bonus_personam"   value="@if(isset($company_salary_system)){{ $company_salary_system->bonus_personam }}@else{{ old('bonus_personam') }}@endif"   autocomplete="bonus_personam" autofocus>

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
												
												<input id="total_salary" type="text" class="form-control @error('total_salary') is-invalid @enderror" name="total_salary"   value="@if(isset($company_salary_system)){{ $company_salary_system->total_salary }}@else{{ old('total_salary') }}@endif"   autocomplete="total_salary" autofocus>

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
												
												<input id="incentive_type" type="text" class="form-control @error('incentive_type') is-invalid @enderror" name="incentive_type"   value="@if(isset($company_salary_system)){{ $company_salary_system->incentive_type }}@else{{ old('incentive_type') }}@endif"   autocomplete="incentive_type" autofocus>

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
												
												<input id="contract_length" type="text" class="form-control @error('contract_length') is-invalid @enderror" name="contract_length"   value="@if(isset($company_salary_system)){{ $company_salary_system->contract_length }}@else{{ old('contract_length') }}@endif"   autocomplete="contract_length" autofocus>

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
												
												<input id="vacation_month" type="text" class="form-control @error('vacation_month') is-invalid @enderror" name="vacation_month"   value="@if(isset($company_salary_system)){{ $company_salary_system->vacation_month }}@else{{ old('vacation_month') }}@endif"   autocomplete="vacation_month" autofocus>

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
												
												<input id="status" type="text" class="form-control @error('status') is-invalid @enderror" name="status"   value="@if(isset($company_salary_system)){{ $company_salary_system->status }}@else{{ old('status') }}@endif"   autocomplete="status" autofocus>

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
													<a href="{{ route('admin.company') }}/edit?id={{$company_salary_system->company_id}}" class="btn btn-secondary">
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
@endsection