<!DOCTYPE html>
<html>
<head>
	<title>Upload Success</title>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
	<link rel="stylesheet" type = "text/css" href = "<?php echo base_url(); ?>css/style.css">
</head>

<body>
	<h2>Your Profile Picture</h2>
	<ul>
		<img src="<?php echo base_url('./uploads/').$upload_data['file_name']; ?>" />
	</ul>
	<p>
		<?php echo anchor('private_area/profile', 'Go back to Profile Page'); ?>
	</p>
</body>
</html>
