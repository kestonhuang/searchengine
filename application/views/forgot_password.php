<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>UQAuction Forget Password</title>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>

<body>

<div class="container">
	<div class="row">

		<h3><a href="<?php echo base_url(); ?>login/validation"> <---- Go back to Login Page</a></h3>

		<?php
		if($success){
			echo '<p>Thank you. We have sent you an email with further instructions on how to reset your password.</p>';
		} else {
			echo form_open();
			echo form_label('Email Address', 'email') .'<br />';
			echo form_input(array('name' => 'email', 'value' => set_value('email'))) .'<br />';
			echo form_error('email');
			echo form_submit(array('type' => 'submit', 'value' => 'Reset Password'));
			echo form_close();
		}
		?>

	</div><!-- .row -->
</div><!-- .container -->
</body>
</html>
