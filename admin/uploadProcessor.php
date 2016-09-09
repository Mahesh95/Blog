<?php
	require_once('../include/config.php');

	//check if the post is edited, if post is intended to be edited, send postId though POST
	if(isset($_POST['postId'])){
		// if so update post identifying by postId
		try{
			$statement = $database->prepare("UPDATE posts SET postTitle = :postTitle, postDesc = :postDesc, postCont = :postCont WHERE postId = :postId");
			$statement->execute(array(':postTitle' => $_POST['postTitle'],
									  ':postDesc' => $_POST['postDesc'],
									  ':postCont' => $_POST['postCont'],
									  ':postId' => $_POST['postId']));
		}catch(PDOException $e){
			echo $e->getMessage();
		}

		header('Location: ../index.php');
	}



	if(isset($_POST['post'])){
		// if a file is uploaded
		if($_FILES['image']['name']){

			// if no error
			if($_FILES['image']['error']){
				echo "error uploading image";
				
			}else{
				// create an intance of post
				$post = new Post($_POST['postTitle'], $_POST['postCont'], $_POST['postDesc'], $_SESSION['userId'], $database);
				
				// the constructor creates a unique fileName using postId and time
				$fileName = $post->getFileName();
				$pathInfo = pathinfo($_FILES['image']['name']);
				$extention = $pathInfo['extension'];
				$targetFile = "images/".$fileName.".$extention";

				move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);

				//setting address of targetfile wih respect to root directory
				$targetFile = "admin/"."$targetFile";
				$post->setFileLocation($targetFile);

				//write post to postTable
				Post::writeToPostTable($post);
			}
		}	
	}

	
?>