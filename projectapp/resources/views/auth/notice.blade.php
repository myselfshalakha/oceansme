@extends('layouts.app')

@section('content')
<div class="row">
	  <div class="col-lg-12 d-flex flex-column">
			<div class="card">
			   <div class="card-body">
			   
				<div class="row">
				  <div class="col-sm-12">
					 <div class="accordion" id="accordionExample">
					  <h2 class="profile__percentage collapsed"  type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						  Profile Completion Status: 
						   @if(isset($profilestatus))
						   <span class="@if($profilestatus>='80') text-success @elseif($profilestatus>='50') text-warning @elseif($profilestatus>='30') text-info @elseif($profilestatus>='0') text-danger @endif">
						   {{round($profilestatus)}}%
						   </span>
						   @endif
						   <p class="card-description">To apply any event, you need to make sure that your profile completion percentage is 100% <a href="javascript:void(0)">Click here to see how it works</a></p>
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
					
<div class="row">
        <div class="col-lg-12 d-flex flex-column">
			<div class="card">
			<div class="card-header">Email Verification <span class="badge badge-warning">Pending</span>
			</div>
			
			<div class="card-body">
				<div class="rounded">						
					

					Before proceeding, please check your email for a verification link. If you did not receive the email,
					<form action="{{ route('verification.resend') }}" method="POST" class="d-inline">
						@csrf
						<button type="submit" class="d-inline btn btn-link p-0">
							click here to request another
						</button>.
						@if (session('resent'))
						<div class="text-success" role="alert">
							A fresh verification link has been sent to your email address.
						</div>
						@endif 
					</form>
				</div>
			</div>
		</div>		
    </div>
</div>
   
@endsection