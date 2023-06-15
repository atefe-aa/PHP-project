
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

include("./include/config.php");
include("./include/db.php");

if(isset($_POST['submit'])){

    if(isset($_POST['email']) && isset($_POST['password'])){
        $user_email = $_POST['email'];
        $user_password = $_POST['password'];

        try {
            // Database operations  
        $query_user = "SELECT * FROM users WHERE email = :email";
        $select_user_stmt = $db->prepare($query_user);
        $select_user_stmt->execute(['email'=> $user_email]);
        $user = $select_user_stmt->fetch();
        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
        }
        
       
    

        print_r($user) ;
        echo "row count: " .$select_user_stmt->rowCount();

        if($select_user_stmt->rowCount() == 1){
            if(password_verify($user_password, $user['password'])){ 
                 
                $_SESSION['id']=$user['id'];
                $_SESSION['name']=$user['name'];
                $_SESSION['email']=$user['email'];
                $_SESSION['password']=$user['password'];
                header("Location:index.php?mes=signedin");
                exit();

            }else{
                header("Location:signin.php?mes=passerr");
                exit();
            }
        }else{
            header("Location:signin.php?mes=notfound");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>My Website: Sign up</title>
        <link rel="stylesheet" href="../css/style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
        <link href="node_modules/froala-editor/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <nav class="navbar navbar-expand-lg bg-body-tertiary  bg-dark"  data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="./index.php">My Website</a>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" name="search" id="search" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </nav>

        <div class="container-fluid" style="position: relative;">
            <div class="card bg-success-subtle mb-3" style="width: 70vh; position:absolute; top: 20vh; right:80vh;">
<?php
 if(isset($_GET['mes'])){
    switch($_GET['mes']){
        case 'signedup':
            echo '<div class="alert alert-success"><strong>Welcome to our fantastic comunity!</strong></div>';
            break;
        case 'passerr':
            echo '<div class="alert alert-danger"><strong>Password does not match!</strong></div>';
            break;
        case 'notfound':
            echo '<div class="alert alert-danger"><strong>Could not find this email address !</strong></div>';
            break;
        case 'notsignedin':
            echo '<div class="alert alert-info"><strong>You must sign in first!</strong></div>';
            break;
    }  
 }

?>
                <div class="card-header">Sign in</div>
                <div class="card-body">
                    <h5 class="card-title">Please fill out all the fields.</h5>
                    <form method="post">
                        <div class="form-floating mb-3">
                            <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com" required>
                            <label for="email">Email address</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                            <label for="password">Password</label>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary form-control mt-2">Sign in!</button>
                    </form>
                    <small>Don't have an account? <a href="../signup.php">Sign up</a></small>
                </div>
            </div>
        </div>
    
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    </body>
</html>