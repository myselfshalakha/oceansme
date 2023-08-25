@extends('layouts.app')

@section('content')
<div class="row dash-board-count-box_description">
		
		<div class="row invigilator_info" id="applicant_description">
			<div class="card">
				<div class="card-body">
				<div class="col-md-12">
					<div class="row">
							<div class="col-sm-12">
							 <div class="alert alert-danger">
								        <strong>Whoops!</strong> There were some problems with your search.<br><br>
							</div>
								  <div class="search-applicant-container  mt-1">
												  <h4 class="card-title">Search Applicant</h4>
												  <form class="forms-sample" action="{{ route('admin.events') }}/search_applicant" method="get">
												  {{csrf_field()}}
													<div class="form-group">
													  <label for="search_text">Regid</label>
													  <input type="text" class="form-control" name="id" placeholder="Enter the Regiid" value="{{ $_GET['id'] ?? '' }}" required>
													</div>
													<button type="submit" class="btn btn-primary me-2">Search</button>
												  </form>
                                  </div>
                         
								  </div>
								  <div class="col-sm-12">
								
								  <div class="search-applicant-result table-responsive  mt-1">
                                  </div>
							</div>
					</div>	
				</div>
			</div>
			</div>
		</div>
	</div>
@endsection