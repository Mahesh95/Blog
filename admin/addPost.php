<?php
	require('../include/config.php');

	if(!$user->isLoggedIn()){
		header('Loaction: login.php');
	}

	//this piece of code checks if the post is to be edited, when user presses on edit button, postId is send through get method
	if(isset($_GET['postId'])){
		try{
			$statement = $database->prepare("SELECT * FROM posts WHERE postId = :postId");
			$statement->execute(array(':postId' => $_GET['postId']));

			$row = $statement->fetch();
			$postTitle = $row['postTitle'];
			$postDesc = $row['postDesc'];
			$postCont = $row['postCont'];
		}catch(PDOException $e){
			echo $e->getMessage();
		}
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
			<input type="hidden" name="postId" value="<?php echo isset($_GET['postId'])?$_GET['postId']:''; ?>">
			<h3 class = "post_labels">Title</h3>
			<input class="post_text_input" type="text" name="postTitle" value = "<?php echo isset($postTitle)?$postTitle:''; ?>" required>
			<h3 class = "post_labels">Description</h3>
			<textarea class = "post_text_input" type="text" name="postDesc" style="height:50px" required>
			<?php echo isset($postDesc)?$postDesc:''; ?>
				
			</textarea>
			<h3 class = "post_labels">Content</h3>
			<textarea class = "post_text_input" type="text" name="postCont" style="height:130px" required>
				<?php
				echo isset($postCont)?$postCont:'';
				 ?>
			</textarea>
			<input type = "file" name ="image">
			<input type="submit" name="<?php echo isset($row)?'postEdit':'post' ?>" value="post">
		</form>
	</div>
	
</body>
</html>
