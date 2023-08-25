<table class="table select-table">
	<thead>
	  <tr>
	   <th></th>
	   <th>Name</th>
		<th>Email</th>
		<th>Nationality</th>
		<th>Current Position</th>
		<th>Position Applying</th>
		<th>Eperience</th>
		<th>Schedule</th>
		<th>Resume</th>
	  </tr>
	</thead>
	<tbody>
	<?php
		$status=get_user_attending_status();
	?>
	 @if(isset($applicant) && !empty($applicant))
			<tr>
				<td>
				<a href="{{ route('admin.events',['param'=>'applicant-info']) }}?id={{$applicant->uev_id}}" class="text-info" title="View">View Applicant</a> 

				</td>
				<td>{{ $applicant->name }} @if(isset($applicant->att_status))</br><span class="badge badge-info">{{$status[$applicant->att_status]}}</span> @endif</td>
				<td>{{ $applicant->email }}</td>
				<td>{{\App\Models\Country::find($applicant->nationality)->name ?? "n/a"}}</td>

				<td>{{ $applicant->position ?? 'n/a'}}</td>
				<td>{{ \App\Models\Posts::find($applicant->post_apply)->name}}</td>
			
				<td>{{ getExperienceText($applicant->exp_years,$applicant->exp_months) }}</td>
				<td>n/a</td>
				<td>
				@if(!empty($applicant->resume))
					<a href="{{ url('/') }}/assets/files/user/resume/{{$applicant->resume}}" class="resume_icon_btn resume_icon_preview"><i class="mdi mdi-eye menu-icon"></i></a>
					<a href="{{ url('/') }}/assets/files/user/resume/{{$applicant->resume}}" class="resume_icon_btn" download><i class="mdi mdi-download menu-icon"></i></a>
				@else 
					Not Uploaded Yet. 
				@endif
				</td>
				
			</tr>
	@else
		<tr><td colspan="9">n/a</td></tr>
	@endif
	</tbody>
</table>
