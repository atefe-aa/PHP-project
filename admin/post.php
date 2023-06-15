<?php
    include("./include/header.php");

    $userId = $_SESSION['id'];
    if(isset($_GET['action']) && isset($_GET['id'])){

        $id = $_GET['id'];
        $query = $db->prepare('DELETE FROM posts WHERE id = :id');
        $query->execute(['id' => $id ]);

        header("Location: post.php?page=post"); // refresh the page
        exit();
    }


    $query_posts = "SELECT * FROM posts WHERE user_id = $userId ORDER BY id DESC";
    $posts= $db->query($query_posts);

    

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
                <h1 class="col-10"><i class="bi bi-file-earmark-post-fill me-1"></i>Posts</h1>
                <a href="new_post.php?page=new_post" type="button" class="btn btn-info btn-sm fw-bold pt-2 mt-2 col-2" style="height: 40px; width:80px;">New Post</a>
            </div>
            <table class="table table-info table-striped">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Date</th>
                    <th scope="col">Title</th>
                    <th scope="col">Category</th>
                    <th scope="col">Author</th>
                    <th scope="col">Settings</th>
                    </tr>
                </thead>
                <tbody>

<?php
    if($posts->rowCount() > 0){
        foreach($posts as $index => $post){

            //get category of the post
            $post_category_id = $post['category_id'];
            $query_category = "SELECT * FROM categories WHERE id= $post_category_id";
            $category= $db->query($query_category)->fetch();

            //get author of the post
            $post_user_id = $post['user_id'];
            $query_user = "SELECT * FROM users WHERE id=$post_user_id";
            $user = $db->query($query_user)->fetch();
            
            echo '<tr>
            <th scope="row">'.$index + 1 .'</th>
            <td>'.$post['date'].'</td>
            <td>'.$post['title'].'</td>
            <td>'.$category['title'].'</td>
            <td>'.$user['name'].'</td>
            <td>
                <a href="edit_post.php?page=edit_post&id='.$post['id'].'" class="btn btn-primary me-2">Edit</a>
                <a href="post.php?entity=post&action=delete&id='. $post['id'].'"  class="btn btn-danger  me-2">Delete</a>
            </td>
            </tr>';

        }
    }else{
        echo '<div class="alert alert-info">There is no post available!</div';
    }
?>
                </tbody>
            </table>            
        </div>
        

    </div>
</div>



<?php
    include("./include/footer.php");

?>