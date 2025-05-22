<?php
session_start();
require 'config/config.php';
require 'config/common.php';

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


    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Blog Detail Page</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="category.html">Blog</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>


    <?php
      $stmt = $pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
      $stmt->execute();
      $result = $stmt->fetchAll();

      $blogId = $_GET['id'];
      $stmtcmt = $pdo->prepare("SELECT * FROM comments WHERE post_id=$blogId");
      $stmtcmt->execute();
      $cmResult = $stmtcmt->fetchAll();

      $auResult = [];
      if (!empty($cmResult)) {
        foreach ($cmResult as $key => $value) {
          $authorId = $cmResult[$key]['author_id'];
          $stmtau = $pdo->prepare("SELECT * FROM users WHERE id=$authorId");
          $stmtau->execute();
          $auResult[] = $stmtau->fetchAll();
        }
      }

      if ($_POST) {
        if (empty($_POST['comment'])) {
          if (empty($_POST['title'])) {
            $cmtError = 'Comment cannot be empty';
          }
        }else {
          $comment = $_POST['comment'];
          $stmt = $pdo->prepare("INSERT INTO comments (content,author_id,post_id) VALUES (:content,:author_id,:post_id)");
          $result = $stmt->execute(
            array(':content'=>$comment, ':author_id'=>$_SESSION['user_id'], ':post_id'=>$blogId)
          );

          if ($result) {
            header('Location: blogdetail.php?id='.$blogId);
          }
        }
      }
     ?>


      <div class="" style="width:700px; margin-left:400px; margin-top:70px;">
        <section class="content">
          <div class="d-flex">
            <div class="col-md-12">
              <!-- Box Comment -->
              <div class="card card-widget">
                <div class="card-header">
                  <div style="text-align:center !important;float:none;" class="card-title">
                    <h2><?php echo escape($result['0']['title']);?></h2>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body ">
                <img class="img-fluid pad" src="admin/images/<?php echo $result[0]['image'];?>" alt="" style="">
                  <br><br><br>
                  <p><?php echo escape($result['0']['description']);?></p>
                   <hr>
                  <div class="d-flex">
                    <h3>Comments</h3><hr>
                    <a href="blog.php" class="btn btn-success">Back To Blog_Page</a>
                  </div>
                </div>
                <!-- /.card-body -->
                <?php
                if (!empty($cmResult)) {
                  ?>
                  <div class="card-footer card-comments">
                    <div class="card-comment">
                      <div class="comment-text" style="margin-left:0px !important;">
                        <?php
                        foreach ($cmResult as $key => $value) {
                            ?>
                            <span class="username">
                              <p><?php echo escape($auResult[$key][0]['name']);?></p><br>
                              <p style="margin-left:6px; margin-top:-35px;"><?php echo escape($value['content']);?></p>
                            </span>

                            <div class="d-flex" style="margin-left:400px; margin-top:-50px;">
                              <p style="margin-left:20px;"><?php echo escape(date("h:i:s a", strtotime($value['created_at']))); ?></p>
                              <p class="text-muted float-right" style="margin-left:20px;"> <?php echo escape(date("Y-m-d:H", strtotime($value['created_at'])));?></p>
                            </div>


                            <?php
                        }
                         ?>
                      </div>
                    </div>
                  </div>
                  <?php
                }
                 ?>
                <!-- /.card-footer -->
                <div class="card-footer">
                  <form action="" method="post">
                    <!-- .img-push is used to add margin to elements next to floating images -->
                    <div class="img-push">
                      <input name="_token" type="hidden" value="">
                      <span style="color:red;"><?php echo empty($cmtError) ? '' : '*' . $cmtError;?></span>
                      <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Press enter to post comment" aria-label="Recipient's username" aria-describedby="button-addon2" name="comment">
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send-arrow-up-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15.854.146a.5.5 0 0 1 .11.54L13.026 8.03A4.5 4.5 0 0 0 8 12.5c0 .5 0 1.5-.773.36l-1.59-2.498L.644 7.184l-.002-.001-.41-.261a.5.5 0 0 1 .083-.886l.452-.18.001-.001L15.314.035a.5.5 0 0 1 .54.111M6.637 10.07l7.494-7.494.471-1.178-1.178.471L5.93 9.363l.338.215a.5.5 0 0 1 .154.154z"/>
                            <path fill-rule="evenodd" d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.354-5.354a.5.5 0 0 0-.722.016l-1.149 1.25a.5.5 0 1 0 .737.676l.28-.305V14a.5.5 0 0 0 1 0v-1.793l.396.397a.5.5 0 0 0 .708-.708z"/>
                          </svg>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>

              </div>
            </div>
          </div>
        </section>
    </div>






<br><br><br><br>
<?php include 'footer.php'; ?>
</body>

</html>
