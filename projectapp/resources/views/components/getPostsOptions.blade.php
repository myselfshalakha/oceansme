@if(!empty($posts))
@foreach($posts as $post)
	<option @if(in_array($post->id,$postname)) selected  @endif value="{{ $post->id }}">{{$post->name}} - {{$post->rank}}</option>
@endforeach

@endif