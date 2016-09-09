<?php   
require_once('include/config.php');
    // priviligeLevel 0 denotes the viewer and 1 and 2 blogger and admin respectively
    // if user not logged in treat as a viewer
    function userNavBar($isLoggedIn){
        if($isLoggedIn){
            echo "<li id = 'logout' class = 'navigation_element'><a href='index.php?logout=1'>Logout</a></li>";
            echo "<li class = 'navigation_element'><a href = 'admin/addPost.php'>New Post</a></li>";
            echo "<li class = 'navigation_element'><a href = 'index.php?myPosts=1'>My Posts</a></li>";
            echo "<li class = 'navigation_element'><a href = 'index.php?pending_posts=1'>Pending</a></li>";

        }else{
            echo "<li class = 'navigation_element'><a href='admin/login.php'>Register/Login</a></li>";
            echo "<li class = 'navigation_element'><a href=''>Contact Us</a></li>";
        }
    }

    //this piece of code executes on user presses logout button
    if(isset($_GET['logout'])){
        session_destroy();
        header('Location: index.php');
    }

    // funtion to search in posts
    function searchPosts($searchInput){
        $database = $GLOBALS['database'];

        try{
            $statement = $database->prepare('SELECT * FROM posts WHERE (approved = 1 AND postTitle LIKE :searchInput)
            OR (approved = 1 AND postDesc LIKE :searchInput) OR (approved = 1 AND postCont LIKE :searchInput) ORDER BY postId DESC');
            $statement->execute(array(":searchInput" => "%$searchInput%"));

            createPosts($statement);

        }catch(PDOException $error){
            echo $error->getMessage();
        }
    }


    //this function creates posts from query statement
    function createPosts($statement){
        while($row = $statement->fetch()){
                    $fileUrl = $row['fileLocation'];
                    echo "<div class = 'blog_post'>";
                        echo "<h1 class = 'postTitle'>".$row['postTitle']."</a></h1>";
                        // alow deleting only if user is admin
                        if(isset($_SESSION['priviligeLevel']) && $_SESSION['priviligeLevel'] == 2){
                            echo "<i class = 'material-icons delete'>delete</i>";
                        }

                        // allow editing only if post written by user
                        if(isset($_SESSION['userId']) && $_SESSION['userId'] == $row['userId']){
                            echo "<i class = 'material-icons edit'><a href = 'admin/addPost.php?postId=".$row['postId']."'>mode_edit</a></i>";
                        }

                        echo "<img  class = 'postImage' src ="."'$fileUrl'"." >";

                        //postId is hidden, will be handy for ajax
                        echo "<p class = 'postId'>".$row['postId']."</p>";

                        echo "<p class = 'post_desc'>".$row['postDesc']."</p>"; 
                        echo "<p class = 'post_cont'>".$row['postCont']."</p>";
                        echo '<p class = "post_time">Posted on '.date('jS M Y H:i:s', strtotime($row['postTime'])).'</p>';            
                        echo "<p class ='load_article'>Read More</p>"; 
                        echo "<p class = 'hide_article'>Show Less</p>";   

                        //this icon approves post on click, it's visible when pending posts are opened by admin
                        if(isset($_GET['pending_posts']) && $_SESSION['priviligeLevel'] == 2){
                            echo "<i class = 'material-icons lock'>vpn_key</i>";
                        }           
                    echo "</div>";
        }            
    }


    //this function queries the posts table and fills the page with posts
    function getPosts($userId, $approved){
            try{
                //fetch all posts if userId = 0
                $database = $GLOBALS['database'];

                if($userId == 0){
                    $statement = $database->prepare('SELECT postId, userId, postTitle, postCont, postDesc, postTime, fileName, fileLocation FROM posts WHERE approved = :approved ORDER BY postID DESC');
                
                    $statement->execute(array(':approved' => $approved));    
                }else{
                    $statement = $database->prepare('SELECT postId, userId, postTitle, postCont, postDesc, postTime, fileName, fileLocation FROM posts Where userId = :userId AND approved = :approved ORDER BY postID DESC');

                    $statement->execute(array(':userId' => $userId, ':approved' => $approved));

                }
                
                createPosts($statement);
            }catch(PDOException $error){
                    echo $error->getMessage();
            }
        }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Blog</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style/main.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script type="text/javascript" src = "js/index.js"></script>
</head>
<body>

    <div id = "navigation_bar">
        <div id = "navigation_bar_wrapper">
            <ul>
                <form style = "display:inline;">
                    <input id = "search_bar" type="text" name="search" placeholder="search...">
                    <input type="submit" name="search_button" value="search!">
                </form>
                <li class = "navigation_element"><a href="index.php">Home</a></li>

                <?php require_once('include/config.php');
                    userNavBar($user->isLoggedIn());

                ?>
            </ul>
        </div>
    </div>
    <div id="wrapper">

        <h1 align="center" style ="font-family:sans-serif; font-style:bold; color:#2B2B2B">Blog</h1>
        <hr style="color:" />

        <?php
            if(isset($_GET['myPosts'])){
                // first loads approved posts and then pending posts
                getPosts($_SESSION['userId'], 1);
                getPosts($_SESSION['userId'], 0);
            }

            // following code loads pending posts
            else if (isset($_GET['pending_posts'])){
                // if user is admin let him see all pending posts and if user blogger let him see only his pending posts
                if($_SESSION['priviligeLevel'] == 2){
                    getPosts(0,0);    
                }else{
                    getPosts($_SESSION['userId'], 0);
                }
                
            }

            // for search query
            else if(isset($_GET['search_button']) && isset($_GET['search'])){
                searchPosts($_GET['search']);
            }
            // otherwise user is just viewer, let him see only approved posts
            else{
                getPosts(0,1);
            }
        ?>

    </div>

</body>
</html>