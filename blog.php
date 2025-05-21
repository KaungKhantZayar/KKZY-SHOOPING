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
  					<a href="blog.html" style="margin-left:600px; color:black;">Blog</a>
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
                <div class="col-6">
                    <div class="">
                        <article class="row blog_item">
                            <div class="col-md-9">
                                <div class="blog_post">
                                    <img src="img/blog/main-blog/m-blog-2.jpg" alt="">
                                    <div class="blog_details">
                                        <a href="single-blog.html">
                                            <h2>The Basics Of Buying A Telescope</h2>
                                        </a>
                                        <p>MCSE boot camps have its supporters and its detractors. Some people do not
                                            understand why you should have to spend money on boot camp when you can get
                                            the MCSE study materials yourself at a fraction.</p>
                                        <a href="single-blog.html" class="white_bg_btn">View More</a>
                                    </div>
                                </div>
                            </div>
                        </article>
                      </div>
                </div>

                <div class="col-6">
                    <div class="blog_left_sidebar">
                        <article class="row blog_item">
                            <div class="col-md-9">
                                <div class="blog_post">
                                    <img src="img/blog/main-blog/m-blog-2.jpg" alt="">
                                    <div class="blog_details">
                                        <a href="single-blog.html">
                                            <h2>The Basics Of Buying A Telescope</h2>
                                        </a>
                                        <p>MCSE boot camps have its supporters and its detractors. Some people do not
                                            understand why you should have to spend money on boot camp when you can get
                                            the MCSE study materials yourself at a fraction.</p>
                                        <a href="single-blog.html" class="white_bg_btn">View More</a>
                                    </div>
                                </div>
                            </div>
                        </article>
                      </div>
                </div>

            </div>
        </div>
    </section>

  <div class="sticky-top">
    <a href="creat_new_blog.php"><button type="button" name="button" style="margin-left:1200px;">Creat Nwe Blog</button></a>
  </div>

<br><br><br><br>
<?php include 'footer.php'; ?>
</body>

</html>
