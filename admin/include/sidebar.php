        <div class="col col-md-3 offset-1 ">
<?php
if(isset($_GET['mes']) && $_GET['mes']== 'signedin'){
    echo '<div class="alert alert-success">Welcome to your admin dashboard!</div>';
}

?>
            <div class="list-group text-start">
                <a href="index.php?page=home" class="list-group-item list-group-item-action <?php echo ((isset($_GET['page']) && $_GET['page'] == 'home') || !isset($_GET['page'])) ? "active" : ""; ?>" aria-current="true"><i class="bi bi-house-fill me-1"></i>Home</a>
                <a href="post.php?page=post" class="list-group-item list-group-item-action <?php echo (isset($_GET['page']) && $_GET['page'] == 'post') ? "active" : ""; ?>"><i class="bi bi-file-earmark-post-fill me-1"></i>Posts</a>
                <a href="comment.php?page=comment" class="list-group-item list-group-item-action <?php echo (isset($_GET['page']) && $_GET['page'] == 'comment') ? "active" : ""; ?>"><i class="bi bi-reply-all-fill me-1"></i>Comments</a>
                <!-- <a href="category.php?page=category" class="list-group-item list-group-item-action <?php // echo (isset($_GET['page']) && $_GET['page'] == 'category') ? "active" : ""; ?>"><i class="bi bi-bookmarks-fill me-1"></i>Categories</a> -->
                <a href="slider.php?page=slider" class="list-group-item list-group-item-action <?php echo (isset($_GET['page']) && $_GET['page'] == 'slider') ? "active" : ""; ?>"><i class="bi bi-file-earmark-easel-fill me-1"></i>Post Slider</a>
            </div>
        </div>