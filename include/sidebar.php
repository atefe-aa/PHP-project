<div class="col-sm-3 me-4" id="sidebar">
<?php
$query_categories = "SELECT * FROM categories";
$categories = $db->query($query_categories);
?>
          <!-- search box -->
          <form action="search.php" method="get" style="border: #e0dfdf 1px solid;margin-bottom: 8px;border-radius: 8px;padding: 20px;">
            <div class="form-group">
                  <label for="searchbox"><h3 style="font-weight: bolder;">Search in the posts:</h3> </label>
                  <input class="form-control" type="text" name="search" id="searchbox" placeholder="search...">
                  <span class="input-group-btn"><button type="submit" id="searchbtn" class="btn btn-primary form-control" style="margin-top: 8px;
    font-size: 18px;
    font-weight: bolder;">Find</button></span>
            </div>
          </form>
             <!-- category box  -->
          <div id="categorybox" style="border: #e0dfdf 1px solid;margin-bottom: 8px;border-radius: 8px;padding: 20px;">
            <p><h2 style="font-weight: bolder;">Categories:</h2></p>
            <ul class="list-group" id="categorylist">
              <?php
              
              if($categories->rowCount()>0){
                foreach ($categories as $category){
                  echo '<li class="list-group-item ">
                  <a href="index.php?category='. $category['id'].'">'. $category['title'].'</a>
              </li>';
                  }
              }else{
                echo '<div class="alert alert-info">There is no Category available!</div';
            }
              ?>
            </ul>
          </div>

            <!-- join box -->
          <?php 
            if(isset($_POST['subscribe'])){
              if(trim($_POST['name']) !="" && trim($_POST['email']) != ""){

                $name = htmlspecialchars($_POST['name']);
                $email= filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
  
                $subscribe_insert = $db->prepare("INSERT INTO subscribers (name, email) VALUES (:name , :email) ");
                if($subscribe_insert->execute(['name' => $name, 'email' => $email])){
                  echo '<div class="alert alert-success">Subscribed successfully!</div>';
                }else{
                  echo '<div class="alert alert-danger">Error: Please try again!</div>';                  
                }
              }else{
                echo '<div class="alert alert-danger">please fill all the fields!</div>';
              }
            }

          ?>
          <form method="post" style="border: #e0dfdf 1px solid;margin-bottom: 8px;border-radius: 8px;padding: 20px;">
            <div class="form-group">
              <label for="name"><h4 style="font-weight: bolder;">Name:</h4></label>
              <input autocomplete="name" name="name" type="text" id="name" placeholder="Name" class="form-control">
              <label for="email"><h4 style="font-weight: bolder;">Email:</h4></label>
              <input autocomplete="email" type="email" name="email" id="email" placeholder="Email" class="form-control">
              <span class="input-group-btn">
                  <button type="submit" name="subscribe" class="btn btn-primary form-control" id="joinbtn" style="margin-top: 8px;
    font-size: 18px;
    font-weight: bolder;">Join us</button>   
              </span>
            </div>
          </form>
         

          <!-- about us box -->
          <div id="aboutbox" style="border: #e0dfdf 1px solid;margin-bottom: 8px;border-radius: 8px;padding: 20px;">
            <p><h2 style="font-weight: bolder;">About us</h2></p>
            <p id="aboutparagraph">The night sky is a wondrous and captivating sight that never fails to amaze us.
 It is a canvas of twinkling stars, planets, and distant galaxies that stretch out into infinity. 
 On a clear night, we can see countless stars of varying brightness and colors, each telling its 
 own story of the universe's vastness and complexity. The Milky Way, a breathtaking band of stars 
 and gas, can be seen arching across the sky, reminding us of our place in the galaxy.</p>
          </div>
        </div>