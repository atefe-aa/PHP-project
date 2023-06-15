
<?php
session_start();
    include("./include/header.php");
    if(isset($_GET['post'])){
        $post_id = $_GET['post'];
        $query_post = "SELECT * FROM posts WHERE id=$post_id";
        $post = $db->query($query_post)->fetch();
    }


    //click on send button
    if(isset($_POST['commentsent'])){
        if(trim($_POST['name']) !="" && trim($_POST['textarea']) != ""){
            //get the info from user
            $name = htmlspecialchars($_POST['name']);
            $comment= htmlspecialchars($_POST['textarea']);

            //send the info to data base
            $comment_insert = $db->prepare("INSERT INTO comments (name, comment, post_id, user_id) VALUES (:name , :comment ,:post_id, :user_id) ");
            if($comment_insert->execute(['name' => $name, 'comment' => $comment , 'post_id'=> $post['id'], 'user_id' => $post['user_id']])){
                
                header("Location: single.php?post=$post_id&msg=commentsuccess"); // locate user to another page to avoid resubmitting by refreshing the page
                exit();
             
            }else{
            echo '<div class="alert alert-danger">Error: Please try again!</div>';                  
            } 
            
        }else{
            echo '<div class="alert alert-danger">please fill all the fields!</div>';
        }
    }
?>


<main>
    <div class="row" style="margin-top:80px;">

   <!-- Post container -->
    <div class="container-fluid col-sm-7 offset-sm-1">
<?php 
        // if post found
        if($post){
            //get author of the post
            $post_user_id = $post['user_id'];
            $query_user = "SELECT * FROM users WHERE id=$post_user_id";
            $user = $db->query($query_user)->fetch();

            // get category of the post
            $post_category_id = $post['category_id'];
            $query_category = "SELECT * FROM categories WHERE id=$post_category_id";
            $category = $db->query($query_category)->fetch();

            //get  active comments of the post
            $post_id= $post['id'];
            $query_comments ="SELECT * FROM comments WHERE post_id=$post_id AND `status`=1";
            $comments = $db->query($query_comments);
?>
            <!-- show the post -->
            <div  class="thumbnail">
                <!-- post image -->
                <img src="./upload/<?php echo $post['media']; ?>" alt="night sky">
                <!-- post body -->
                <div class="col caption position-relative"  style="padding-left:20px">
                    <!-- post title -->
                    <h3 class="row"><?php echo $post['title']; ?></h3>
                    <!-- post author -->
                    <h6 class="row"><a  href="index.php?user=<?php echo $user['id'] ?>" style="color:gray;text-decoration: none;"> Author:<?php  echo $user['name']; ?></a></h6>
                    <!-- post category -->
                    <a class=" row btn btn-sm" style="background-color:gray;color:lightgray" href="index.php?category=<?php $category['id']?>" style="text-align:right"><?php echo $category['title']; ?></a>
                    <!-- post date -->
                    <span class="row" style="color:gray; font-size:12px;"><?php echo $post['date']; ?></span>
                    <!-- post caption -->
                    <p><?php echo $post['caption']; ?></p>
                </div>
            </div>


            <!-- comments section -->
            <div style="border: #e0dfdf 1px solid;margin-bottom: 8px;border-radius: 8px;padding: 20px;font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">
        
<?php

                //if there is any active comment for the post
                if(isset($comments)){
                    echo '<h3 style="font-weight: bolder;">Comments: </h3>
                            <p>Number of comments: '.$comments->rowCount().'</p>
                    <br/><hr>';
                    foreach($comments as $comment){
                        echo '<div style="background-color:rgb(235, 237, 238);padding:20px">
                                <span><img src="./images/avatar.jpg" style="height:50px"></span>
                                <h4 style="display:inline">'.$comment['name'].':</h4>
                                <p style="margin-left:50px;overflow:auto;">'.$comment['comment'].'</p>
                        </div><hr>';
                    }
                }
if(isset($_GET['msg'])){
    echo '<div class="alert alert-success">Comment sent successfully and will be shown after approval!</div>';
}
                
?>
                <form method="post">
                    <div class="alert alert-info"><h3>Leave a comment...</h3></div>
                    <label for="name" >Name:</label>
                    <input name="name" autocomplete="name" class="form-control" type="text" placeholder="Name">
                    <label for="textarea">Comment:</label>
                    <textarea name="textarea" id="textarea" class="form-control" rows="5"></textarea>
                    <button type="submit" name="commentsent" class="btn btn-success" style="margin-top: 20px;">Send</button>
                </form>
            </div>
<?php
            
            }else{
                echo '<div class="alert alert-warning" style="padding-left:20px">This post does not exist!</div>';
            }


           
?>
            
        </div>
        
        
        <!-- side bar -->
<?php
        include("./include/sidebar.php");
?>
    </div>
</main>


<?php
    include("./include/footer.php");
?>