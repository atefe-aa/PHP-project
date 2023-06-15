<?php
    include("./include/header.php");

    $userId = $_SESSION['id'];

    if(isset($_GET['entity']) && isset($_GET['action'])  &&  isset($_GET['id'])){
        $entity = $_GET['entity'];
        $action = $_GET['action'];
        $id = $_GET['id'];


        if($action== "delete"){

            if($entity == "post"){
                //delete post
                $query = $db->prepare('DELETE FROM posts WHERE id = :id ');
                   

            }elseif($entity == 'comment'){
                //delete comment
                $query = $db->prepare("DELETE FROM comments WHERE id= :id ");

            }else{
                //delete category
                $query = $db->prepare("DELETE FROM categories WHERE id= :id ");

            }

            $query->execute(['id' => $id, 'user_id' => $userId]);

        }elseif($action == 'approve'){
            //approve comment
            $query = $db->prepare("UPDATE  comments SET `status`=1 WHERE `id`=:id ");
            $query->execute(['id' => $id ]);

        }else{
            //edit category
            $newTitle = $_POST['newTitle'];
            $query = $db->prepare("UPDATE categories SET title=$newTitle  WHERE id= :id ");
            $query->execute(['id' => $id ]);
        }
    }


    // query for posts
    $query_posts = "SELECT * FROM posts WHERE user_id = $userId ORDER BY id DESC LIMIT 5";
    $posts = $db->query($query_posts);

    // query for comments
    $query_comments = "SELECT * FROM comments WHERE user_id = $userId AND `status`=0 ORDER BY id DESC";
    $comments = $db->query($query_comments);


    //query for categories
    // $query_categories = "SELECT * FROM categories ORDER BY id DESC LIMIT 5";
    // $categories = $db->query($query_categories);
?>  


<div class="container-fluid mt-2 text-center">
    <div class="row">

    <!-- Side bar -->
<?php 
include('./include/sidebar.php');

?>
    <!-- main content -->
        <div class="col col-md-7 ms-2 text-start">
            <div><h1><i class="bi bi-house-fill me-1"></i>Home</h1></div>
            <ul class="list-group">
                <li class="list-group-item"><h3>Recent Posts</h3>
                    <table class="table table-info table-striped">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Date</th>
                            <th scope="col">Title</th>
                            <th scope="col">Author</th>
                            <th scope="col">Settings</th>
                            </tr>
                        </thead>
                        <tbody>
<?php
    if($posts->rowCount() > 0){
        foreach($posts as $index => $post){

            //get author of the post
            $post_user_id = $post['user_id'];
            $query_user = "SELECT * FROM users WHERE id=$post_user_id";
            $user = $db->query($query_user)->fetch();
    
            echo '<tr>
            <th scope="row">'.$index + 1 .'</th>
            <td>'.$post['date'].'</td>
            <td>'.$post['title'].'</td>
            <td>'.$user['name'].'</td>
            <td>
                <a href="edit_post.php?page=post&id='.$post['id'].'" class="btn btn-primary me-2">Edit</a>
                <a href="index.php?entity=post&action=delete&id='. $post['id'].'"  class="btn btn-danger">Delete</a>
            </td>
            </tr>';

        }
    }else{
        echo '<div class="alert alert-info">There is no post available!
        <a href="new_post.php?page=new_post" type="button" class="btn btn-info" >New Post</a>
        </div';
    }
?>
                        </tbody>
                    </table>
                </li>
                <li class="list-group-item "><h3>Recent Comments</h3>
                    <table class="table table-info table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Post Title</th>
                                <th scope="col">Name</th>
                                <th scope="col">Comment</th>
                                <th scope="col">Settings</th>
                            </tr>
                        </thead>
                        <tbody>
<?php
    if($comments->rowCount() > 0){


        foreach($comments as $index => $comment){

            //get post title
            $post_id = $comment['post_id'];
            $query_post_id = "SELECT * FROM posts WHERE id=$post_id";
            $post = $db->query($query_post_id)->fetch();
    
             echo '<tr>
            <th scope="row">'.$index + 1 .'</th>
            <td>'.$post['title'].'</td>
            <td>'.$comment['name'].'</td>
            <td>'.$comment['comment'].'</td>
            <td>
                <a href="index.php?entity=comment&action=approve&id='.$comment['id'].'" class="btn btn-sm btn-outline-info me-2">Confirm</a>
                <a href="index.php?entity=comment&action=delete&id='.$comment['id'].'" class="btn btn-sm btn-outline-danger mt-2">Delete</a>
            </td>
            </tr>';
           
         }
    }else{
        echo '<div class="alert alert-info">There is no comment available!</div';
    }


?>
                            
                            
                        </tbody>
                    </table>            
                </li>


                <!-- categories -->
                <!-- <li class="list-group-item "><h3>Categories</h3>
                    <table class="table table-info table-striped">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Number of posts</th>
                            <th scope="col">Settings</th>
                            </tr>
                        </thead>
                        <tbody> -->

<?php
    // if($categories->rowCount()>0){
    //     foreach($categories as $index => $category){
    //         $categoryid=$category['id'];
    //         $query_post_category = "SELECT * FROM posts WHERE category_id = $categoryid ";
    //         $posts_in_category = $db->query($query_post_category);
            
    //         echo '<tr>
    //         <th scope="row">'.$index + 1 .'</th>
    //         <td>'.$category['title'].'</td>
    //         <td>'.$posts_in_category->rowCount().'</td>
    //         <td>';
?>
                <!-- <a  href="edit_category.php?page=category&id=<?php echo $categoryid; ?>" class="btn btn-primary me-2">Edit</a>
                <a href="index.php?entity=category&action=delete&id=<?php echo $categoryid ?>"  class="btn btn-danger">Delete</a>
            </td>
            </tr> -->



<?php
    //     }
    // }else{
    //     echo '<div class="alert alert-info">There is no category available!</div';
    // }

?>
                            
                        <!-- </tbody>
                    </table>            
                </li> -->
            </ul>
        </div>

    </div>
</div>



<?php
    include("./include/footer.php");

?>




