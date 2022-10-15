<!DOCTYPE html>
<html>
<head>
	<title>UQAuction User Profile</title>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
	<link rel="stylesheet" type = "text/css" href = "<?php echo base_url(); ?>css/style.css">
</head>

<body>
<div class="container">
	<h2><?php echo $user['name']; ?>'s User Profile</h2>
	<div class="regisFrm">
		<p><b>Name: </b><?php echo $user['name']; ?></p>
		<p><b>Email: </b><?php echo $user['email']; ?></p>
		<p><b>Mobile Number: </b><?php echo $user['mobile']; ?></p>
		<p><b>Student Number: </b><?php echo $user['student_no']; ?></p>
		<p><b>Gender: </b><?php echo $user['gender']; ?></p>
		<p><b>Bio: </b><?php echo $user['bio']; ?></p>
		<p>
		<?php echo form_open_multipart('upload/do_upload');?>
		<input type="file" name="userfile" size="20" />
		<br /><br />
		<input type="submit" value="Upload your profile Image" /></p>
		<p><a href="<?php echo base_url(); ?>private_area/address">Set up your address</a> </p>
		<p><a href="<?php echo base_url(); ?>private_area/update_profile">">Update Profile</a> </p>
	</div>
</div>
</body>
</html>
