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
<div class="cstm_company_editblade cstm_common_admin">
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
                                                <label for="post_id" class="col-md-4 col-form-label text-md-end">{{ __('Job Position / Job Title') }}</label>
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
											<?php
											/*
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
											 
											 */
											 
											 ?>
                                             <div class="row mb-3">
                                                <label for="total_salary" class="col-md-4 col-form-label text-md-end">{{ __('Total Salary') }}</label>
                                                <div class="col-md-6">
                                                   <input id="total_salary" type="text" class="form-control @error('total_salary') is-invalid @enderror" name="total_salary" value="{{ old('total_salary') }}" placeholder="1000.00"  autocomplete="total_salary" autofocus>
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
                                                   <input id="min_eng" type="text" class="form-control @error('min_eng') is-invalid @enderror" name="min_eng" value="{{ old('min_eng') }}"  autocomplete="min_eng" autofocus>
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
                                                   <input id="contract_length" type="text" class="form-control @error('contract_length') is-invalid @enderror" name="contract_length" value="{{ old('contract_length') }}"  autocomplete="contract_length" autofocus>
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
                                                   <input id="contract_length_loi" type="text" class="form-control @error('contract_length_loi') is-invalid @enderror" name="contract_length_loi" value="{{ old('contract_length_loi') }}"  autocomplete="contract_length_loi" autofocus>
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
                                                   <input id="vacation_month" type="text" class="form-control @error('vacation_month') is-invalid @enderror" name="vacation_month" value="{{ old('vacation_month') }}"  autocomplete="vacation_month" autofocus>
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
                                                   <input id="start_up" type="text" class="form-control @error('start_up') is-invalid @enderror" name="start_up" value="{{ old('start_up') }}"  autocomplete="start_up" autofocus>
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
                                                   <input id="first_reliever" type="text" class="form-control @error('first_reliever') is-invalid @enderror" name="first_reliever" value="{{ old('first_reliever') }}"  autocomplete="first_reliever" autofocus>
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
                                                   <input id="contract_currency" type="text" class="form-control @error('contract_currency') is-invalid @enderror" name="contract_currency" value="{{ old('contract_currency') }}"  autocomplete="contract_currency" autofocus>
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
                                                   <input id="seniority" type="text" class="form-control @error('seniority') is-invalid @enderror" name="seniority" value="{{ old('seniority') }}"  autocomplete="seniority" autofocus>
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
                                                   <input id="level_additional_comp" type="text" class="form-control @error('level_additional_comp') is-invalid @enderror" name="level_additional_comp" value="{{ old('level_additional_comp') }}"  autocomplete="level_additional_comp" autofocus>
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
                                                   <input id="seniority_range" type="text" class="form-control @error('seniority_range') is-invalid @enderror" name="seniority_range" value="{{ old('seniority_range') }}"  autocomplete="seniority_range" autofocus>
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
                                                </div>
                                             </div>
                                          </form>
                                       </div>
                                    </div>
									@if($company->id==26)
										
						
                                    <div class="table-responsive">
                                       <table class="table table-striped company_salary_list">
                                          <thead>
                                             <tr>
                                                <th>Department</th>
                                                <th>Job Title</th>
                                                <th>Position Code</th>
                                              
                                                <th>Contract Length LOI</th>
                                                <th>Total Salary</th>
                                                <th>Min Eng</th>
                                                <th>Contract Length</th>
                                                <th>Vacation Month</th>
                                                <th>Start-up</th>
                                                <th>First Reliever</th>
                                                <th>Action</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             @if(isset($company_salary_system) && !empty($company_salary_system))
                                             @foreach($company_salary_system as $item)
                                             <tr>
                                                <td>{{ \App\Models\Department::find($item->dep_id)->name }}</td>
												<?php $postInfo=\App\Models\Posts::find($item->post_id);  ?>
                                                <td>{{ $postInfo->name }}</td>
                                                <td>{{ $postInfo->rank }}</td>
                                               
                                                <td>{{ $item->contract_length_loi }}</td>
                                                <td>{{ convertPriceToNumber($item->total_salary) }}</td>
                                                <td>{{ $item->min_eng }}</td>
                                                <td>{{ $item->contract_length }}</td>
                                                <td>{{ $item->vacation_month }}</td>
                                                <td>{{ $item->start_up	 }}</td>
                                                <td>{{ $item->first_reliever }}</td>
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
                                   @else 
								
									<div class="table-responsive">
                                       <table class="table table-striped company_salary_list">
                                          <thead>
                                             <tr>
                                                <th>Department</th>
                                                <th>Posts</th>
                                                <th>Rank</th>
                                                <th>Rank Position</th>
                                                <th>Contract Currency</th>
                                                <th>Seniority</th>
                                                <th>Level Additional Comp</th>
                                                <th>Seniority Range</th>
                                                <th>Total Salary</th>
                                                <th>Action</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             @if(isset($company_salary_system) && !empty($company_salary_system))
                                             @foreach($company_salary_system as $item)
                                             <tr>
                                                <td>{{ \App\Models\Department::find($item->dep_id)->name }}</td>
												<?php $postInfo=\App\Models\Posts::find($item->post_id);  ?>
                                                <td>{{ $postInfo->name }}</td>
                                                <td>{{ $postInfo->rank }}</td>
                                                <td>{{ $postInfo->rank_position }}</td>
                                               
                                                <td>{{ $item->contract_currency }}</td>
                                                <td>{{ $item->seniority }}</td>
                                                <td>{{ $item->level_additional_comp }}</td>
                                                <td>{{ $item->seniority_range }}</td>
                                                <td>{{ convertPriceToNumber($item->total_salary) }}</td>
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
								   @endif
								 
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
</div>