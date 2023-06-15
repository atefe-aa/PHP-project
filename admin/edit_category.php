<?php
    include("./include/header.php");

    if(isset($_GET['id'])){

        $category_id = $_GET['id'];

        $query_categories = "SELECT * FROM categories WHERE id=$category_id";
        $category = $db->query($query_categories)->fetch();
        $category_title = $category['title'];
        
    }
    
    //if the button is edit category
        if(isset($_POST['editCategory'])){

            $category_title = htmlspecialchars($_POST['categoryTitle']);
            $query_update_category = "UPDATE  categories SET title=:title WHERE id=$category_id";
            $category_update = $db->prepare($query_update_category);
            $category_update->execute(['title'=>$category_title]);

            header("Location:category.php?page=category&msg=success");
            exit();
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
                <h1 class="col-10"><i class="bi bi-pencil-square"></i>Edit Category:</h1>
                <form class="needs-validation" method="post" novalidate>
                    <label for="title" class="fw-bold form-label">Choose a new title:</label>
                    <input type="text" name="categoryTitle" class="form-control mb-3" id="title" value="<?php echo $category_title; ?>" required>
                    <button type="submit" name="editCategory" class="btn btn-info form-control">Edit</button>
                </form>
                        
            </div>
 
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