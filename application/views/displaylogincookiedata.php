<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Display Data</title>
	<style>
		body{
			margin: 10% auto 0;
		}
		td{
			text-align: center;
		}
	</style>
</head>
<body>
<center><h1>Display Cookie Data</h1></center>
<table align="center" border="1">
	<?php
	if (get_cookie('uemail'))
	{
		?>
		<tr>
			<td><h2>Welcome user: <?php echo get_cookie('uemail'); ?></h2></td>
		</tr>
		<?php
	}
	else
	{
		?>
		<tr>
			<td><h2>No cookies created or available</h2></td>
		</tr>
		<?php
	}
	?>
</table>
</body>
</html>
