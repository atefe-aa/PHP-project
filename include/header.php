
<?php
    include("./include/config.php");
    include("./include/db.php");

    $query = "SELECT * FROM categories";
    $categories = $db->query($query);
    $query_users = "SELECT * FROM users";
    $users = $db->query($query_users);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="icon" href="./favicon.ico" type="image/x-icon">
</head>
<body style="overflow-x:hidden;">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php" style="font-size: x-large; font-family: Georgia, 'Times New Roman', Times, serif;">My PHP Project</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav">
                <?php
                if ($categories->rowCount() > 0) {
                    if ($categories->rowCount() < 6) {
                        foreach ($categories as $category) {
                ?>
                            <li class="<?php echo (isset($_GET['category']) && $category['id'] == $_GET['category']) ? 'active' : ''; ?>">
                                <a class="nav-link" href="index.php?category=<?php echo $category['id'] ?>"><?php echo $category['title'] ?></a>
                            </li>
                <?php
                        }
                    } else {
                ?>
                        <li class="nav-item dropdown">
                            <a class="btn nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" id="categoriesDropdown" >Categories</a>
                            <ul class="dropdown-menu dropdown-menu-dark" >
                <?php
                            foreach ($categories as $category) {
                                echo '<li><a class="dropdown-item" href="index.php?category=' . $category['id'] . '">' . $category['title'] . '</a></li>';
                            }
                ?>
                            </ul>
                        </li>
                <?php
                    }
                }
                ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="authorsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Authors</a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="authorsDropdown">
                <?php
                    foreach ($users as $user) {
                        echo '<li><a class="dropdown-item" href="index.php?user=' . $user['id'] . '">' . $user['name'] . '</a></li>';
                    }
                ?>
                    </ul>
                </li>
            </ul>
            <form action="search.php" method="get" class="d-flex ms-auto" role="search">
                <input class="form-control me-2" type="text" name="search" id="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-light me-4" type="submit">Go</button>
            </form>
            <a href="signup.php" class="btn btn-success"  data-bs-toggle="tooltip" data-bs-title="sign up now so you can add posts to this website!">sign up</a>
        </div>
    </div>
</nav>
