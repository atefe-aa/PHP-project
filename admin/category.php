<?php
    include("./include/header.php");

    $query_categories = "SELECT * FROM categories ORDER BY id DESC";
    $categories = $db->query($query_categories);

//click on a submit button like edit creat or delete category

    //if the button is creat new category
        if(isset($_POST['creatNewCategory'])){

            $category_title = htmlspecialchars($_POST['categoryTitle']);
            $query_insert_category = "INSERT INTO categories (title) VALUES (:title)";
            $category_insert = $db->prepare($query_insert_category);
            $category_insert->execute(['title'=>$category_title]);

            header("Location:category.php?page=category&msg=success");
            exit();
        }
        if(isset($_GET['action']) && isset($_GET['id'])){
            $category_id = $_GET['id'];
            $action = $_GET['action'];
            if($action == 'delete'){

                $query_delete_category = "DELETE FROM categories WHERE id=:id";
                $category_delete = $db->prepare($query_delete_category);
                $category_delete->execute(['id'=>$category_id]);

                header("Location:category.php?page=category&msg=success");
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
            <div class="row pe-3">
                <h1 class="col-10"><i class="bi bi-bookmarks-fill me-1"></i>Categories</h1>


            <!-- Button trigger modal for new category -->
                <button type="button"  class="btn btn-outline-info  col-2 " data-bs-toggle="modal" data-bs-target="#newcategory" >New Category</button>
            <!-- Modal for new category -->
                <div class="modal fade" id="newcategory" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="modalLabel">Create a new category</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form class="needs-validation" method="post" novalidate>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="title" class="fw-bold form-label">Choose a title</label>
                                        <input type="text" name="categoryTitle" class="form-control" id="title" placeholder="Title" required>
                                    </div>                           
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" name="creatNewCategory" class="btn btn-primary">Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            
            </div>
<?php
    if(isset($_GET['msg'])){
        if($_GET['msg']=='success'){
            echo '<div class="alert alert-success mt-2">Changes saved successfully!</div>';
        }else{
            echo '<div class="alert alert-danger mt-2">Saving changes failed! Try again!</div>'; 
        }
    }

?>
            <table class="table table-info table-striped">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Number of posts</th>
                    <th scope="col">Settings</th>
                    </tr>
                </thead>
                <tbody>
<?php
    if($categories->rowCount()>0){
        foreach($categories as $index => $category){

            $category_id = $category['id'];
            $query_posts = "SELECT * FROM posts WHERE category_id = $category_id";
            $numberOfPosts = $db->query($query_posts)->rowCount();

?>
                    <tr>
                        <th scope="row"><?php echo $index + 1 ; ?></th>
                        <td><?php echo $category['title'] ; ?></td>
                        <td><?php echo $numberOfPosts ; ?></td>
                        <td>
                            <a href="edit_category.php?page=category&id=<?php echo $category_id; ?>"  class="btn btn-primary">Edit</a>      
                            <a href="category.php?page=category&action=delete&id=<?php echo $category_id; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>

<?php

        }
    }else{
        echo '<div class="alert alert info">There is no category available!</div>';
    }


?>              
                </tbody>
            </table>
        </div>
    </div>
</div>




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