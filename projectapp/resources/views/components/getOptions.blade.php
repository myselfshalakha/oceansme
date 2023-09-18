@if(!empty($options))
<option value="">Choose any one option</option>
	@foreach($options as $option)
		<option value="{{ $option->id }}">{{$option->name}} 
		@if((!isset($ispost) || $ispost==true) && !empty($option->rank))
			- {{$option->rank}}
		@endif
		@if((!isset($ispost) || $ispost==true) && !empty($option->rank_position))
			- {{$option->rank_position}}
		@endif
		
		</option>
	@endforeach
	@if(!isset($other) || $other==true)
		<option value="other">Other</option>
	@endif
@else
<option value="">Choose any one option</option>
	@if(!isset($other) || $other==true)
		<option value="other">Other</option>
@endif
@endif