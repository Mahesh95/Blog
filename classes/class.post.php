<?php
require_once('../include/config.php');
	
	class Post{
		private $userId;
		private $postTime;
		private $postTitle;
		private $postDesc;
		private $postCont;
		private $fileName;			//name of the image file
		private $database;
		private $fileLocation;
		private $approved;

		// this constructor when creating instances to write to database
		public function __construct($postTitle, $postCont, $postDesc, $userId, $database){
			$this->postTitle = $postTitle;
			$this->postTime = date('Y-m-d H:i:s');
			$this->postDesc = $postDesc;
			$this->postCont = $postCont;
			$this->userId = $userId;
			$this->fileName = "$userId"."$this->postTime()";
			$this->database = $database;
			$this->approved = 0;
		}

		// this function writes a Post to database
		public static function writeToPostTable(Post $post){
			echo "i was called";

			try{
				$statment = $post->getDatabase()->prepare('INSERT INTO posts (userId, postTitle, postCont, postDesc, postTime, fileName, fileLocation, approved) VALUES (
					:userId, :postTitle, :postCont, :postDesc, :postTime, :fileName, :fileLocation, 0)' );

				$statment->execute(array(
					':userId' => $post->getUserId(),
					':postTitle' => $post->getPostTitle(),
					':postCont' => $post->getPostCont(),
					':postDesc' => $post->getPostDesc(),
					':postTime' => $post->getPostTime(),
					':fileName' => $post->getFileName(),
					':fileLocation' => $post->getFileLocation()
					));

				header('Location: ../index.php');

			} catch(PDOException $e){
				echo $e->getMessage();
			}

		}

		public function setFileLocation($path){
			$this->fileLocation = $path;
		}

		public function getFileLocation(){
			return $this->fileLocation;
		}

		public function getFileName(){
			return $this->fileName;
		}

		public function getUserId(){
			return $this->userId;
		}

		public function getPostTime(){
			return $this->postTime;
		}

		public function getPostTitle(){
			return $this->postTitle;
		}

		public function getPostDesc(){
			return $this->postDesc;
		}

		public function getPostCont(){
			return $this->postCont;
		}

		public function getDatabase(){
			return $this->database;
		}

		public function setApproved($isApproved){
			$this->approved = $isApproved;
		}
	}
?>
