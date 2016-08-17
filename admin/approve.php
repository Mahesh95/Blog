<?php
	 // ajax for approving post

	require_once('../include/config.php');

	if(isset($_POST['approve_postId'])){
		try{
			$statement = $database->prepare("UPDATE posts SET approved = 1 WHERE postId = :postId");
			$statement->execute(array(':postId' => $_POST['approve_postId']));	
		}catch(PDOException $error){
			echo $error->getMessage;
		}
		
	}
?>