<?php
    include("./include/header.php");
    $uploadStatus=2;
    $userId= $_SESSION['id'];

    //query categories 
    $query_categories = "SELECT * FROM categories ORDER BY title ASC";
    $categories = $db->query($query_categories);

    //submit changes
    if(isset($_POST['submit'])){
        if(trim($_POST['title']) != "" && trim($_POST['category_id']) != "" && trim($_POST['caption']) != "" && trim($_FILES['image']['name']) != ""){

            //filter and set user inputs
            $title = htmlspecialchars($_POST['title']);
            $category_id = htmlspecialchars($_POST['category_id']);
            $caption =$_POST['caption'];

            $date= date('d-m-Y H:i:s', time());

            //check uploaded-file extension
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!in_array($_FILES['image']['type'], $allowedTypes)) {

                $_GET['msg'] = 'extensionErr';
                
            }else{
   
            //set data
                //set a uniq name for the uploaded file to prevent any malefunction access
                $media_name = uniqid() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $media_tmp_name = $_FILES['image']['tmp_name'];

                if(!move_uploaded_file($media_tmp_name, "../upload/$media_name")){
                    
                    // send an alert message
                    $_GET['msg'] = 'uploadErr';
                    
                }else{
                   //if everything is successful then update database
                    $query_add_post ="INSERT INTO posts (title, category_id, caption, media, user_id, `date`) VALUES (:title, :category_id, :caption, :media, :user_id, :timee)";
                    $add_post = $db->prepare($query_add_post);
                    $add_post->execute([ 'title'=>$title, 'category_id'=>$category_id, 'caption'=>$caption, 'media'=>$media_name, 'user_id'=> $userId, 'timee'=> $date]);
                    $uploadStatus = 1;
                    header("Location:new_post.php?page=post&msg=successful");//refresh the page
                    exit();
                }
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
            <h1><i class="bi bi-file-earmark-plus-fill"></i>Creat a new post</h1>
            <hr>
<?php
//alert messages for saving chenges
if(isset($_GET['msg'])){
    switch($_GET['msg']){
        case 'emptyFields':
            echo '<div class="alert alert-danger">Please fill out all the fields!</div>';
            break;
        case 'successful':
            echo '<div class="alert alert-success">New post has been added successfully!</div>';
            break;
        case 'uploadErr':
            echo '<div class="alert alert-danger">Upload faild!Please try again!</div>';
            break;
        case 'extensionErr':
            echo '<div class="alert alert-danger">Upload faild! File type is not accepted!</div>';
            break;
    }
}
?>
            <form method="post" class="needs-validation" novalidate enctype="multipart/form-data">
                <div class="mb-3">

                <!-- post title -->
                    <div>
                        <label for="postTitle" class="fw-bold form-label">Post Title:</label>
                        <input type="text" class="form-control" name="title" id="postTitle" placeholder="Title" aria-describedby="addon1" required>
                        <div class="invalid-feedback">
                             Please enter a Title for the post.
                        </div>
                        <div class="form-text" id="addon1">Enter the title of the post.</div>
                    </div>
                
                <!-- Author name -->
                    <div>
                        <label for="postAuthor" class="fw-bold form-label">Post Author:</label>
                        <input type="text" name="author" class="form-control" id="postAuthor" aria-describedby="addon2" disabled value="<?php echo $_SESSION['name']; ?>">
                        <div class="form-text" id="addon2">You can not change author's name!!</div>
                    </div>

                <!-- category selector -->
                    <div>
                        <label for="categorySelector" class="fw-bold form-label">Post Category:</label>
                        <select class="form-select" name="category_id" aria-label="Default select example" id="categorySelector" aria-describedby="addon3" required>
                           
<?php
//fill the options of selector with categories from database
    if($categories->rowCount() > 0){
        foreach($categories as $index => $category){
?>

                            <option value="<?php echo $category['id']; ?>"><?php echo $category['title']; ?></option>
<?php
            
        }
    }
?>
                        </select>
                        <div class="invalid-feedback">
                            Please select a category.
                        </div>
                        <div class="form-text" id="addon3">Select a category.</div>
                    </div>
                </div>
            
                <h4><strong>Content:</strong></h4>
                <textarea id="froala" name="caption" required></textarea>
                <div class="invalid-feedback">
                    Please write some caption for the post.
                </div>
                <br>
                <label for="image" class="fw-bold form-label">Image:</label>
                <input type="file" class="form-control" name="image" id="image"  aria-describedby="addon4" required>
                <div class="invalid-feedback">
                    Please provide an image.
                </div>
                <div class="form-text" id="addon4">Upload the image of the post. Note: only ".jpeg", ".jpg" and ".png" files can be uploaded!</div>
                <button type="submit" name="submit" class="btn btn-primary mt-2 mb-4"  data-bs-toggle="modal" data-bs-target="#editPostConfirm">Add post</button>
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