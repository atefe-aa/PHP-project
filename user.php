
    <!-- header -->
    <?php
    // navbar
    include("./include/header.php");

    // slider
    include("./include/slider.php");
    if(isset($_GET['category'])){
        $category_id = $_GET['category'];
        $query_posts = "SELECT * FROM posts WHERE category_id=$category_id";
        $posts = $db->query($query_posts);
    }else{
        $query_posts = "SELECT * FROM posts";
        $posts = $db->query($query_posts);
    }
?>

    <main style="margin-top:80px;">
      <div class="row mt-2">

        <!-- Posts container -->
        <div class="container-fluid col-sm-7 offset-sm-1 " id="posts">
          <div class="row">
            <?php  
                if($posts->rowCount()>0){
                    foreach($posts as $post){

                        $post_category_id = $post['category_id'];
                        $query_category = "SELECT * FROM categories WHERE id=$post_category_id";
                        $category = $db->query($query_category)->fetch();


                        $post_user_id = $post['user_id'];
                        $query_user = "SELECT * FROM users WHERE id=$post_user_id";
                        $user = $db->query($query_user)->fetch();
                        
                        echo  '<div class="col-md-6" >
                        <div  class="thumbnail">
                            <img src="./upload/'.$post['media'].'" alt="night sky" style="height:200px">
                            <div class="row caption position-relative"  style="padding-left:20px">
                                <h3 class="col">'.$post['title'].'</h3>
                                <a class=" badge badge-secondary" style="background-color:gray;color:lightgray" href="index.php?category='. $category['id'].'" style="text-align:right">'. $category['title'].'</a>
                                <span class="col position-absolute bottom-50 end-50" style="color:gray; font-size:12px;">'.$post['date'].'</span>
                                <p>'.substr($post['caption'],0,50).'...</p>
                                <p class="col">
                                    <a href="single.php?post='.$post['id'].'" class="btn btn-success" role="button">Veiw post</a>
                                </p>
                                <p class="col end">Author: '.$user['name'].'</p>
                            </div>
                        </div>
                    </div>';
                    }
                }else{
                    echo '<div class="alert alert-warning" style="padding-left:25px">No post available!</div>';
                }
            
            ?>
             
          </div>
        </div>
        
        
        <!-- side bar -->
<?php
        include("./include/sidebar.php");
?>
      </div>
    </main>

    <!-- footer -->
<?php
    include("./include/footer.php");
?>
