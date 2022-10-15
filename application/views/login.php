<!DOCTYPE html>
<html>
<head>
	<title>UQAuction User Login</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
	<style>
		body{
			background-color: #edeeca;
		}
	</style>
	<meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'/>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>

<body>
<div class="container">
	<br />
	<h3 align="center"><img src="<?php echo base_url(); ?>images/header.jpg" alt="Hello"></h3>
	<br />
	<div class="panel panel-default">
		<div class="panel-heading">Login to UQAuction</div>
		<div class="panel-body">
			<?php
			if($this->session->flashdata('message'))
			{
				echo '
                    <div class="alert alert-success">
                        '.$this->session->flashdata("message").'
                    </div>
                    ';
			}
			?>
			<form method="post" action="<?php echo base_url(); ?>login/validation">
				<div class="form-group">
					<label>Enter Email Address</label>
					<input type="text" name="user_email" class="form-control" value="<?php echo set_value('user_email'); if (get_cookie('uemail')) { echo get_cookie('uemail'); } ?>" />
					<span class="text-danger"><?php echo form_error('user_email'); ?></span>
				</div>
				<div class="form-group">
					<label>Enter Password</label>
					<input type="password" name="user_password" class="form-control" value="<?php echo set_value('user_password');  if (get_cookie('upassword')) { echo get_cookie('upassword'); } ?>" />
					<span class="text-danger"><?php echo form_error('user_password'); ?></span>
				</div>
				<div class="form-group">
					<td><input type="checkbox" name="chkremember" value="Remember me" <?php if (get_cookie('uemail')) { ?> checked="checked" <?php } ?>>Remember me</td>
				</div>
				<div class="form-group">
					<input type="submit" name="login" value="Login" class="btn btn-info" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url() ?>login/forgot" class="btn btn-info">Forgot Your Password?</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>register">Click here to Register for an account</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>login/google_login">Click here to Login with Google</a>
				</div>
			</form>
		</div>
	</div>
</div>
</body>
</html>
