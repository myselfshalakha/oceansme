@if(!empty($evaluators))
@foreach($evaluators as $user)
	@if(!empty($user->dep_id))
		<?php
			$selected="";
			$evlshow=false;
			$userdeps=unserialize($user->dep_id);
			foreach($departments as $department){
				if(in_array($department,$userdeps))
				{
					$evlshow=true;
					break;
				}
			}
		?>
			@if($evlshow==true)
				@if(!empty($event_evaluators))
						@if(in_array($user->id,$event_evaluators))
							<?php
							$selected="selected";
							?>
						@endif
				@endif
				<option value="{{ $user->id }}" {{$selected}}>{{$user->name}}</option>
			@endif
	@endif
@endforeach

@endif