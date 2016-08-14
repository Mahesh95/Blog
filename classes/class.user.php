<?php

	class User{
		private $database;

		function __construct($database){
			$this->database = $database;
			$this->isActive = 1;

		}

		// this function checks whether the user is logged in or not
		public function isLoggedIn(){
			return (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true);
		}

		// this function logs in the user and sets username and userId and active status
		public function login($userName, $password){
			$password = md5($password);
			$query = $this->database->prepare('SELECT userId, userName, isActive, priviligeLevel FROM users WHERE userName = :userName and password = :password');
			$query->bindParam(':userName', $userName);
			$query->bindParam(':password', $password);

			$query->execute();

			// if no user not matched return false
			if(!$query->rowCount()){
				return false;
			}

			$_SESSION['loggedIn'] = true;
			$userData = $query->fetch(PDO::FETCH_ASSOC);
			$_SESSION['userId'] = $userData['userId'];
			$_SESSION['userName'] = $userData['userName'];
			$_SESSION['priviligeLevel'] = $userData['priviligeLevel'];
			$_SESSION['isActive'] = $userData['isActive'];

			return true;
		}

		// method to destroy session
		public function logout(){
			session_destroy();
		}
	}
?>