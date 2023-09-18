@extends('layouts.app')
@section('content')
<div class="cstm_hrmanager_admin cstm_common_admin">
	<div class="row">
   
         
		<div class="col-lg-12 grid-margin stretch-card table_record_list">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">All Hr Managers</h4>
                  <!--p class="card-description">
                    Add class <code>.table-striped</code>
                  </p-->
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
						<tr>
						<th>Name</th>
						<th>Email</th>
						<th>Action</th>

						</tr>
                      </thead>
                      <tbody>
                        @if(isset($users) && !empty($users))
						@foreach($users as $user)
							<tr>
								<td>{{ $user->name }}</td>
								<td>{{ $user->email }}</td>
							
								<td class="td-action-icons"> 
								<a href="{{ route('admin.users') }}/hr_manager/edit?id={{$user->id}}" class="btn-info h3"><i class="menu-icon mdi mdi-pencil"></i></a> 
								<span class="delete_record btn-danger h3" data-id="{{$user->id}}" data-action="{{ route('admin.users') }}/hr_manager/delete"><i class="menu-icon mdi mdi-delete"></i></span>
								</td>
							</tr>
						@endforeach
					@else
							<tr><td colspan="3">n/a</td></tr>
					@endif
                      </tbody>
                    </table>
					<div class="total_pages">
					@if(isset($users) && !empty($users))
					Total: {{ $users->total() }}
						{{ $users->onEachSide(5)->links() }}
					@endif
                  </div>
                  </div>
                </div>
              </div>
            </div>          
     </div>  
</div>	 
@endsection
