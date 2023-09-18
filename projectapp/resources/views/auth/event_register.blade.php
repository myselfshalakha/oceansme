@extends('layouts.loginapp')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        <div class="form-content">
            <div class="card-cm">
                <div class="card-header-cm">{{ __('Register') }}</div>
				<div class="head-div">
				<p class="heading">Register here to be part of an exclusive Explora Journeys Career Day Event.</p>
				<div class="center">
					<p>Already Registered for this event? <a href="{{ route('login') }}">Sign In</a></p>
				</div>
				<div class="small-heading">
					<p>Please complete all fields to register your interest and availability.We look forward to meet with as many of you as possible.</p>
				</div>
				</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('candidate.register') }}">
                        @csrf
						@if(isset($event)) <input type="hidden" name="eventid" value="{{ $event->id }}"> @endif
                        <div class="row mb-3">
							<div class="icon-box-cm">
								<img src="{{ asset('/assets/images/login/users.png') }}">
							</div>
							<div class="form-group-cm">
								<label for="firstname" class="col-form-label text-md-end">{{ __('FirstName') }}</label>

								<div class="input-box">
									<input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}" required autocomplete="firstname" autofocus>

									@error('firstname')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>
							<div class="form-group-cm">
								<label for="lastname" class="col-form-label text-md-end">{{ __('LastName') }}</label>

								<div class="input-box">
									<input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname" autofocus>

									@error('lastname')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>
                        </div>   
								
						
						<div class="row mb-3">
							<div class="icon-box-cm">
								<img src="{{ asset('/assets/images/login/gender.png') }}">
							</div>
							<div class="form-group-custom form-group-row">
								<label for="gender" class="col-form-label text-md-end">{{ __('Gender') }}</label>

								<div class="input-box">
									<div class="custom-control custom-radio custom-control-inline">
									  <input type="radio" id="genderm" name="gender" value="male" class="form-check-input @error('gender') is-invalid @enderror" required autocomplete="gender" checked>
									  <label class="custom-control-label" for="genderm">Male</label>
									</div>
									<div class="custom-control custom-radio custom-control-inline">
									<input id="genderw" type="radio" class="form-check-input @error('gender') is-invalid @enderror" name="gender" value="female" required autocomplete="gender">
									  <label class="custom-control-label" for="genderw">Female</label>
									</div>
									<div class="custom-control custom-radio custom-control-inline">
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
                        </div>
                        <div class="row mb-3">
							<div class="icon-box-cm">
								<img src="{{ asset('/assets/images/login/email.png') }}">
							</div>
							<div class="form-group-custom">
								<label for="email" class="col-form-label text-md-end">{{ __('Email Address') }}</label>

								<div class="input-box">
									<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

									@error('email')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>
                        </div>

                        <div class="row mb-3">
							<div class="icon-box-cm">
								<img src="{{ asset('/assets/images/login/password.png') }}">
							</div>
							<div class="form-group-custom">
								<label for="password" class="col-form-label text-md-end">{{ __('Password') }}</label>

								<div class="input-box">
									<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

									@error('password')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>
                        </div>
						  <div class="row mb-3">
							<div class="icon-box-cm">
								<img src="{{ asset('/assets/images/login/contact.png') }}">
							</div>
							<div class="form-group-custom">
								<label for="contactno" class="col-form-label text-md-end">{{ __('Contact') }}</label>

								<div class="input-box">
									<input id="contactno" type="text" class="form-control @error('contactno') is-invalid @enderror" name="contactno" value="{{ old('contactno') }}" autocomplete="contactno">

									@error('contactno')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>
                        </div>  
						<div class="row mb-3" style="display:none;">
							<div class="icon-box-cm">
								<img src="{{ asset('/assets/images/login/contact.png') }}">
							</div>
							<div class="form-group-custom">
								<label for="whatsapp" class=" col-form-label text-md-end">{{ __('Whatsapp') }}</label>

								<div class="input-box">
									<input id="whatsapp" type="text" class="form-control @error('whatsapp') is-invalid @enderror" name="whatsapp" value="{{ old('whatsapp') }}" autocomplete="whatsapp">

									@error('whatsapp')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>	
                        </div>
						<?php
						
						$requiredPosts=array();
						if(!empty($event->post_id)){
							$requiredPosts=\App\Models\Posts::whereIn("id",unserialize($event->post_id))->get();
							
						}
							
							?>
							@if(isset($event) && $event->status=="1"  && !empty($event->form_elements))
										
										<div id="applyevent" class="additionalform">
										
										</div>
									@endif
						<div class="row mb-3">
							<div class="icon-box-cm">
								<img src="{{ asset('/assets/images/login/contact.png') }}">
							</div>
							<div class="form-group-custom">
								<label for="post" class=" col-form-label text-md-end">{{ __('Position Applying For') }}</label>

								<div class="input-box">
									<select class="form-control @error('post') is-invalid @enderror" name="post" required>
											<option value="">Choose any one option</option>
											@if(!empty($requiredPosts))
												@foreach($requiredPosts as $post)
													<option  value="{{ $post->id }}">
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
									@error('post')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>	
                        </div>	
										
                        <!--div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div-->

                        <div class="row mb-0">
                            <div class="">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
						<div class="row mb-0">
							<div class="">
								<p>By clicking Register, the Participant acknowledges and consents to the collection, use, processing and transfer of personal data. Oceans ME holds certain personal information about the Participant for the purpose of managing and administering the Project. Oceans ME may transfer Data to any third parties assisting in the implementation, administration and management of the Project. The Participant authorizes the Company and any third parties to receive, possess, use, retain and transfer the Data, in electronic or other form, for the purposes of implementing, administering and managing the Participant’s participation in the Project.</p>
							</div>
						</div>
						<div class="row mb-0">
                            <div class="login-text">
                                  Already have an account? <a class="text-primary" href="{{ route('login') }}">Sign In</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
		<div class="form-right-img">
			<div class="right-img-box">
			@if(isset($event) && !empty($event->featured_image))
			<img src="{{ url('/') }}/assets/images/events/{{$event->featured_image}}"  class="right-img" />
			@else
			<img src="{{ asset('/assets/images/login/background001.jpg') }}" class="right-img" />
			@endif
			</div>
		</div>
    </div>
</div>
@endsection
@section('footer')
<?php
/*
$formdata=[];
if(isset($event) && $event->status=="1"  && !empty($event->form_elements)){
	$formdata=json_encode(unserialize($event->form_elements));
?>
<script>
  jQuery(function() {
  var code = document.getElementById("applyevent");
  var formData ='<?php echo $formdata ?>';	
   var addLineBreaks = html => html.replace(new RegExp("><", "g"), ">\n<");
  var $markup = $("<div/>");
  $markup.formRender({ formData });
  code.innerHTML += addLineBreaks($markup.formRender("html")); 
});
</script>
<?php


}
*/
?>
@endsection