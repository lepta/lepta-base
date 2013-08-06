<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
<style type='text/css'>
body
{
	font-family: Arial;
	font-size: 14px;
}
a {
    color: blue;
    text-decoration: none;
    font-size: 14px;
}
a:hover
{
	text-decoration: underline;
}
.loginform {
	width: 200px;
	background-color: #eee;
	border-radius: 20px;
	padding: 20px;
	margin: 100px auto;
	height: 100%;
}
p {margin-top: 0}
</style>
</head>
<body>
	<div class="loginform">
		<?php foreach ($messages as $message) { ?>
		   <p><?php echo $message ?></p>
		<?php } ?>
		<form action='/administrator/login' method="post">
			<label for="adminlogin">Логин:</label>
			<p><input type="text" name="adminlogin" id="adminlogin" /></p>

			<label for="adminlogin">Пароль:</label>
			<p><input type="password" name="adminpass" id="adminpass" /></p>

			<input type="submit" value="Войти" />
		</form>
	</div>
</body>
</html>
