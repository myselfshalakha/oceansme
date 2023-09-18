@extends('layouts.app')

@section('content') 
<div class="cstm_post_admin_createlists cstm_common_admin">
	<div class="row justify-content-center">
     <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="template-demo">
                    <div class="btn-group">
                      <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuSplitButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Posts Settings</button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton1">
                        <a class="dropdown-item" href="{{ route('admin.post') }}/add">Add</a>
                        <a class="dropdown-item" href="{{ route('admin.post') }}">List</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
        </div>
		<div class="col-lg-12 grid-margin stretch-card table_record_list">
            <div class="card">
                <div class="card-header">All Posts</div>

                <div class="card-body">
				
				
                                	<div class="table-responsive">
                                    	<table class="table table-striped">
                                    		<thead>
                                    			<th>Job Position / Job Title</th>
                                    			<th>Rank</th>
                                    			<th>Rank Position</th>
                                    			<th>Department</th>
                                    			<th>Actions</th>
                                    		</thead>
                                    		<tbody>
                                    			@if(isset($posts) && !empty($posts))
                                    				@foreach($posts as $post)
                                    					<tr>
                                    						<td>{{ $post->name }}</td>
                                    						<td>{{ $post->rank }}</td>
                                    						<td>{{ $post->rank_position }}</td>
                                    						<td>{{ $post->depname }}</td>
                                    						
                                    						<td class="td-action-icons"> 
																 <a href="{{ route('admin.post',['param'=>'edit']) }}?id={{$post->id}}" class="btn-info h3"><i class="menu-icon mdi mdi-pencil"></i></a> 
																 <span class="delete_record text-danger h3" data-id="{{$post->id}}" data-action="{{route('admin.post',['param'=>'delete'])}}"><i class="menu-icon mdi mdi-delete"></i></span>                                                            </td>
                                    					</tr>
                                    				@endforeach
                                    			@else
                                    				<tr colspan="4">No Results</tr>
                                    			@endif
                                    		</tbody>
                                    	</table>
									<div class="total_pages">

                                    @if(isset($posts) && !empty($posts))
                                        Total: {{ $posts->total() }}
                                            {{ $posts->onEachSide(5)->links() }}
                                    @endif
                                    </div>
                                    </div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection