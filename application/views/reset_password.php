<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>UQAuction Reset Password</title>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>

<body>

	<h3><a href="<?php echo base_url(); ?>login/validation"> <---- Go to Login Page</a></h3>

	<?php
		if($success){
			echo '<p>You have successfully reset your password.</p>';
		} else {
			echo form_open();
			echo form_label('Password', 'password') .'<br />';
			echo form_password(array('name' => 'password', 'value' => set_value('password'))) .'<br />';
			echo form_error('password');
			echo form_label('Confirm Password', 'password_conf') .'<br />';
			echo form_password(array('name' => 'password_conf', 'value' => set_value('password_conf'))) .'<br />';
			echo form_error('password_conf');
			echo form_submit(array('type' => 'submit', 'value' => 'Save New Password'));
			echo form_close();
		}
	?>

</body>
</html>
