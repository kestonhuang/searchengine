<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>UQAuction: Login with Google</title>
	<meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'/>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />

</head>
<body>
<div class="container">
	<br />
	<h2 align="center">Login using Google Account</h2>
	<br />
	<div class="panel panel-default">
		<?php
		if(isset($login_button))
		{
			echo '<div align="center">'.$login_button . '</div>';
		}
		?>
	</div>
</div>
</body>
</html>
