<?php   
require_once('include/config.php');
    // priviligeLevel 0 denotes the viewer and 1 and 2 blogger and admin respectively
    // if user not logged in treat as a viewer
    function userNavBar($isLoggedIn){
        if($isLoggedIn){
            echo "<li id = 'logout' class = 'navigation_element'><a href='admin/login.php'>Logout</a></li>";
            echo "<li class = 'navigation_element'><a href = 'admin/addPost.php'>New Post</a></li>";
        }else{
            echo "<li class = 'navigation_element'><a href='admin/login.php'>Register/Login</a></li>";
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
</head>
<body>

<script type="text/javascript">
    $(function(){
        $(".load_article").click(function(){
            $(this).css("display", "none");
            $(this).siblings(".post_cont").css("display", "block");
            $(this).siblings(".hide_article").css("display", "block");
        });

        $(".hide_article").click(function(){
            $(this).css("display", "none");
            $(this).siblings(".post_cont").css("display", "none");
            $(this).siblings(".load_article").css("display", "block");
        })
    })
</script>

    <div id = "navigation_bar">
        <div id = "navigation_bar_wrapper">
            <ul>
                <input id = "search_bar" type="text" name="search" placeholder="search...">
                <input type="submit" name="search_button" value="search!">
                <li class = "navigation_element"><a href="">Home</a></li>

                <?php require_once('include/config.php');
                    userNavBar($user->isLoggedIn());

                ?>
                <li class = "navigation_element"><a href="">Contact Us</a></li>
            </ul>
        </div>
    </div>
    <div id="wrapper">

        <h1 align="center" style ="font-family:sans-serif; font-style:bold; color:#2B2B2B">Blog</h1>
        <hr style="color:" />

        <?php
            try {

                $statement = $database->query('SELECT postID, postTitle, postCont, postDesc, postTime, fileName, fileLocation FROM posts ORDER BY postID DESC');
                while($row = $statement->fetch()){
                    $fileUrl = $row['fileLocation'];
                    echo '<div class = "blog_post">';
                        echo "<h1>".$row['postTitle']."</a></h1>";
                        echo "<img  class = 'postImage' src ="."'$fileUrl'"." >";
                        echo "<p class = 'post_desc'>".$row['postDesc']."</p>"; 
                        echo "<p class = 'post_cont'>".$row['postCont']."</p>";
                        echo '<p class = "post_time">Posted on '.date('jS M Y H:i:s', strtotime($row['postTime'])).'</p>';            
                        echo "<p class ='load_article'>Read More</p>"; 
                        echo "<p class = 'hide_article'>Show Less</p>";              
                    echo '</div>';

                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        ?>

    </div>

</body>
</html>