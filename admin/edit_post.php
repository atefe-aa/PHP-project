<?php
    include("./include/header.php");
    $uploadStatus=2;
    if(isset($_GET['id'])){
        
        $post_id = $_GET['id'];
        $query_post = "SELECT * FROM posts WHERE id = $post_id";
        $post = $db->query($query_post)->fetch();

        $user_id = $post['user_id'];
        $query_user = "SELECT * FROM users WHERE id = $user_id";
        $user = $db->query($query_user)->fetch();
        $author = $user['name'];
    }

    //query categories 
    $query_categories = "SELECT * FROM categories ORDER BY title ASC";
    $categories = $db->query($query_categories);

    //submit changes
    if(isset($_POST['submit'])){
        if(trim($_POST['title']) != "" && trim($_POST['category_id']) != "" && trim($_POST['caption']) != ""){
            
            //filter user inputs
            $title = htmlspecialchars($_POST['title']);
            $author = htmlspecialchars($_POST['author']);
            $category_id = htmlspecialchars($_POST['category_id']);
            $caption =$_POST['caption'];
            
        //if media has changed
            if(trim($_FILES['image']['name']) != ""){

                //check uploaded-file extension
                $allowedTypes = ['image/jpeg', 'image/png'];
                if (!in_array($_FILES['image']['type'], $allowedTypes)) {

                    //error for extension
                    $uploadStatus = "File type is not allowed! You can only upload jpeg and png files.";
                   
                }else{

                //set data
                    //set a uniq name for the uploaded file to prevent any malefunction access
                    $media_name = uniqid() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $media_tmp_name = $_FILES['image']['tmp_name'];

                    if(move_uploaded_file($media_tmp_name, "../upload/$media_name")){
                        //set upload status to send an alert message if nessesury
                        $uploadStatus = 1;
                        
                        //if everything is successful then update database
                        $query_update_post ="UPDATE posts SET title=:title, category_id=:category_id, caption=:caption, media=:media WHERE id=$post_id";
                        $update_post = $db->prepare($query_update_post);
                        $update_post->execute([ 'title'=>$title, 'category_id'=>$category_id, 'caption'=>$caption, 'media'=>$media_name]);
                    
                        header("Location:edit_post.php?page=edit_post&id=$post_id&msg=successful");//refresh the page
                        exit();
                    }else{
                        //set upload status to send an alert message
                        $uploadStatus = 0;
                        }
                }
   
            }else{
                //if media hasn't changed update database
                $query_update_post ="UPDATE posts SET title=:title, category_id=:category_id, caption=:caption WHERE id=$post_id";
                $update_post = $db->prepare($query_update_post);
                $update_post->execute([ 'title'=>$title, 'category_id'=>$category_id, 'caption'=>$caption]);
            
                header("Location:edit_post.php?page=edit_post&id=$post_id&msg=successful");//refresh the page
                exit();
            }


        }else{
            $_GET['msg'] = 'emptyFields';
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
            <h1><i class="bi bi-pencil-square"></i>Edit post</h1>
            <hr>
<?php
//alert messages for saving chenges
    if(isset($_GET['msg'])){
        if($_GET['msg']== 'emptyFields'){
            echo '<div class="alert alert-danger">Please fill out all the fields!</div>';
        }else{
            echo '<div class="alert alert-success">Changes saved successfully!</div>';
        }
        
    }
?>
            <form method="post" class="needs-validation" novalidate enctype="multipart/form-data">
                <div class="mb-3">

                <!-- post title -->
                    <div>
                        <label for="postTitle" class="fw-bold form-label">Post Title:</label>
                        <input type="text" class="form-control" name="title" id="postTitle" value="<?php echo $post['title']; ?>" aria-describedby="addon1" required>
                        <div class="form-text" id="addon1">Change the title of the post.</div>
                    </div>
                
                <!-- Author name -->
                    <div>
                        <label for="postAuthor" class="fw-bold form-label">Post Author:</label>
                        <input type="text" name="author" class="form-control" id="postAuthor" value="<?php echo $author; ?>" aria-describedby="addon2" disabled>
                        <div class="form-text" id="addon2">You cannot change Author's name.</div>
                    </div>

                <!-- category selector -->
                    <div>
                        <label for="categorySelector" class="fw-bold form-label">Post Category:</label>
                        <select class="form-select" name="category_id" aria-label="Default select example" id="categorySelector" aria-describedby="addon3" required>
<?php
//fill the options of selector with categories from database
    if($categories->rowCount() > 0){
        foreach($categories as $category){
?>
                            <option <?php echo ($category['id'] == $post['category_id'])? 'selected' : "" ?> value="<?php echo $category['id']; ?>"><?php echo $category['title']; ?></option>
<?php         
        }
    }
?>
                        </select>
                        <div class="form-text" id="addon3">Change category.</div>
                    </div>
                </div>
            
                <h4><strong>Content:</strong></h4>
                <textarea id="froala" name="caption" required><?php echo $post['caption'];  ?></textarea>
                <br>
                <label for="image" class="fw-bold form-label">Image:</label>
                <img class="img-fluid rounded mb-2" style="height: 100px;" src="../upload/<?php echo $post['media']; ?>">
<?php

//alert messages for uploading image
    if($uploadStatus == 0){
        echo '<div class="alert alert-danger ">Apload failed!<br><strong>Error: </strong>'.$_FILES['image']['error'].'</div>';
    }elseif($uploadStatus == 1){
        echo '<div class="alert alert-success ">Image has been uploaded successfully!</div>';
    }elseif($uploadStatus == 2){
        echo '';
    }else{
        echo '<div class="alert alert-danger ">Apload failed! '.$uploadStatus.'</div>';
    }

?>
                <input type="file" class="form-control" name="image" id="image"  aria-describedby="addon4">
                <div class="form-text" id="addon4">Change the image of the post. Note: only ".jpeg" and ".png" files!</div>
                <button type="submit" name="submit" class="btn btn-primary mt-2 mb-4"  data-bs-toggle="modal" data-bs-target="#editPostConfirm">Save Changes</button>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript" src="node_modules/froala-editor/js/froala_editor.pkgd.min.js"></script>
<script> var editor = new FroalaEditor('#froala'); </script>

<script>
    // JavaScript for disabling form submissions if there are invalid fields
(() => {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })
})()
</script>
<?php
    include("./include/footer.php");

?>