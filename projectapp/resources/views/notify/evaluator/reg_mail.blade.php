<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8"><title></title>
    </head>
    <body>
	<p>Hi! <strong>{{ $name }}</strong> </p>
	<p>{{ $comment }}</p>
	<br><strong>Email</strong>: {{ $email }}
	<br><strong>Password</strong>: {{ $password }} 
	<br>To keep your Email account safe, we recommend you please change this password aftter login.<br><br>
	<p>Kindly visit the website to check your dashboard.<a href="{{ $login }}">Click Here!</a></p>
    </body>
</html>