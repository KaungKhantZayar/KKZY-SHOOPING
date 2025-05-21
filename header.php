<?php
		session_start();

	  if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
		   header('Location: login.php');
		 }
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
	<title>KKZY-SHOP</title>

	<!--
            CSS
            ============================================= -->
	<link rel="stylesheet" href="css/linearicons.css">
	<link rel="stylesheet" href="css/owl.carousel.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/themify-icons.css">
	<link rel="stylesheet" href="css/nice-select.css">
	<link rel="stylesheet" href="css/nouislider.min.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/main.css">
</head>
<style media="screen">
	.wtks{
		text-shadow:0px 2px 16px black;
}
</style>

<body id="category">

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
					<h2 class="text-white wtks"><b><?php echo $_SESSION['username'];?></b></h2>
					<a href="logout.php" style="background-color:red; border-radius:10px;" class="p-2"><b>Logout</b></a>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->

				<!-- Start Filter Bar -->
