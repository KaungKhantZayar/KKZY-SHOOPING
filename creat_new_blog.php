<?php
// if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
//   header('Location: login.php');
// }
// if ($_SESSION['role'] != 1) {
//   header('Location: login.php');
// }
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="css/linearicons.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/nouislider.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/main.css">
  </head>
  <body>


    <?php

    if ($_POST) {
      if (empty($_POST['title'] OR empty($_POST['description']) OR $_FILES['image']['name'] == '')) {
        if (empty($_POST['title'])) {
          $titleError = 'Title cannot be empty';
        }
        if (empty($_POST['des'])) {
          $descriptionError = 'Description cannot be empty';
        }
        if ($_FILES['image']['name'] == '') {
        $imageError = 'Image cannot be empty';
        }
      }else {
        $file = 'images/'.($_FILES['image']['name']);
        $imageType = pathinfo($file,PATHINFO_EXTENSION);

        if ($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg') {
          echo "<script>alert('Image must be png,jpg,jpeg');</script>";
        }else {
          $title = $_POST['title'];
          $description = $_POST['description'];
          $image = $_FILES['image']['name'];
          move_uploaded_file($_FILE['image']['tmp_name'],$file);
          $stmt = $pdo->prepare("INSERT INTO posts(title,description,image) VALUES (:title,:description,:image)");
          $result = $stmt->execute(
            array(':title'=>$title,':description'=>$description,':image'=>$image)
          );
          if ($result) {
            echo "<script>alert(Successfuly added);window.location.href='blog.php'</script>";
          }
        }
      }
    }

     ?>

    <br><br><br><br><br>
    <div class="container">
      <div class="card">
        <div class="card-header">
          <h2>Creat New Blog</h2>
        </div>
        <div class="card-body">
          <form class="" action="" method="post" enctype="multipart/form-data">
            <label for=""><b>Enter Your Title</b></label><p style="color:red;"><?php echo empty($titleError) ? '' : $titleError;?></p>
            <input type="text" name="title" placeholder=" Title" class="form-control mt-2" value="">
            <label for="" class="mt-3"><b>Enter Your Description</b></label><p style="color:red;"><?php echo empty($desError) ? '' : $desError;?></p>
            <input type="text" name="description" value="" placeholder="Description" class="form-control mt-2">
            <label for="" class="mt-3"><b>Enter Your Image</b></label><p style="color:red;"><?php echo empty($imageError) ? '' : $imageError; ?></p>
            <input type="file" name="image" value="" class="form-control mt-2">

          <div class="row mt-4">
            <div class="col-6">
              <button type="submit" name="button" class="form-control" style="border:none; background-color:orange; padding-left:10px;padding-right:10px; border-radius:10px; color:white;">Submit</button>
            </div>
            <div class="col-6">
              <a href="blog.php"><button type="button" name="button" class="form-control" style="border:none; background-color:red; padding-left:10px;padding-right:10px; border-radius:10px; color:white;">Back</button></a>
            </div>
          </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
