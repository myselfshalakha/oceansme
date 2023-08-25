@extends('layouts.app')
@section('content') 
<div class="row justify-content-center">
      <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="template-demo">
                    <div class="btn-group">
                      <button type="button" class="btn btn-primary">Posts Settings</button>
                      <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuSplitButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton1">
                        <a class="dropdown-item" href="{{ route('admin.post') }}/add">Add</a>
                        <a class="dropdown-item" href="{{ route('admin.post') }}">List</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
        </div>
		 <div class="col-12 grid-margin stretch-card">
		   <div class="card">
                <div class="card-header">@if(isset($post)) Post Changes @else Add Post @endif</div>

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
								<form action="{{route('admin.post',['param'=>'save'])}}" method="post" enctype="multipart/form-data">
								
								
									{{csrf_field()}}
									@if(isset($post)) <input type="hidden" name="id" value="{{ $post->id }}"> @endif
									
									<div class="row mb-3">
										<label for="name" class="col-md-4 col-form-label text-md-end">Post Name<span class="required_star">*</span></label>
										<div class="col-md-6">
										<input type="text" name="name" class="form-control" placeholder="Post Name" value="@if(isset($post)){{ $post->name }}@endif">
										</div>
									</div>
									<div class="row mb-3">
										<label for="rank" class="col-md-4 col-form-label text-md-end">Post Rank</label>
										<div class="col-md-6">
										<input type="text" name="rank" class="form-control" placeholder="Post Rank" value="@if(isset($post)){{ $post->rank }}@endif">
										</div>
									</div>
									<div class="row mb-3">
										<label for="departments" class="col-md-4 col-form-label text-md-end">Department<span class="required_star">*</span></label>
										<div class="col-md-6">
										<select class="form-control" name="dep_id">
											@if(!empty($departments))
												@foreach($departments as $department)
													<option @if(isset($post) && $post->dep_id == $department->id) selected  @endif value="{{ $department->id }}">{{$department->name}}</option>
												@endforeach

											@endif
											</select>
										</div>
									</div>
										<div class="row mb-0 submit_btn_row">
										<div class="col-md-12 d-flex">
											<button type="submit" class="btn btn-primary">
												Submit
											</button> 
											<a href="{{ route('admin.post') }}" class="btn btn-secondary">
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