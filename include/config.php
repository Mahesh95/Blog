<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	ob_start();
	session_start();
	//database credentials
	define('DBHOST', 'localhost');
	define('DBUSER', 'root');
	define('PASSWORD', 'nkymky01');
	define('DBNAME', 'blog');

	$database = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME,DBUSER,PASSWORD);
	$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//this function loads classes

	function __autoload($class){
		$class = strtolower($class);

		// if call from main directory
		$classPath = 'classes/class.'.$class.'.php';
		if(file_exists($classPath)){
			require_once($classPath) ;
		}

		//if call from admin directory

		$classPath = '../classes/class.'.$class.'.php';
		if(file_exists($classPath)){
			require_once($classPath);
		}

		//if call from within admin adjust the path
   		$classPath = '../../classes/class.'.$class . '.php';
   		if ( file_exists($classPath)) {
	      	require_once($classPath);
		} 		
	}

	// serailize user instance so that its available throughout the pages
	$user = new User($database);
?>

