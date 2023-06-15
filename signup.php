<?php
include("./include/config.php");
include("./include/db.php");



if(isset($_POST['submit'])){

    if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $options = ['cost' => 11 ];
        $hashed_password = password_hash($password,PASSWORD_ARGON2I, $options);

        $query_user = "INSERT INTO users (`name`, email, `password`) VALUES (:name, :email, :password)";
        $insert_user = $db->prepare($query_user)->execute(['name'=> $name, 'email'=> $email, 'password'=> $hashed_password]);

        header("Location:./admin/signin.php?mes=signedup");
        exit();
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
            <div class="card text-bg-info mb-3" style="min-width: 70vh; position:absolute; top: 20vh; right:80vh;">
                <div class="card-header">Sign up</div>
                <div class="card-body">
                    <h5 class="card-title">Please fill out all the fields.</h5>
                    <form method="post">
                        <div class="form-floating mb-3">
                            <input type="text" name="name" class="form-control" id="name" placeholder="Name" required>
                            <label for="name">Your name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com" required>
                            <label for="email">Email address</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                            <label for="password">Password</label>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary form-control mt-2">Sign up!</button>
                    </form>
                    <small>Already have an account? <a href="./admin/signin.php">Sign in</a></small>
                </div>
            </div>
        </div>


<?php
echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';


?>
    
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    </body>
</html>