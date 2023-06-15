
<?php
$query_slider = "SELECT * FROM post_slider";
$post_slider = $db->query($query_slider);
?>
<div class="carousel slide" data-bs-ride="carousel" data-bs-theme="dark" id="myCarousel"  style="margin: 50px 0;">
    <div class="carousel-indicators">
    <?php
        for ($i = 0; $i < $post_slider->rowCount(); $i++) {
            $active = ($i==0)? 'class="active" aria-current="true"' : '';
            echo '<button type="button" data-bs-target="#myCarousel" '. $active .'data-bs-slide-to="'.$i.'" aria-label="Slide '. $i+1 .'"></button>';
        }
        ?>
    </div>
    <div class="carousel-inner">
        <?php
        if ($post_slider->rowCount() > 0) {
            foreach ($post_slider as $slide) {
                $id_post = $slide['post_id'];
                $query_posts = "SELECT * FROM posts WHERE id=$id_post";
                $post = $db->query($query_posts)->fetch();
        ?>
                <div class="carousel-item <?php echo ($slide['active'] == 1) ? 'active' : ''; ?>" data-bs-interval="2000" style="height: 450px;">
                    <img src="./upload/<?php echo $post['media']; ?>"  class="d-block w-100" alt="Slide Image">
                    <div class="carousel-caption d-none d-md-block">
                        <h3><?php echo $post['title']; ?></h3>
                        <p><?php echo substr($post['caption'], 0, 80) . '...'; ?></p>
                        <p><a href="single.php?post=<?php echo $post['id']; ?>" class="btn btn-primary">View Post</a></p>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
    </button>
  <button  class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
    <span class="carousel-control-next-icon" aria-hidden="true" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
    </button>
</div>
