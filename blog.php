<?php
session_start();
require 'Config/config.php';
?>
<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/fav.png">
    <!-- Author Meta -->
    <meta name="author" content="CodePixar">
    <!-- Meta Description -->
    <meta name="description" content="">
    <!-- Meta Keyword -->
    <meta name="keywords" content="">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title>Karma Shop</title>
    <!--
			CSS
			============================================= -->
    <link rel="stylesheet" href="css/linearicons.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/nouislider.min.css">
    <link rel="stylesheet" href="css/ion.rangeSlider.css" />
    <link rel="stylesheet" href="css/ion.rangeSlider.skinFlat.css" />
    <link rel="stylesheet" href="css/main.css">
    <script src="app.js" charset="utf-8"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <!-- Start Header Area -->
    <header class="header_area sticky-header">
  		<div class="main_menu">
  			<nav class="navbar navbar-expand-lg navbar-light main_box">
  				<div class="container">
  					<!-- Brand and toggle get grouped for better mobile display -->
  					<a class="navbar-brand logo_h" href="index.php"><h2>KKZY-SHOOPING</h2></a>
  					<a href="blog.php" style="margin-left:600px; color:black;">Blog</a>
  					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
  					 aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
  						<span class="icon-bar"></span>
  						<span class="icon-bar"></span>
  						<span class="icon-bar"></span>
  					</button>


  					<?php
  						$cart = 0;
  						if (isset($_SESSION['cart'])) {
  							foreach ($_SESSION['cart'] as $key => $qty) {
  								$cart += $qty;
  							}
  						}
  					 ?>
  					<!-- Collect the nav links, forms, and other content for toggling -->
  					<div class="collapse navbar-collapse offset" id="navbarSupportedContent" style="margin-left:100px;">
  						<ul class="nav navbar-nav navbar-right" style="">
  							<li class="nav-item"><a href="cart.php" class="cart"><span class="ti-bag"><?php echo $cart;?></span></a></li>
  							<li class="nav-item">
  								<button class="search" style="margin-left:-20px;"><span class="lnr lnr-magnifier" id="search"></span></button>
  							</li>
  						</ul>
  					</div>
  				</div>
  			</nav>
  		</div>
  		<div class="search_input" id="search_input_box">
  			<div class="container">
  				<form class="d-flex justify-content-between" action="index.php" method="post">
  					<input type="text" class="form-control" id="search_input" placeholder="Search Here" name="search">
  					<button type="submit" class="btn"></button>
  					<span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
  				</form>
  			</div>
  		</div>
  	</header>
	<!-- End Header Area -->


  <?php
    $stmt = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
    $stmt->execute();
    $result = $stmt->fetchAll();
   ?>

    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Blog Page</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="category.html">Blog</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="blog_area" style="margin-left:20px;">
        <div class="container mt-5">
            <div class="row">
              <?php
                if ($result) {
                  $i = 1;
                  foreach ($result as $value) {?>
                    <div class="col-6">
                        <div class="">
                            <article class="row blog_item">
                                <div class="col-md-9">
                                    <div class="blog_post">
                                        <img src="images/<?php echo $value['image'];?>" alt="" width="250px">
                                        <div class="blog_details">
                                            <a href="single-blog.html">
                                                <h2><?php echo $value['title']; ?></h2>
                                            </a>
                                            <p><?php echo $value['description']; ?></p>
                                            <a href="blogdetail.php?id=<?php echo $value['id']; ?>" class="white_bg_btn">View More</a>
                                        </div>
                                    </div>
                                </div>
                            </article>
                          </div>
                    </div>
              <?php
                $i++;
              }
            }
               ?>

            </div>
        </div>
    </section>


    <?php

    if ($_POST) {
      if (empty($_POST['title'] OR empty($_POST['description']))) {
        if (empty($_POST['title'])) {
          $titleError = 'Title cannot be empty';
        }
        if (empty($_POST['description'])) {
          $descriptionError = 'Description cannot be empty';
        }
      }else {
          $image = $_POST['image'];
          $title = $_POST['title'];
          $description = $_POST['description'];
          $stmt = $pdo->prepare("INSERT INTO posts(title,description,author_id,image) VALUES (:title,:description,:author_id,:image)");
          $result = $stmt->execute(
            array(':title'=>$title,':description'=>$description,'author_id'=>$_SESSION['user_id'],':image'=>$image)
          );
          if ($result) {
            echo "<script>alert('Successfuly added');window.location.href='blog.php'</script>";
          }
        }
      }

     ?>


  <div class="fixed-top" style="margin-top:700px; margin-left:90px;">
    <button class="primary-btn" type="button" name="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="margin-left:1200px;">Creat New Blog</button>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="margin-top:130px;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="staticBackdropLabel">Creat New Blog</h3>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div class="container">
              <div class="card-header">
                <h2></h2>
              </div>
                <form class="" action="" method="post" enctype="multipart/form-data">
                  <label for=""><b>Enter Your Title</b></label><p style="color:red;"><?php echo empty($titleError) ? '' : $titleError;?></p>
                  <input type="text" name="title" placeholder=" Title" class="form-control mt-2" value="">
                  <label for="" class="mt-3"><b>Enter Your Description</b></label><p style="color:red;"><?php echo empty($desError) ? '' : $desError;?></p>
                  <input type="text" name="description" value="" placeholder="Description" class="form-control mt-2">
                  <!-- <input type="file" name="image" value="" class="form-control mt-2"> -->
                  <label for="" class="mt-3"><b>Enter Your option</b></label><p style="color:red;"><?php echo empty($imageError) ? '' : $imageError; ?></p>
                  <div class=" mt-3 mb-3">
                     <?php
                       $catStmt = $pdo->prepare("SELECT * FROM products ORDER BY id DESC");
                       $catStmt->execute();
                       $catResult = $catStmt->fetchAll();
                      ?>
                    <select name="image" class="form-control">
                      <option value="">Select</option>
                      <?php foreach ($catResult as $value) {?>
                        <option value="<?php echo $value['image'];?>"><?php echo $value['name'];?></option>
                      <?php } ?>
                    </select>

                  </div>
<br>
                <div class="row mt-5">
                  <div class="">
                    <button type="submit" name="button" class="form-control primary-btn" style="border:none; background-color:orange; padding-left:10px;padding-right:10px; border-radius:10px; color:white;">Submit</button>
                  </div>
                </div>
                </form>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary primary-btn" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

<br><br><br><br>
<?php include 'footer.php'; ?>
</body>

</html>
