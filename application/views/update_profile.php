<!DOCTYPE html>
<html>
<head>
	<title>Update Your Profile</title>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
	<link rel="stylesheet" type = "text/css" href = "<?php echo base_url(); ?>css/style.css">
</head>

<body>
	<h2><?php echo $user['name']; ?>'s User Profile</h2>
	<form method="post" action="<?php echo base_url(); ?>private_area/update_profile">
		<div class="form-group">
			<label>Update Your Name </label>
			<input type="text" name="name" class="form-control" value="<?= set_value('name', $user['name']) ?>"/>
		</div>
			<label>Enter Your Mobile </label>
			<input type="text" name="mobile" value="<?= set_value('mobile', $user['mobile']) ?>"/>
		<div class="form-group">
			<label>Enter Your Gender </label>
			<input name="gender" type="radio" class="" value="male" <?php if($user['gender'] == 'male') echo "checked"; ?>/>
			<label for="gender" class="">Male</label>
			<input name="gender" type="radio" class="" value="female" <?php if($user['gender'] == 'female') echo "checked"; ?>/>
			<label for="gender" class="">Female</label>
		</div>
		<div class="form-group">
			<label>Enter Your Bio </label>
			<textarea rows="10" cols="40" name="bio"><?= set_value('bio', $user['bio']) ?></textarea>
		</div>
		<div class="form-group">
			<input type="submit" name="update" value="Update Profile"/>
		</div>
	</form>

</body>
</html>
