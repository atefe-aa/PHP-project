<?php
    include("./include/header.php");

    $userId = $_SESSION['id'];
    $query_comments = "SELECT * FROM comments WHERE user_id = $userId ORDER BY id DESC";
    $comments = $db->query($query_comments);

//click on a submit button like approve or delete 
    if(isset($_GET['action']) && isset($_GET['id'])){

        $id = $_GET['id'];

        if($_GET['action']=='delete'){

            $query_delete_comment = "DELETE FROM comments WHERE id=:id";
            $comment_delete = $db->prepare($query_delete_comment);
            $comment_delete->execute(['id'=>$id]);

            header("Location:comment.php?page=comment");
            exit();

        }else{
            $query_approve = "UPDATE comments SET `status`=1 WHERE id=:id";
            $approve_comment = $db->prepare($query_approve)->execute(['id' => $id]);

            header("Location:comment.php?page=comment");
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
        <div class="col  col-md-7 ms-2 text-start">
            <h1 class="col-10"><i class="bi bi-reply-all-fill me-1"></i>Comments</h1>
            <table class="table table-info table-striped" style="overflow:auto">
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
    if($comments->rowCount()>0){
        foreach($comments as $index => $comment){

            $post_id = $comment['post_id'];
            $query_posts = "SELECT * FROM posts WHERE id = $post_id";
            $post = $db->query($query_posts)->fetch();

?>
                    <tr>
                        <th scope="row"><?php echo $index + 1 ; ?></th>
                        <td><?php echo $post['title'] ; ?></td>
                        <td><?php echo $comment['name'] ; ?></td>
                        <td><?php echo $comment['comment'] ; ?></td>
                        <td>
                            <?php
                                echo ($comment['status'] == 1 )? '<a href="#" class="btn btn-sm btn-outline-primary  disabled" >Approved</a>' : '<a href="comment.php?page=comment&action=approve&id='.$comment['id'].'" class="btn btn-sm btn-primary" >Approve</a>' ;
                            ?>      
                            <a href="comment.php?page=comment&action=delete&id=<?php echo $comment['id']; ?>" class="btn mt-2 btn-danger">Delete</a>
                        </td>
                    </tr>

<?php

        }
    }else{
        echo '<div class="alert alert-info">There is no Comment available!</div>';
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