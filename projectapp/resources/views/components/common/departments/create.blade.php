@extends('layouts.app')
@section('content') 
<div class="cstm_departments_admin_create cstm_common_admin">
	<div class="row justify-content-center">
      <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="template-demo">
                    <div class="btn-group">
                       <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuSplitButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Department Settings</button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton1">
                        <a class="dropdown-item" href="{{ route('admin.department') }}/add">Add</a>
                        <a class="dropdown-item" href="{{ route('admin.department') }}">List</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
        </div>
		 <div class="col-12 grid-margin stretch-card">
		   <div class="card">
                <div class="card-header">@if(isset($department)) Department Changes @else Add Department @endif</div>

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
								<form action="{{route('admin.department',['param'=>'save'])}}" method="post">
								
								
									{{csrf_field()}}
									@if(isset($department)) <input type="hidden" name="id" value="{{ $department->id }}"> @endif
									
									<div class="row mb-3">
										<label for="name" class="col-md-4 col-form-label text-md-end">Name<span class="required_star">*</span></label>
										<div class="col-md-6">
										<input type="text" name="name" class="form-control" placeholder="Name" value="@if(isset($department)) {{ $department->name }} @endif" required>
										</div>
									</div>
									
									<div class="row  questions_bank repouter">
									@if(isset($department) && !empty($department->questions))
											<?php
											$i=1;
											foreach(unserialize($department->questions) as $question){
												?>
													<div class="addonfields row mb-3 clscount{{$i}}">
													<div class="row mb-3">
														<label class="col-md-4 col-form-label text-md-end">Question<span class="required_star">*</span></label>
														<div class="col-md-6">
														<input type="text" name="questions[]" class="form-control" placeholder="Question" value="{{$question['question']}}" required="">
														</div>
													</div>
													<div class="row mb-3">
														<label class="col-md-4 col-form-label text-md-end">Answer<span class="required_star">*</span></label>
														<div class="col-md-6">
														<input type="text" name="answers[]" class="form-control" placeholder="Answer" value="{{$question['answer']}}" required="">
														</div>
													</div>
														<a href="javascript:void(0)" class="actionremove col-12" data="{{$i}}">Remove</a>
													</div>
													<?php
													$i++;
											}
											?>
									@endif
									</div>
									<div class="row mb-3">
										<div class="col-md-12">
										 <a class="clonebut_abs" href="javascript:void(0);">(+) Add Questions</a>
										</div>
									</div>
									<div class="row mb-0 submit_btn_row">
										<div class="col-md-12 d-flex">
											<button type="submit" class="btn btn-primary">
												Submit
											</button> 
											<a href="{{ route('admin.department') }}" class="btn btn-secondary">
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
	<div class="repeat_html" style="display:none;">
	<div class="row mb-3">
							<label class="col-md-4 col-form-label text-md-end">Question<span class="required_star">*</span></label>
							<div class="col-md-6">
							<input type="text" name="questions[]" class="form-control" placeholder="Question" value="" required>
							</div>
							</div>	
	<div class="row mb-3">
	<label class="col-md-4 col-form-label text-md-end">Answer<span class="required_star">*</span></label>
	<div class="col-md-6">
	<input type="text" name="answers[]" class="form-control" placeholder="Answer" value="" required>
	</div>
	</div>
	</div>   
</div>
@endsection