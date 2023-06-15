<?php
    include("./include/header.php");
    if(isset($_GET['search'])){
        $keyword = $_GET['search'];

        $posts = $db->prepare('SELECT * FROM posts WHERE title LIKE :keyword or caption LIKE :keyword');
        $posts->execute(['keyword'=> "%$keyword%"]);
  
    }
?>
<main style="margin-top: 90px;">
    <div class="row">



        <!-- Posts container -->
        <div class="container-fluid col-sm-7 offset-sm-1" id="posts">
        <div class="row">
            <?php  
                if($posts->rowCount()>0){
                    echo '<div class="alert alert-info" style="padding-left:25px">'.$posts->rowCount().' results found for: '.$keyword.'</div>';
                    foreach($posts as $post){
                        $post_category_id = $post['category_id'];
                        $query_category = "SELECT * FROM categories WHERE id=$post_category_id";
                        $category = $db->query($query_category)->fetch();
                        $post_user_id = $post['user_id'];
                        $query_user = "SELECT * FROM users WHERE id=$post_user_id";
                        $user = $db->query($query_user)->fetch();
                        echo  '<div class="col-md-6" >
                        <div  class="card">
                            <img src="./upload/'.$post['media'].'" alt="night sky">
                            <div class="col caption position-relative"  style="padding-left:20px">
                                <h3 >'.$post['title'].'</h3>
                                <a class="row btn btn-sm" style="background-color:gray;color:lightgray" href="index.php?category='. $category['id'].'">'. $category['title'].'</a>
                                <span class="row" style="color:gray; font-size:12px;">'.$post['date'].'</span>
                                <p>'.substr($post['caption'],0,50).'...</p>
                                <p >
                                    <a href="single.php?post='.$post['id'].'" class="btn btn-success" role="button">Veiw post</a>
                                </p>
                                <p >Author:  <a href="index.php?user='.$user['id'].'">'.$user['name'].'</a></p>
                            </div>
                        </div>
                    </div>';
                    }
                }else{
                    echo '<div class="alert alert-warning" style="padding-left:25px">No post found!</div>';
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


<?php
    include("./include/footer.php");
?>