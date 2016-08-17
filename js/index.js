
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
        });

        // deleting post
        $(".material-icons.delete").click(function(){
            if(confirm("Are you sure you wanna delete this post?")){
                var parentDiv = $(this).parent().closest('div');
                var postId = parentDiv.children(".postId").text();
                console.log(postId);
           
                $.ajax({
                    url:'admin/deletePost.php',
                    data: 'deletePost=' + postId,
                    type: 'POST',
                    success: function(data){
                    parentDiv.css("display", "none");
                    console.log(data);

                },
                error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
                }

                });
                
            }
            
        });

        // approving posts

        $(".material-icons.lock").click(function(){
            if(confirm("approve this post")){
                var parentDiv = $(this).parent().closest('div');
                var postId = parentDiv.children(".postId").text();

                console.log(postId);

                $.ajax({
                    url: 'admin/approve.php',
                    data: 'approve_postId=' + postId,
                    type: 'POST',
                    success: function(data){
                        parentDiv.css("display", "none");
                        console.log(data);
                    }
                })
            }
        })
    });
