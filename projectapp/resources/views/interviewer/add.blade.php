@extends('layouts.app')
@section('content')
   <div class="row justify-content-center">
      <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="template-demo">
                    <div class="btn-group">
                      <button type="button" class="btn btn-primary">Event Admin Settings</button>
                      <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuSplitButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton1">
                        <a class="dropdown-item" href="{{ route('admin.users') }}/event_admin/add">Add</a>
                        <a class="dropdown-item" href="{{ route('admin.users') }}/event_admin/">List</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
        </div>
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">Add Event Admin</div>

                <div class="card-body">
									@if(session()->has('success'))
									    <div class="alert alert-success">
									        {{ session()->get('success') }}
									    </div>
									@endif
                    <form method="POST" action="{{ route('admin.users') }}/event_admin/save">
                        @csrf

                        <div class="row mb-3">
                            <label for="firstname" class="col-md-4 col-form-label text-md-end">{{ __('FirstName') }}<span class="required_star">*</span></label>

                            <div class="col-md-6">
                                <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}" required autocomplete="firstname" autofocus>

                                @error('firstname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>   
						<div class="row mb-3">
                            <label for="lastname" class="col-md-4 col-form-label text-md-end">{{ __('LastName') }}<span class="required_star">*</span></label>

                            <div class="col-md-6">
                                <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname" autofocus>

                                @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
						
						<div class="row mb-3">
                            <label for="gender" class="col-md-4 col-form-label text-md-end">{{ __('Gender') }}<span class="required_star">*</span></label>

                            <div class="col-md-6 d-flex">
								<div class="custom-control custom-radio custom-control-inline px-2">
								  <input type="radio" id="genderm" name="gender" value="male" class="form-check-input @error('gender') is-invalid @enderror" required autocomplete="gender" checked>
								  <label class="custom-control-label" for="genderm">Male</label>
								</div>
								<div class="custom-control custom-radio custom-control-inline px-2">
								<input id="genderw" type="radio" class="form-check-input @error('gender') is-invalid @enderror" name="gender" value="female" required autocomplete="gender">
								  <label class="custom-control-label" for="genderw">Female</label>
								</div>
								<div class="custom-control custom-radio custom-control-inline px-2">
								 <input id="gendero" type="radio" class="form-check-input @error('gender') is-invalid @enderror" name="gender" value="others" required autocomplete="gender">

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
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}<span class="required_star">*</span></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}<span class="required_star">*</span></label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
						  <div class="row mb-3">
                            <label for="contactno" class="col-md-4 col-form-label text-md-end">{{ __('Contact') }}</label>

                            <div class="col-md-6">
                                <input id="contactno" type="text" class="form-control @error('contactno') is-invalid @enderror" name="contactno" value="{{ old('contactno') }}" autocomplete="contactno">

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
                                <input id="whatsapp" type="text" class="form-control @error('whatsapp') is-invalid @enderror" name="whatsapp" value="{{ old('whatsapp') }}" autocomplete="whatsapp">

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
                                <a href="{{ route('admin.users') }}/event_admin/" class="btn btn-secondary">
                                    Cancel
                                </a>
                            </div>  
                        </div>
                     
                    </form>
                </div>
            </div>
        </div>
    </div>                
@endsection
