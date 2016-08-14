<?php
	require('../include/config.php');

	if(!$user->isLoggedIn()){
		header('Loaction: login.php');
	}

?>
<html>
<head>
	<title>New post</title>
	<link rel="stylesheet" type = "text/css" href="../style/addPost.css">
</head>

<body>
	<div id = "container">
		<form action="uploadProcessor.php" method = "post" enctype="multipart/form-data">
			<h3 class = "post_labels">Title</h3>
			<input class="post_text_input" type="text" name="postTitle" required>
			<h3 class = "post_labels">Description</h3>
			<textarea class = "post_text_input" type="text" name="postDesc" style="height:50px" required></textarea>
			<h3 class = "post_labels">Content</h3>
			<textarea class = "post_text_input" type="text" name="postCont" style="height:130px" required></textarea>
			<input type = "file" name ="image">
			<input type="submit" name="post" value="post">
		</form>
	</div>
	
</body>
</html>
