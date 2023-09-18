@extends('layouts.app')
@section('content') 
<div class="cstm_countries_admin_create cstm_common_admin">
	<div class="row justify-content-center">
      <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="template-demo">
                    <div class="btn-group">
					  <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuSplitButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Country Settings</button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton1">
                        <a class="dropdown-item" href="{{ route('admin.country') }}/add">Add</a>
                        <a class="dropdown-item" href="{{ route('admin.country') }}">List</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
        </div>
		 <div class="col-12 grid-margin stretch-card">
		   <div class="card">
                <div class="card-header">@if(isset($country)) Country Changes @else Add Country @endif</div>

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
								<form action="{{route('admin.country',['param'=>'save'])}}" method="post">
								
								
									{{csrf_field()}}
									@if(isset($country)) <input type="hidden" name="id" value="{{ $country->id }}"> @endif
									
									<div class="row mb-3">
										<label for="name" class="col-md-4 col-form-label text-md-end">Name<span class="required_star">*</span></label>
										<div class="col-md-6">
										<input type="text" name="name" class="form-control" placeholder="Name" value="@if(isset($country)) {{ $country->name }} @endif">
										</div>
									</div>
									<div class="row mb-3">
										<label for="sortname" class="col-md-4 col-form-label text-md-end">ShortName<span class="required_star">*</span></label>
										<div class="col-md-6">
										<input type="text" name="sortname" class="form-control" placeholder="Short Name" value="@if(isset($country)) {{ $country->sortname }} @endif">
										</div>
									</div>
									<div class="row mb-3">
										<label for="phonecode" class="col-md-4 col-form-label text-md-end">PhoneCode<span class="required_star">*</span></label>
										<div class="col-md-6">
										<input type="text" name="phonecode" class="form-control" placeholder="Phone Code" value="@if(isset($country)) {{ $country->phonecode }} @endif">
										</div>
									</div>
									
									<div class="row mb-0 submit_btn_row">
										<div class="col-md-12 d-flex">
											<button type="submit" class="btn btn-primary">
												Submit
											</button> 
											<a href="{{ route('admin.country') }}" class="btn btn-secondary">
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