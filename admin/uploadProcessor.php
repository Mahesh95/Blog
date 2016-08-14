<?php
	require_once('../include/config.php');

	if(isset($_POST['post'])){
		// if a file is uploaded
		if($_FILES['image']['name']){

			// if no error
			if(!$_FILES['image']['error']){

				// create an intance of post
				$post = new Post($_POST['postTitle'], $_POST['postCont'], $_POST['postDesc'], $_SESSION['userId'], $database);
			
				$fileName = $post->getFileName();
				$pathInfo = pathinfo($_FILES['image']['name']);
				$extention = $pathInfo['extension'];
				$targetFile = "images/".$fileName.".$extention";

				move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
				$targetFile = "admin/"."$targetFile";

				$post->setFileLocation($targetFile);

				//write post to the database
				Post::writeToPostTable($post, $user);
			}
		}	
	}

	
?>