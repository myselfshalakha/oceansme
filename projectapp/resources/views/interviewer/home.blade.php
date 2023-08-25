@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
                        <div class="col-md-12">
                           <form class="card card-sm" action="{{ route('admin.events') }}/search_applicant" method="get">
												  {{csrf_field()}}

                                <div class="card-body row no-gutters align-items-center">
                               
                                    <!--end of col-->
                                     <div class="col-10">
										 <input type="text" class="form-control form-control-lg" name="id" placeholder="Enter the Regiid" required>
                                    </div>
                                    <!--end of col-->
                                    <div class="col-2">
										<button type="submit" class="btn btn-primary me-2">Search</button>
                                    </div>
                                    <!--end of col-->
                                </div>
                            </form>
                        </div>
                        <!--end of col-->
     </div>
@endsection