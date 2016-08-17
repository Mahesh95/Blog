
<?php
	require_once('../include/config.php');
 	// this piece of code deletes a post
    if(isset($_POST['deletePost'])){
        try{
            $statement = $database->prepare('DELETE from posts WHERE postId = :postId');
            $statement->execute(array(':postId' => $_POST['deletePost']));
        }catch(PDOException $error){
            echo $error->getMessage();
        }
    }
?>