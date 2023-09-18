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
<div class="cstm_salary_sysytem cstm_common_admin">
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
                                                <label for="post_id" class="col-md-4 col-form-label text-md-end">{{ __('Job Position / Job Title') }}</label>

												<div class="col-md-6">
												<select class="form-control post_options" name="post_id">
												<option value="">Choose any one option</option>
												@if(!empty($posts))
														@foreach($posts as $post)
															<option value="{{ $post->id }}" @if($company_salary_system->post_id == $post->id) selected @endif>
															{{$post->name}}
															@if(!empty($post->rank))
																- {{$post->rank}}
															@endif
															@if(!empty($post->rank_position))
																- {{$post->rank_position}}
															@endif
															</option>
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
												<label for="total_salary" class="col-md-4 col-form-label text-md-end">{{ __('Total Salary') }}</label>

												<div class="col-md-6">
												
												<input id="total_salary" type="text" class="form-control @error('total_salary') is-invalid @enderror" name="total_salary"   value="@if(isset($company_salary_system)){{ $company_salary_system->total_salary }}@else{{ old('total_salary') }}@endif"   placeholder="1000.00"   autocomplete="total_salary" autofocus>

													@error('total_salary')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div>
											<div class="row mb-3">
                                                <label for="min_eng" class="col-md-4 col-form-label text-md-end">{{ __('Min_eng') }}</label>
                                                <div class="col-md-6">
                                                   <input id="min_eng" type="text" class="form-control @error('min_eng') is-invalid @enderror" name="min_eng" value="@if(isset($company_salary_system)){{ $company_salary_system->min_eng }}@else{{ old('min_eng') }}@endif"  autocomplete="min_eng" autofocus>
                                                   @error('min_eng')
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
                                                <label for="contract_length_loi" class="col-md-4 col-form-label text-md-end">{{ __('Contract Length (LOI)') }}</label>
                                                <div class="col-md-6">
                                                   <input id="contract_length_loi" type="text" class="form-control @error('contract_length_loi') is-invalid @enderror" name="contract_length_loi" value="@if(isset($company_salary_system)){{ $company_salary_system->contract_length_loi }}@else{{ old('contract_length_loi') }}@endif"  autocomplete="contract_length_loi" autofocus>
                                                   @error('contract_length_loi')
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
                                                <label for="start_up" class="col-md-4 col-form-label text-md-end">{{ __('Start-up') }}</label>
                                                <div class="col-md-6">
                                                   <input id="start_up" type="text" class="form-control @error('start_up') is-invalid @enderror" name="start_up" value="@if(isset($company_salary_system)){{ $company_salary_system->start_up }}@else{{ old('start_up') }}@endif"  autocomplete="start_up" autofocus>
                                                   @error('start_up')
                                                   <span class="invalid-feedback" role="alert">
                                                   <strong>{{ $message }}</strong>
                                                   </span>
                                                   @enderror
                                                </div>
                                             </div>
                                             <div class="row mb-3">
                                                <label for="first_reliever" class="col-md-4 col-form-label text-md-end">{{ __('First Reliever') }}</label>
                                                <div class="col-md-6">
                                                   <input id="first_reliever" type="text" class="form-control @error('first_reliever') is-invalid @enderror" name="first_reliever" value="@if(isset($company_salary_system)){{ $company_salary_system->first_reliever }}@else{{ old('first_reliever') }}@endif"  autocomplete="first_reliever" autofocus>
                                                   @error('first_reliever')
                                                   <span class="invalid-feedback" role="alert">
                                                   <strong>{{ $message }}</strong>
                                                   </span>
                                                   @enderror
                                                </div>
                                             </div>
											 <div class="row mb-3">
                                                <label for="contract_currency" class="col-md-4 col-form-label text-md-end">{{ __('Contract Currency') }}</label>
                                                <div class="col-md-6">
                                                   <input id="contract_currency" type="text" class="form-control @error('contract_currency') is-invalid @enderror" name="contract_currency" value="@if(isset($company_salary_system)){{ $company_salary_system->contract_currency }}@else{{ old('contract_currency') }}@endif"  autocomplete="contract_currency" autofocus>
                                                   @error('contract_currency')
                                                   <span class="invalid-feedback" role="alert">
                                                   <strong>{{ $message }}</strong>
                                                   </span>
                                                   @enderror
                                                </div>
                                             </div>
                                             <div class="row mb-3">
                                                <label for="seniority" class="col-md-4 col-form-label text-md-end">{{ __('Seniority') }}</label>
                                                <div class="col-md-6">
                                                   <input id="seniority" type="text" class="form-control @error('seniority') is-invalid @enderror" name="seniority" value="@if(isset($company_salary_system)){{ $company_salary_system->seniority }}@else{{ old('seniority') }}@endif"  autocomplete="seniority" autofocus>
                                                   @error('seniority')
                                                   <span class="invalid-feedback" role="alert">
                                                   <strong>{{ $message }}</strong>
                                                   </span>
                                                   @enderror
                                                </div>
                                             </div>
                                           <div class="row mb-3">
                                                <label for="level_additional_comp" class="col-md-4 col-form-label text-md-end">{{ __('Level of Additional Comp') }}</label>
                                                <div class="col-md-6">
                                                   <input id="level_additional_comp" type="text" class="form-control @error('level_additional_comp') is-invalid @enderror" name="level_additional_comp" value="@if(isset($company_salary_system)){{ $company_salary_system->level_additional_comp }}@else{{ old('level_additional_comp') }}@endif"  autocomplete="level_additional_comp" autofocus>
                                                   @error('level_additional_comp')
                                                   <span class="invalid-feedback" role="alert">
                                                   <strong>{{ $message }}</strong>
                                                   </span>
                                                   @enderror
                                                </div>
                                             </div>
                                           <div class="row mb-3">
                                                <label for="seniority_range" class="col-md-4 col-form-label text-md-end">{{ __('Seniority Range') }}</label>
                                                <div class="col-md-6">
                                                   <input id="seniority_range" type="text" class="form-control @error('seniority_range') is-invalid @enderror" name="seniority_range" value="@if(isset($company_salary_system)){{ $company_salary_system->seniority_range }}@else{{ old('seniority_range') }}@endif"  autocomplete="seniority_range" autofocus>
                                                   @error('seniority_range')
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
</div>