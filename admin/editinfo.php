<?php

include("./include/header.php");

$userId = $_SESSION['id'];
$user = $db->query("SELECT * FROM users WHERE id=$userId")->fetch();

if(isset($_POST['submit'])){
    if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])){
        $name = htmlspecialchars($_POST['name']);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $options = ['cost' => 11 ];
        $password = password_hash($_POST['password'], PASSWORD_ARGON2I, $options);
         
        $query_update_info = "UPDATE users SET `name`=:namee, email=:email, `password`=:passwordd WHERE id=$userId";
        $update_info = $db->prepare($query_update_info);
        
        if($update_info->execute(['namee'=>$name, 'email'=>$email, 'passwordd'=>$password])){
            header("Location:editinfo.php?mes=editsuccess");
            exit();   
        }else{
           $_GET['mes']='editfailed'; 
        }

        
    }else{
        
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
            <h1><i class="bi bi-pencil-square"></i>Edit Your information</h1>
            <hr>
<?php
if(isset($_GET['mes'])){
    switch($_GET['mes']){
        case 'editsuccess':
            echo '<div class="alert alert-success">Your information has been updated successfully!</div>';
            break;
        case 'emptyfields':
            echo '<div class="alert alert-danger">Please fill out all the fields!</div>';
            break; 
        case 'editfailed':
            echo '<div class="alert alert-danger">Updating your data failed! Please try again!</div>';
            break;  
    }
}
?>
            <div class="card bg-dark-subtle mb-3" >
                <div class="card-header">Please fill out all the fields.</div>
                <div class="card-body">
                    <h5 class="card-title">Your information:</h5>
                    <form method="post">
                        <div class="form-floating mb-3">
                            <input type="text" name="name" class="form-control" id="name" value="<?php echo $user['name']; ?>" required>
                            <label for="name">Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" name="email" class="form-control" id="email" value="<?php echo $user['email']; ?>" required>
                            <label for="email">Email address</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                            <label for="password">Password</label>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary form-control mt-2">Save Changes</button>
                    </form>
                    <small> <a href="deactive.php" class="text-danger">Deactive?</a></small>
                </div>
            </div>
        
       
        </div>
    </div>
</div>



<?php
    include("./include/footer.php");

?>


