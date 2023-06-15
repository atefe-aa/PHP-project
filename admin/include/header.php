<?php
session_start();
include("./include/config.php");
include("./include/db.php");

$user_id = $_SESSION['id'];

if(!isset($_SESSION['id'])){
  header("Location:signin.php?mes=notsignedin");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Website: Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="node_modules/froala-editor/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
</head>
  <body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary  bg-dark"  data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="../index.php">My Website</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
            <div class="dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo (isset($_SESSION['name']))? $_SESSION['name']:""; ?><span class="caret"></span>
                </a>

                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="editinfo.php">Edit info</a></li>
                    <li><a class="dropdown-item" href="logout.php">Log out</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo ((isset($_GET['page']) && $_GET['page'] == 'home') || !isset($_GET['page'])) ? "active" : ""; ?>" aria-current="page" href="index.php?page=home">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../index.php?user=<?php echo $user_id;?>">Profile view</a>
        </li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" name="search" id="search" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>