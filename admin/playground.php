<?php
    include("./include/header.php");

    if(isset($_GET['action'])  &&  isset($_GET['id'])){
        $action = $_GET['action'];
        $id = $_GET['id'];


        if($action == "delete"){
            //delete category
            $query = $db->prepare("DELETE FROM categories WHERE id= :id ");
            $query->execute(['id' => $id ]);


        }else{
            //edit category
            if(isset($_GET['newTitle'])){
                $newTitle = $_GET['newTitle'];
                $query = $db->prepare("UPDATE categories SET title=$newTitle  WHERE id= :id "); 
                $query->execute(['id' => $id ]);


            }else{
                echo '<p>error getting new category title!</p>';
                echo '<p>error getting new category title!</p>';
                echo '<p>error getting new category title!</p>';
                echo '<p>error getting new category title!</p>';
                echo '<p>error getting new category title!</p>';
            }
        }
    }

    //query for categories
    $query_categories = "SELECT * FROM categories ORDER BY id DESC";
    $categories = $db->query($query_categories);
?>
<div class="container-fluid mt-2 text-center">
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
            $categoryid=$category['id'];
            $query_post_category = "SELECT * FROM posts WHERE category_id = $categoryid ";
            $posts_in_category = $db->query($query_post_category);
            
            echo '<tr>
            <th scope="row">'.$index + 1 .'</th>
            <td>'.$category['title'].'</td>
            <td>'.$posts_in_category->rowCount().'</td>
            <td>';
?>
    
                <!-- Button trigger modal for edit category -->
                <button type="button"  class="btn btn-outline-info  col-2 " data-bs-toggle="modal" data-bs-target="#editcategory" >edit</button>
           

                <a href="playground.php?action=delete&id=<?php echo $categoryid ?>"  class="btn btn-danger">Delete</a>
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
            </td>
            </tr>
<?php
        }
    }else{
        echo '<div class="alert alert-info">There is no category available!</div';
    }

?>    
 <!-- Modal for edit category -->
 <div class="modal fade" id="editcategory" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="modalLabel">Edit category</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form class="needs-validation" method="get" novalidate>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="id" class="fw-bold form-label">Category id</label>
                                        <input type="text" name="id" class="form-control disabled" id="id" placeholder="Title" value="<?php echo $categoryid; ?>">
                                        <label for="title" class="fw-bold form-label">Choose new title</label>
                                        <input type="text" name="categoryTitle" class="form-control" id="title" placeholder="Title" value="<?php echo $category['title']; ?>" required>
                                    </div>                           
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <a href="playground.php?action=edit&id=<?php echo $categoryid; ?>" type="submit" class="btn btn-primary">Create</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                
        </tbody>
    </table>            
</div>
<?php
    include("./include/footer.php");

?>