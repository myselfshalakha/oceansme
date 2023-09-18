@extends('layouts.app')
@section('content') 
<div class="cstm_event_admin_customform cstm_common_admin">
	<div class="row justify-content-center">
		<div class="col-lg-12 grid-margin stretch-card">
				  <div class="card">
					<div class="card-body">
					
					 <a href="{{ route('admin.events',['param'=>'edit']) }}?id={{$event->id}}" class="go__back btn-user h3" title="Applicant">Go Back</a> 

					</div>
				  </div>
			</div>
			 <div class="col-12 grid-margin stretch-card">
			   <div class="card">
					<div class="card-header">@if(isset($event)) Event Custom Form @endif</div>

					<div class="card-body">
						<div class="row">
								<div class="col-12">
									@if ($errors->any())
										<div class="alert alert-danger">
											<strong>Whoops!</strong> There were some problems with your input.<br><br>
											<ul>
												@foreach ($errors->all() as $error)
													<li>{{ $error }}</li>
												@endforeach
											</ul>
										</div>
									@endif
									@if(session()->has('success'))
										<div class="alert alert-success">
											{{ session()->get('success') }}
										</div>
									@endif
									
								</div>
								<div class="event-form-build-wrap form-wrapper-div"  data-action="{{route('admin.events')}}/saveCustomEventForm" data-id="{{$event->id}}"></div>
							</div>
						
					</div>
				</div>
			</div>
		</div>
	@endsection
</div>

@section('footer')
<?php
$formdata="";
if(isset($event->form_elements) && !empty($event->form_elements)){
	$formdata=json_encode(unserialize($event->form_elements));
?>
	
<?php
}
?>
	<script>
    jQuery(function() {

  //var code = document.getElementById("build-wrap");
  var formData ='<?php echo $formdata ?>';
	  	var fb = $('.event-form-build-wrap').formBuilder({disableFields: ['header','paragraph','autocomplete','button','date','file','hidden','starRating'],formData:formData});

		jQuery( 'body' ).on( 'click','.save-template', function(){
				   var action=jQuery(".event-form-build-wrap").attr("data-action");
				   var id=jQuery(".event-form-build-wrap").attr("data-id");
					 $.ajax({
						url: action,
						type: 'POST',
						data: {
							id:  id,
							frmcontent:  fb.actions.getData('json') 
						},
						success: function(data){
							if(data.success === true){
								 Messenger.options = {
								extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-right',
								theme: 'flat'
							}
							Messenger().post({
								message: data.message,
								type: 'success',
								showCloseButton: true
							});
								location.reload();
							}else{
									Messenger.options = {
									extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-right',
									theme: 'flat'
								}
								Messenger().post({
									message: 'Error saving the form!',
									type: 'danger',
									showCloseButton: true
								});

							}
						   
						},   
						error: function( jqXHR ){
							Messenger.options = {
								extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-right',
								theme: 'flat'
							}
							Messenger().post({
								message: 'Error saving the form',
								type: 'danger',
								showCloseButton: true
							});

						}

					}); 

			}); 
//var fb = $('.event-form-build-wrap').formBuilder({ formData });
	
  /* var addLineBreaks = html => html.replace(new RegExp("><", "g"), ">\n<");

  var $markup = $("<div/>");
  $markup.formRender({ formData });

  code.innerHTML = addLineBreaks($markup.formRender("html")); */
});
	</script>
@endsection
