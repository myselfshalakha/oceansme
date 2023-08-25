@extends('layouts.app')
@section('content')
   <div class="row">
		<div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">All Users</h4>
                  <!--p class="card-description">
                    Add class <code>.table-striped</code>
                  </p-->
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
						<tr>
						<th>Name</th>
						<th>Email</th>
						<th>Role</th>
						<th></th>

						</tr>
                      </thead>
                      <tbody>
                        @if(isset($users) && !empty($users))
						@foreach($users as $user)
							<tr>
								<td>{{ $user->name }}</td>
								<td>{{ $user->email }}</td>
								<td>
								@if(!empty($user->role_id))
									@if(!empty($roles))
										@foreach($roles as $role)
											@if($role->id == $user->role_id)
												{{ $role->name}}
											@endif
										@endforeach

									@endif
								@else
									User
								@endif
								</td>
								<td></td>
							</tr>
						@endforeach
					@else
							<tr><td colspan="4">n/a</td></tr>
					@endif
                      </tbody>
                    </table>
					@if(isset($users) && !empty($users))
					Total: {{ $users->total() }}
						{{ $users->onEachSide(5)->links() }}
					@endif
                  </div>
                </div>
              </div>
            </div>          
      </div>          
@endsection
