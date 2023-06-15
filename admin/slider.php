<?php
    include("./include/header.php");

    $userId = $_SESSION['id'];
    if(isset($_POST['submit'])){
        if(isset($_POST['selected'])){  
            foreach($_POST['selected'] as $selectPost){
         
                $query_insert_slider = "INSERT INTO post_slider (post_id, active, user_id) VALUES ($selectPost, 0, $userId )";
                $insert_slider = $db->query($query_insert_slider);

            }
            
            header("Location:slider.php?page=slider&msg=addSuccessful");
            exit();
        }
    }
    $query_slider = "SELECT * FROM post_slider WHERE user_id = $userId";
    $slides = $db->query($query_slider);

//click on a submit button like approve or delete 
    if(isset($_GET['action']) && isset($_GET['id'])){

        $id = $_GET['id'];

        if($_GET['action']=='delete'){

            $query_delete_slide = "DELETE FROM post_slider WHERE id=:id";
            $slide_delete = $db->prepare($query_delete_slide)->execute(['id'=>$id]);
            header("Location:slider.php?page=slider");
            exit();

        }else{

            $on =1;
            
            // inactive slide which is already active
            $query_inactive_slide = "UPDATE post_slider SET active =0 WHERE active =1 ";
            $slide_inactive = $db->query($query_inactive_slide);

            //active new slide
            $query_active_slide = "UPDATE post_slider SET active=:active WHERE id=$id";
            $slide_active = $db->prepare($query_active_slide)->execute(['active'=>$on]);
            
            header("Location:slider.php?page=slider");
            exit();  
        }

    }

     
        
    
?>  


<div class="container-fluid mt-2 text-center">
    <div class="row">

    <!-- Side bar -->
<?php 
include('./include/sidebar.php');

?>
    <!-- main content -->
        <div class="col col-md-7 ms-2 text-start">
            <h1 class="col-10"><i class="bi bi-file-earmark-play"></i> Slides in slider</h1>
<?php

if(isset($_GET['msg']) && $_GET['msg']== 'addSuccessful'){
    echo '<div class="alert alert-success">Posts added to the slider successfully! Change the active post if you want.</div>';
}
?>
            <table class="table table-info table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Post Title</th>
                        <th scope="col">Active Status</th>
                        <th scope="col">Settings</th>
                    </tr>
                </thead>
                <tbody>
<?php
    $slidesArray = array();
    if($slides->rowCount()>0){
        foreach($slides as $index => $slide){

            $post_id = $slide['post_id'];
            $query_posts_in = "SELECT * FROM posts WHERE id = $post_id";
            $post_in = $db->query($query_posts_in)->fetch();

            array_push($slidesArray, $post_in['id']);

?>
                    <tr>
                        <th scope="row"><?php echo $index + 1 ; ?></th>
                        <td><?php echo $post_in['title'] ; ?></td>
                        <td><?php echo ($slide['active']==1)? 'on':'off' ; ?></td>
                        <td>
                            <?php
                                echo ($slide['active'] == 1 )? '' : '<a href="slider.php?page=slider&action=active&id='.$slide['id'].'" class="btn btn-primary" >Active</a>' ;
                            ?>      
                            <a href="slider.php?page=slider&action=delete&id=<?php echo $slide['id']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>

<?php

        }
    }else{
        echo '<div class="alert alert-info">There is no slide available!</div>';
    }


?>              
                </tbody>
            </table>
            <h1 class="col-10"><i class="bi bi-file-earmark-plus-fill me-1"></i> Add new posts to the slider:</h1>
            <form method="post">
                <select class="form-select" name="selected[]" multiple aria-describedby="addon">
<?php
    $query_posts = "SELECT * FROM posts WHERE user_id = $userId";
    $posts = $db->query($query_posts);
    if($posts->rowCount() > 0){
        foreach($posts as $post){
            if(!in_array($post['id'], $slidesArray)){
    
                echo '<option class="border rounded ps-2 mb-1 " value="'.$post['id'].'">'.$post['title'].'</option>';
            }
        }
    }else{
        echo '<div class="alert alert-warning">No post available!</div>';
    }

?>
                </select>
                <div class="form-text" id="addon">Select posts you want to add to the slider.</div>
                <button class="btn btn-info form-control mt-2" name="submit" type="submit">Add</button>
            </form>
        </div>
    </div>
</div>



<?php
    include("./include/footer.php");

?>