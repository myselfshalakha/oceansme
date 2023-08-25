<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8"><title></title>
    </head>
    <body>
	<p>Hey there! your company have registered an event. The details are given below:</p>
	<p> 
	<strong>Company:</strong> {{$company}}<br>
    <strong>Name:</strong> {{$name}}<br>
    <strong>Start Date:</strong> {{$start_date}}<br>
    <strong>End Date:</strong> {{$end_date}}<br>
    <strong>Post:</strong> {{$post}}<br>
    <strong>Description:</strong> {{$description}}<br>
	</p>
	
	<p>Kindly visit the website.<a href="{{ route('login') }}">Click Here!</a></p>
	<p>Regards Oceans Me</p>
	<p></p>
    </body>
</html>