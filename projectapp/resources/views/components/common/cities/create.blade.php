@extends('layouts.app')
@section('content') 
<div class="cstm_cities_admin_create cstm_common_admin">
	<div class="row justify-content-center">
		  <div class="col-lg-12 grid-margin stretch-card">
				  <div class="card">
					<div class="card-body">
					  <div class="template-demo">
						<div class="btn-group">
						  <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuSplitButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> City Settings
						  </button>
						  <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton1">
							<a class="dropdown-item" href="{{ route('admin.city') }}/add">Add</a>
							<a class="dropdown-item" href="{{ route('admin.city') }}">List</a>
						  </div>
						</div>
					  </div>
					</div>
				  </div>
			</div>
			 <div class="col-12 grid-margin stretch-card">
			   <div class="card">
					<div class="card-header">@if(isset($city)) City changes @else Add City @endif</div>

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
									<form action="{{route('admin.city',['param'=>'save'])}}" method="post" enctype="multipart/form-data">
									
										{{csrf_field()}}
										@if(isset($city)) <input type="hidden" name="id" value="{{ $city->id }}"> @endif
										<div class="row mb-3">
											<label for="state" class="col-md-4 col-form-label text-md-end">State<span class="required_star">*</span></label>

											<div class="col-md-6">
												<select class="form-control" name="state">
												@if(!empty($states))
													@foreach($states as $state)
														<option @if(isset($city) && $city->state_id == $state->id) selected  @endif value="{{ $state->id }}">{{$state->name}}</option>
													@endforeach

												@endif
											</select>

											</div>
										</div>
										<div class="row mb-3">
											<label for="name" class="col-md-4 col-form-label text-md-end">City<span class="required_star">*</span></label>
											<div class="col-md-6">
											<input type="text" name="name" class="form-control" placeholder="City Name" value="@if(isset($city)) {{ $city->name }} @endif">
											</div>
										</div>
									
										
							  <div class="row mb-0 submit_btn_row">
								<div class="col-md-12 d-flex">
									<button type="submit" class="btn btn-primary">
										Submit
									</button> 
												<a href="{{ route('admin.city') }}" class="btn btn-secondary">
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