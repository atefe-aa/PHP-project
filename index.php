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
    }elseif(isset($_GET['user'])){
        $user_id = $_GET['user'];
        $query_posts = "SELECT * FROM posts WHERE user_id=$user_id";
        $posts = $db->query($query_posts);

    }else{
        $query_posts = "SELECT * FROM posts";
        $posts = $db->query($query_posts);
    }
?>

<main>
    <div class="row">
        <!-- Posts container -->
        <div class="container-fluid col-sm-7 offset-sm-1" id="posts">
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
                        
                        echo  '<div class="col-md-6 mt-1">
                                    <div class="card h-100">
                                        <img src="./upload/'.$post['media'].'" alt="night sky" class="card-img-top" style="height: 200px;">
                                        <div class="card-body">
                                            <h3 class="card-title">'.$post['title'].'</h3>
                                            <a class="badge bg-secondary" style="background-color: gray; color: lightgray" href="index.php?category='.$category['id'].'">'.$category['title'].'</a>
                                            <span class="card-text" style="color: gray; font-size: 12px;">'.$post['date'].'</span>
                                            <p class="card-text">'.substr($post['caption'],0,50).'...</p>
                                            <p>
                                                <a href="single.php?post='.$post['id'].'" class="btn btn-success" role="button">View post</a>
                                            </p>
                                            <p class="card-text">Author: <a href="index.php?user='.$user['id'].'">'.$user['name'].'</a></p>
                                        </div>
                                    </div>
                                </div>';
                    }
                }else{
                    echo '<div class="alert alert-warning" role="alert" style="padding-left: 25px;">No posts available!</div>';
                }
                ?>
            </div>
        </div>
        
        <!-- sidebar -->
        <?php
        include("./include/sidebar.php");
        ?>
    </div>
</main>

<!-- footer -->
<?php
    include("./include/footer.php");
?>
