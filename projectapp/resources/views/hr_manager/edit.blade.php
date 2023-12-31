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
<div class="cstm_hrmanager_admin_edit cstm_common_admin">
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
					<h5 class="page-edit-title">Edit User <span class="text-primary">#{{$user->name}}</span></h5>
					<nav>
					  <div class="nav nav-tabs" id="nav-tab" role="tablist">
						<button class="nav-link @if( $activeTab=='profile') active @endif" id="nav-upd_profile-tab" data-bs-toggle="tab" data-bs-target="#nav-upd_profile" type="button" role="tab" aria-controls="nav-upd_profile" @if( $activeTab=='profile') aria-selected="true" @else aria-selected="false" @endif>Update Profile</button>
						<button class="nav-link @if( $activeTab=='password') active @endif" id="nav-upd_passwrd-tab" data-bs-toggle="tab" data-bs-target="#nav-upd_passwrd" type="button" role="tab" aria-controls="nav-upd_passwrd" @if( $activeTab=='password') aria-selected="true" @else aria-selected="false" @endif>Update Password</button>
						
					  </div>
					</nav>
					<div class="tab-content" id="nav-tabContent">
					  <div class="tab-pane fade @if( $activeTab=='profile') show active @endif" id="nav-upd_profile" role="tabpanel" aria-labelledby="nav-home-tab">
							  <div class="card">
									<div class="card-header">Update Profile</div>

									<div class="card-body">
											
										<form method="POST" action="{{ route('admin.users') }}/hr_manager/update">
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
										<div class="row mb-0 submit_btn_row">
											<div class="col-md-12 d-flex">
												<button type="submit" class="btn btn-primary">
													Submit
												</button> 
												<a href="{{ route('admin.events') }}/edit?id={{$event->ev_id}}" class="btn btn-secondary">
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
											<form method="POST" action="{{ route('admin.users') }}/hr_manager/changepassword">
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
												<a href="{{ route('admin.events') }}/edit?id={{$event->ev_id}}" class="btn btn-secondary">
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
</div>
@endsection
