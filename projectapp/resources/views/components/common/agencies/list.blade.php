@extends('layouts.app')

@section('content') 
<div class="row justify-content-center">
     <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="template-demo">
                    <div class="btn-group">
                      <button type="button" class="btn btn-primary">Agency Settings</button>
                      <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuSplitButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton1">
                        <a class="dropdown-item" href="{{ route('admin.agency') }}/add">Add</a>
                        <a class="dropdown-item" href="{{ route('admin.agency') }}">List</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
        </div>
		<div class="col-lg-12 grid-margin stretch-card table_record_list">
            <div class="card">
                <div class="card-header">All Agencies</div>

                <div class="card-body">
				
				
                                	<div class="table-responsive">
                                    	<table class="table table-striped">
                                    		<thead>
                                    			<th>Name</th>
                                    			<th>Email</th>
                                    			<th>Phone</th>
                                    			<th>Actions</th>
                                    		</thead>
                                    		<tbody>
                                    			@if(isset($agencies) && !empty($agencies))
                                    				@foreach($agencies as $agency)
                                    					<tr>
                                    						<td>{{ $agency->name }}</td>
                                    						<td>{{ $agency->email }}</td>
                                    						<td>{{ $agency->phone }}</td>
                                    						<td class="td-action-icons"> 
																 <a href="{{ route('admin.agency',['param'=>'edit']) }}?id={{$agency->id}}" class="btn-info h3"><i class="menu-icon mdi mdi-pencil"></i></a> 
																 <span class="delete_record text-danger h3" data-id="{{$agency->id}}" data-action="{{route('admin.agency',['param'=>'delete'])}}"><i class="menu-icon mdi mdi-delete"></i></span>                                                            </td>
                                    					</tr>
                                    				@endforeach
                                    			@else
                                    				<tr colspan="4">No Results</tr>
                                    			@endif
                                    		</tbody>
                                    	</table>
									<div class="total_pages">

                                    @if(isset($agencies) && !empty($agencies))
                                        Total: {{ $agencies->total() }}
                                            {{ $agencies->onEachSide(5)->links() }}
                                    @endif
                                    </div>
                                 </div>
				</div>
			</div>
		</div>
	</div>
@endsection