<?php
//include config
require_once('../include/config.php');
//if already logged in, then redirection from index page, destroy the session
if( $user->isLoggedIn() ){
 header("Location: ../index.php");
 exit();
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../style/login.css">
  <title>Admin Login</title>
</head>
<body>

<div id="login">

	<?php

	//process login form if submitted
	if(isset($_POST['submit'])){

		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		
		if($user->login($username,$password)){ 

			//logged in return to index page
			header('Location: ../index.php');
			exit;
		

		} else {
			$message = '<p class="error">Wrong username or password</p>';
		}

	}//end if submit

	if(isset($message)){ echo $message; }
	?>

	<form action="" method="post" id = "login_form">
	<p class = "login_form_fields"><label>Username</label><input type="text" name="username" value=""  class = "inputField" /></p>
	<p class = "login_form_fields"><label>Password</label><input type="password" name="password" value=""  class="inputField" /></p>
	<input type="submit" name="submit" value="Login" id="login_button"/>
	</form>

</div>
</body>
</html>
