@extends('layouts.app')

@section('content') 
<div class="cstm_companies_admin_list cstm_common_admin">
	<div class="row justify-content-center">
     
		<div class="col-lg-12 grid-margin stretch-card table_record_list">
            <div class="card">
                <div class="card-header">All Companies</div>

                <div class="card-body">
				
				
                                	<div class="table-responsive">
                                    	<table class="table table-striped">
                                    		<thead>
                                    			<th></th>
                                    			<th>Name</th>
                                    			<th>Phone</th>
                                    			<th>Email</th>
                                    			<th>Country</th>
                                    			<th>State</th>
                                    			<th>City</th>
                                    			<th>Actions</th>
                                    		</thead>
                                    		<tbody>
                                    			@if(isset($companies) && !empty($companies))
                                    				@foreach($companies as $company)
                                    					<tr>
                                    						<td><img src="{{ url('/') }}/assets/images/company/{{ $company->logo ?? 'default.jpg' }}" class="img-xs rounded-circle"></td>
                                    						<td>{{ $company->name }}</td>
                                    						<td>{{ $company->phone }}</td>
                                    						<td>{{ $company->email }}</td>
                                    						<td>
															@if($company->country_id=="other")
																Other
															@else
															{{ \App\Models\Country::find($company->country_id)->name ?? "n/a"}}
															@endif
															</td>
                                    						<td>
															@if(empty($company->state_id))
																n/a
															@elseif($company->state_id=="other")
																Other
															@else
															{{ \App\Models\State::find($company->state_id)->name }}
															@endif
															</td>
                                    						<td>
															@if(empty($company->city_id))
																n/a
															@elseif($company->city_id=="other")
																Other
															@else
															{{ \App\Models\City::find($company->city_id)->name }}
															@endif
															</td>
                                    						<td class="td-action-icons"> 
																 <a href="{{ route('admin.company',['param'=>'edit']) }}?id={{$company->id}}" class="btn-info h3"><i class="menu-icon mdi mdi-pencil"></i></a> 
																 <span class="delete_record text-danger h3" data-id="{{$company->id}}" data-action="{{route('admin.company',['param'=>'delete'])}}"><i class="menu-icon mdi mdi-delete"></i></span>                                                            </td>
                                    					</tr>
                                    				@endforeach
                                    			@else
                                    				<tr colspan="4">No Results</tr>
                                    			@endif
                                    		</tbody>
                                    	</table>
												<div class="total_pages">

                                    @if(isset($companies) && !empty($companies))
                                        Total: {{ $companies->total() }}
                                            {{ $companies->onEachSide(5)->links() }}
                                    @endif
									</div>
				</div>
                                    </div>
												
			</div>
		</div>
	</div>
</div>
@endsection