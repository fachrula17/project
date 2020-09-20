<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login</title>
	<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
	<style>
		* {font-family: 'Montserrat', sans-serif;}
		body {
			margin: 5%;
		}
	</style>
</head>
<body>
	
	<h3>Login User.</h3>
		
	
	<?php if($errors && is_array($errors)) : ?>
		<ul>
			<?php foreach($errors as $error) : ?>
				<li><?= $error ?></li>
			<?php endforeach ?>
		</ul>
	<?php else: ?>
		<p><?= $errors ?></p>
	<?php endif ?>
	

	<form action="<?=site_url('login') ?>" method="POST">
		<div class="form-group">
			<label for="email">Email</label>
			<input type="text" name="email" placeholder="Email" id="email">
			<div class="error"></div>
		</div>

		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" name="password" placeholder="Password" id="password">
			<div class="error"></div>
		</div>

		<button type="submit">Masuk</button>
	</form>

</body>
</html>