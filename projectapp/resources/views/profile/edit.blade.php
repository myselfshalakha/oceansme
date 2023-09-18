@extends('layouts.app')

@section('content')
<?php
$tabArr=["profile","password","profileImage","bio"];
$activeTab="profile";
if(session()->has('activeTab')){
	 $activeTab=session()->get('activeTab');
}
$errorsArr = session('errors');
if ($errorsArr) {
    $fields_tabs = [
        ['firstname', 'lastname', 'gender', 'contactno'], 
        ['password'], 
        ['profileimage'], 
        ['resume'], 
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
<div class="cstm_profile_admin_edit cstm_common_admin">
	<div class="container">
	 @if(Auth::user()->hasRole('candidate'))
		  <div class="row">
			  <div class="col-lg-12 d-flex flex-column">
					<div class="card">
					   <div class="card-body">
					   
						<div class="row">
						  <div class="col-sm-12">
							 <div class="accordion" id="accordionExample">
							  <h2 class="profile__percentage">
								  Profile Completion Status: 
								   @if(isset($profilestatus))
							   <span class="@if($profilestatus>='80') text-success @elseif($profilestatus>='50') text-warning @elseif($profilestatus>='30') text-info @elseif($profilestatus>='0') text-danger @endif">
							   {{round($profilestatus)}}%
							   </span>
							   @endif
								   <p class="card-description">To apply any event, you need to make sure that your profile completion percentage is 100% <a href="javascript:void(0)" class="collapsed"   type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Click here to see how it works</a></p>
							  </h2>
								<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
									<div id="chartContainer" style="min-height: 350px;width: 100%;"></div>
								</div>
							</div>
					 
						  </div>
						</div>
					  </div>
					</div>
			  </div>
		   </div>
		@endif
		   
		<div class="row">
			<div class="col-md-12 header_response_messege">
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
					<nav>
					  <div class="nav nav-tabs" id="nav-tab" role="tablist">
						<button class="nav-link @if( $activeTab=='profile') active @endif" id="nav-upd_profile-tab" data-bs-toggle="tab" data-bs-target="#nav-upd_profile" type="button" role="tab" aria-controls="nav-upd_profile" @if( $activeTab=='profile') aria-selected="true" @else aria-selected="false" @endif>Update Profile</button>
						<button class="nav-link @if( $activeTab=='password') active @endif" id="nav-upd_passwrd-tab" data-bs-toggle="tab" data-bs-target="#nav-upd_passwrd" type="button" role="tab" aria-controls="nav-upd_passwrd" @if( $activeTab=='password') aria-selected="true" @else aria-selected="false" @endif>Update Password</button>
						<button class="nav-link @if( $activeTab=='profileImage') active @endif" id="nav-upd_prf_image-tab" data-bs-toggle="tab" data-bs-target="#nav-upd_prf_image" type="button" role="tab" aria-controls="nav-upd_prf_image" @if( $activeTab=='profileImage') aria-selected="true" @else aria-selected="false" @endif>Update Profile Image</button>
						@if(Auth::user()->hasRole('candidate'))
						<button class="nav-link @if( $activeTab=='bio') active @endif" id="nav-upd_prf_bio-tab" data-bs-toggle="tab" data-bs-target="#nav-upd_prf_bio" type="button" role="tab" aria-controls="nav-upd_prf_bio"  @if( $activeTab=='bio') aria-selected="true" @else aria-selected="false" @endif>Update Bio</button>
						@endif
					 </div>
					</nav>
					<div class="tab-content" id="nav-tabContent">
					  <div class="tab-pane fade @if( $activeTab=='profile') show active @endif" id="nav-upd_profile" role="tabpanel" aria-labelledby="nav-home-tab">
							  <div class="card">
									<div class="card-header">Update Profile</div>

									<div class="card-body">
											
											<form action="{{route('admin.profile',['param'=>'update'])}}" method="post">
											@csrf
														 <input type="hidden" name="id" value="{{ $user->id }}">
											<div class="row mb-3">
												<label for="firstname" class="col-md-4 col-form-label text-md-end">{{ __('FirstName') }}</label>

												<div class="col-md-6">
													<input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{$user->firstname}}" required autocomplete="firstname" autofocus>

													@error('firstname')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div>   
											<div class="row mb-3">
												<label for="lastname" class="col-md-4 col-form-label text-md-end">{{ __('LastName') }}</label>

												<div class="col-md-6">
													<input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{$user->lastname}}" required autocomplete="lastname" autofocus>

													@error('lastname')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div>
											
											<div class="row mb-3">
												<label for="gender" class="col-md-4 col-form-label text-md-end">{{ __('Gender') }}</label>

												<div class="col-md-6 d-flex">
													<div class="custom-control custom-radio custom-control-inline px-2">
													  <input type="radio" id="genderm" name="gender" value="male" class="form-check-input @error('gender') is-invalid @enderror" required autocomplete="gender" @if($user->gender=="male") checked @endif>
													  <label class="custom-control-label" for="genderm">Male</label>
													</div>
													<div class="custom-control custom-radio custom-control-inline px-2">
													<input id="genderw" type="radio" class="form-check-input @error('gender') is-invalid @enderror" name="gender" value="female" required autocomplete="gender"  @if($user->gender=="female") checked @endif>
													  <label class="custom-control-label" for="genderw">Female</label>
													</div>
													<div class="custom-control custom-radio custom-control-inline px-2">
													 <input id="gendero" type="radio" class="form-check-input @error('gender') is-invalid @enderror" name="gender" value="others" required autocomplete="gender"  @if($user->gender=="others") checked @endif>

													  <label class="custom-control-label" for="gendero">OTHERS</label>
													</div>

													@error('gender')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div>
											<div class="row mb-3">
												<label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

												<div class="col-md-6">
													<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" readonly>

												</div>
											</div>

											
											  <div class="row mb-3">
												<label for="contactno" class="col-md-4 col-form-label text-md-end">{{ __('Contact') }}</label>

												<div class="col-md-6">
													<input id="contactno" type="text" class="form-control @error('contactno') is-invalid @enderror" name="contactno" value="{{ $user->contactno }}" autocomplete="contactno">

													@error('contactno')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div>  
											<div class="row mb-3" style="display:none">
												<label for="whatsapp" class="col-md-4 col-form-label text-md-end">{{ __('Whatsapp') }}</label>

												<div class="col-md-6">
													<input id="whatsapp" type="text" class="form-control @error('whatsapp') is-invalid @enderror" name="whatsapp" value="{{ $user->whatsapp }}" autocomplete="whatsapp">

													@error('whatsapp')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div>
											<!--div class="row mb-3">
												<label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

												<div class="col-md-6">
													<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
												</div>
											</div-->
										<div class="row mb-0 submit_btn_row">
											<div class="col-md-12 d-flex">
												<button type="submit" class="btn btn-primary">
													Submit
												</button> 
												<a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
													Cancel
												</a>
											</div>  
										</div>
											
										</form>
									</div>
								</div>
						  
					  </div>
					  <div class="tab-pane fade @if( $activeTab=='password') show active @endif" id="nav-upd_passwrd" role="tabpanel" aria-labelledby="nav-profile-tab">
											<div class="card">
									<div class="card-header">Update Password</div>

									<div class="card-body">
											<form action="{{route('admin.profile',['param'=>'changepassword'])}}" method="post">
											@csrf
														 <input type="hidden" name="id" value="{{ $user->id }}">
											<div class="row mb-3">
												<label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

												<div class="col-md-6">
													<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

													@error('password')
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
												<a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
													Cancel
												</a>
											</div>  
										</div>
										</form>
									</div>
								</div>
						   
					  </div>
					  <div class="tab-pane fade @if( $activeTab=='profileImage') show active @endif" id="nav-upd_prf_image" role="tabpanel" aria-labelledby="nav-contact-tab">
							  <div class="card">
									<div class="card-header">Update Profile Image</div>

									<div class="card-body">
											<form action="{{route('admin.profile',['param'=>'changeprofileimage'])}}" method="post"  enctype="multipart/form-data">
											@csrf
														 <input type="hidden" name="id" value="{{ $user->id }}">
											<div class="row mb-3 justify-content-center">

												
												<div class="col-md-6">
													<div class="prf__image">
													 @if(!empty($user->profileimage))
														<img src="{{ url('/') }}/assets/images/userprofile/{{$user->profileimage}}" class="profileimage">
													@else 
														<img src="{{ url('/') }}/assets/images/user-image.png"  class="profileimage">
													@endif
													</div>
												   <input type="file" class="form-control @error('profileimage') is-invalid @enderror" name="profileimage" id="profileimage">
												</div>
											</div>
											
												<div class="row mb-0 submit_btn_row">
											<div class="col-md-12 d-flex">
												<button type="submit" class="btn btn-primary">
													Submit
												</button> 
												<a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
													Cancel
												</a>
											</div>  
										</div>
										</form>
									</div>
								</div>
					  </div>
					  
	  
		  
					 @if(Auth::user()->hasRole('candidate'))
						<div class="tab-pane fade  @if( $activeTab=='bio') show active @endif" id="nav-upd_prf_bio" role="tabpanel" aria-labelledby="nav-bio-tab">
							  <div class="card">
									<div class="card-header">Update Bio</div>

									<div class="card-body">
											
											<form action="{{route('admin.profile',['param'=>'bioupdate'])}}" method="post"   enctype="multipart/form-data">
											@csrf
														 <input type="hidden" name="id" value="{{ $user->id }}">
																		
											<div class="row mb-3">
												<label for="address" class="col-md-4 col-form-label text-md-end">{{ __('Address') }}</label>

												<div class="col-md-6">
													<textarea id="address" rows="8" class="form-control @error('address') is-invalid @enderror" name="address" >{{$user_bios[0]->address}}</textarea>

													@error('address')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div>
											<div class="row mb-3">
												<label for="second_address" class="col-md-4 col-form-label text-md-end">{{ __('Secondary Address') }}</label>

												<div class="col-md-6">
													<textarea id="second_address" rows="8" class="form-control @error('second_address') is-invalid @enderror" name="second_address" >{{$user_bios[0]->second_address}}</textarea>

													@error('second_address')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div>
											<div class="row mb-3">
												<label for="country" class="col-md-4 col-form-label text-md-end">Country of Residence</label>

												<div class="col-md-6">
												<select class="form-control" name="country">
													<option value="">Choose any one option</option>
														@if(!empty($countries))
															@foreach($countries as $country)
																<option @if( $user_bios[0]->country == $country->id) selected  @endif value="{{ $country->id }}">{{$country->name}}</option>
															@endforeach
															<option value="other" @if($user_bios[0]->country == "other") selected @endif>Other</option>
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
												<label for="nationality" class="col-md-4 col-form-label text-md-end">{{ __('Nationality') }}</label>

												<div class="col-md-6">
												<select class="form-control" name="nationality">
													<option value="">Choose any one option</option>
														@if(!empty($countries))
															@foreach($countries as $country)
																<option @if( $user_bios[0]->nationality == $country->id) selected  @endif value="{{ $country->id }}">{{$country->name}}</option>
															@endforeach
															<option value="other" @if($user_bios[0]->nationality == "other") selected @endif>Other</option>
														@endif
												</select>
													@error('nationality')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div>
										
											<div class="row mb-3">
												<label for="birthdate" class="col-md-4 col-form-label text-md-end">{{ __('Date of Birth') }}</label>
												<div class="col-md-6">
													<input id="birthdate" type="text" class="form-control @error('birthdate') is-invalid @enderror" name="birthdate" value="@if(!empty($user_bios[0]->birthdate)){{date('m/d/Y',strtotime($user_bios[0]->birthdate)) }}@endif"  autocomplete="off">

													@error('birthdate')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div>
											<div class="row mb-3">
												<label for="position" class="col-md-4 col-form-label text-md-end">{{ __('Current Position') }}</label>

												<div class="col-md-6">
													<input id="position" type="text" class="form-control @error('position') is-invalid @enderror" name="position" value="{{$user_bios[0]->position}}" >

													@error('position')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div>	
											<div class="row mb-3">
												<label for="experience" class="col-md-4 col-form-label text-md-end">{{ __('Experience') }}</label>

												<div class="col-md-6">
													<div class="row experience_field">
														<div class="col-6">
														<label for="exp_years" class="text-sm-left">{{ __('Years') }}</label>
															<input id="exp_years" type="number"  placeholder="Years" class="form-control @error('exp_years') is-invalid @enderror" name="exp_years" value="{{$user_bios[0]->exp_years}}" >
															
														</div>
														@error('exp_years')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
														@enderror
														<div class="col-6">
															<label for="exp_months" class="text-sm-left">{{ __('Months') }}</label>
															<select id="exp_months" class="form-control @error('exp_months') is-invalid @enderror" name="exp_months">
															@for($i=0;$i<12;$i++)
																<option value="{{$i}}" @if($user_bios[0]->exp_months == $i) selected @endif >{{$i}}</option>
															@endfor
															</select>
														</div>
														@error('exp_months')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror
													</div>
													
													
												</div>
											</div>
											<div class="row mb-3">
												<label for="qualification" class="col-md-4 col-form-label text-md-end">{{ __('Qualifications') }}</label>

												<div class="col-md-6">
													<input id="qualification" type="text" class="form-control @error('qualification') is-invalid @enderror" name="qualification" value="{{$user_bios[0]->qualification}}" >

													@error('qualification')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div>
											<div class="row mb-3">
												<label for="languages" class="col-md-4 col-form-label text-md-end">{{ __('Languages') }}</label>

												<div class="col-md-6">
												<select id="languages" class="form-control @error('languages') is-invalid @enderror" name="languages[]" multiple>
													
													<?php
													$postname=array();
													if(!empty($user_bios[0]->languages)){
														$languages= unserialize($user_bios[0]->languages);
														foreach ($languages as $language){
															?>
															<option value="{{$language}}" selected>{{$language}}</option>
															<?php
														}
													}
													?>
												</select>
													@error('languages')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div>
											<div class="row mb-3">
												<label for="skills" class="col-md-4 col-form-label text-md-end">{{ __('Skills') }}</label>

												<div class="col-md-6">
												<select id="skills" class="form-control @error('skills') is-invalid @enderror" name="skills[]" multiple>
													
													<?php
													$postname=array();
													if(!empty($user_bios[0]->skills)){
														$skills= unserialize($user_bios[0]->skills);
														foreach ($skills as $skill){
															?>
															<option value="{{$skill}}" selected>{{$skill}}</option>
															<?php
														}
													}
													?>
												</select>

													@error('skills')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div>
											<div class="row mb-3">
												<label for="hobbies" class="col-md-4 col-form-label text-md-end">{{ __('Hobbies') }}</label>

												<div class="col-md-6">
												<select id="hobbies" class="form-control @error('hobbies') is-invalid @enderror" name="hobbies[]" multiple>
														<?php
													$postname=array();
													if(!empty($user_bios[0]->hobbies)){
														$hobbies= unserialize($user_bios[0]->hobbies);
														foreach ($hobbies as $hobby){
															?>
															<option value="{{$hobby}}" selected>{{$hobby}}</option>
															<?php
														}
													}
													?>
												</select>
													@error('hobbies')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div> 
											<div class="row mb-3">
												<label for="passport" class="col-md-4 col-form-label text-md-end">{{ __('Passport Number') }}</label>

												<div class="col-md-6">
												<input id="passport" type="text" class="form-control @error('passport') is-invalid @enderror" name="passport" value="{{$user_bios[0]->passport}}">

												@error('passport')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
													
												</div>
											</div>											
											<div class="row mb-3">
												<label for="visaStatus" class="col-md-4 col-form-label text-md-end">{{ __('Current Visa Status') }}</label>

												<div class="col-md-6">
												<select id="visaStatus" class="form-control @error('visaStatus') is-invalid @enderror" name="visaStatus">
													<option value="">Choose any one option</option>
													<?php
													$visaStatus=get_visa_Status();
														foreach ($visaStatus as $k=>$v){
															?>
															<option value="{{$k}}" @if($user_bios[0]->visaStatus == $k) selected @endif>{{$v}}</option>
															<?php
														}
													?>
												</select>
													@error('visaStatus')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
											</div>	
																				
											<div class="row mb-3">
												<label for="resume" class="col-md-4 col-form-label text-md-end">Resume</label>
												<div class="col-md-6">
												 @if(!empty($user_bios[0]->resume))
																
														<img src="{{ url('/') }}/assets/images/cvfile.png"  class="frm-img frm-logo-img">
													<a href="{{ url('/') }}/assets/files/user/resume/{{$user_bios[0]->resume}}" class="text-primary resume__link" download>Download</a>
														@else 
													<img src="{{ url('/') }}/assets/images/cvfile.png"  class="frm-img frm-logo-img"> 
														@endif
												<input type="file" name="resume" id="resume" class="form-control">

												</div>
											</div>
										<div class="row mb-0 submit_btn_row">
											<div class="col-md-12 d-flex">
												<button type="submit" class="btn btn-primary">
													Submit
												</button> 
												<a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
													Cancel
												</a>
											</div>  
										</div>
											
										</form>
									</div>
								</div>
						  
					  </div>
					@endif
					
					</div>
				</div>
	   </div>
	</div>
</div>
@endsection
