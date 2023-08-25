@extends('layouts.app')

@section('content') 
<div class="row justify-content-center">
      <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="template-demo">
                    <div class="btn-group">
                      <button type="button" class="btn btn-primary">State Settings</button>
                      <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuSplitButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton1">
                        <a class="dropdown-item" href="{{ route('admin.state') }}/add">Add</a>
                        <a class="dropdown-item" href="{{ route('admin.state') }}">List</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
        </div>
		<div class="col-lg-12 grid-margin stretch-card table_record_list">
            <div class="card">
                <div class="card-header">All States</div>

                <div class="card-body">
					<div class="table-responsive">
                                    	<table class="table table-striped">
                                    		<thead>
                                    			<th>Name</th>
                                    			<th>Country</th>
                                    			<th>Actions</th>
                                    		</thead>
                                    		<tbody>
                                    			@if(isset($states) && !empty($states))
                                    				@foreach($states as $state)
                                    					<tr>
                                    						<td>{{ $state->name }}</td>
															 <td>{{ \App\Models\Country::find($state->country_id)->name }}</td>

                                    						<td class="td-action-icons"> 
																 <a href="{{ route('admin.state',['param'=>'edit']) }}?id={{$state->id}}" class="btn-info h3"><i class="menu-icon mdi mdi-pencil"></i></a> 
																 <span class="delete_record text-danger h3" data-id="{{$state->id}}" data-action="{{route('admin.state',['param'=>'delete'])}}"><i class="menu-icon mdi mdi-delete"></i></span>

                                                            </td>
                                    					</tr>
                                    				@endforeach
                                    			@else
                                    				<tr colspan="4">No Results</tr>
                                    			@endif
                                    		</tbody>
                                    	</table>
									<div class="total_pages">
                                    @if(isset($states) && !empty($states))
                                        Total: {{ $states->total() }}
                                            {{ $states->onEachSide(5)->links() }}
                                    @endif
                                    </div>
                                    </div>
				
				</div>
			</div>
		</div>
	</div>
@endsection
