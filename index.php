<?php include 'header.php'; ?>


		<?php
				require 'config/config.php';
				require 'config/common.php';


				if (!empty($_GET['pageno'])) {
					$pageno = $_GET['pageno'];
				}else {
					$pageno = 1;
				}
				$numOfrecs = 1   ;
				$offset = ($pageno - 1) * $numOfrecs;

				if (empty($_POST['search'])) {
					if (!empty($_GET['category_id'])) {
						$categoryId = $_GET['category_id'];
						$stmt = $pdo->prepare("SELECT * FROM products WHERE category_id=$categoryId AND quantity > 0 ORDER BY id  DESC");
						$stmt->execute();
						$rawResult = $stmt->fetchAll();

						$total_pages = ceil(count($rawResult) / $numOfrecs);

						$stmt = $pdo->prepare("SELECT * FROM products WHERE category_id=$categoryId AND quantity > 0 ORDER BY id DESC LIMIT $offset,$numOfrecs");
						$stmt->execute();
						$result = $stmt->fetchAll();
					}else {
						$stmt = $pdo->prepare("SELECT * FROM products WHERE quantity > 0 ORDER BY id  DESC");
						$stmt->execute();
						$rawResult = $stmt->fetchAll();

						$total_pages = ceil(count($rawResult) / $numOfrecs);

						$stmt = $pdo->prepare("SELECT * FROM products WHERE quantity > 0 ORDER BY id DESC LIMIT $offset,$numOfrecs");
						$stmt->execute();
						$result = $stmt->fetchAll();
					}

				}else {
					$searchKey = $_POST['search'];
					$stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' AND quantity > 0 ORDER BY id  DESC");
					$stmt->execute();
					$rawResult = $stmt->fetchAll();

					$total_pages = ceil(count($rawResult) / $numOfrecs);

					$stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' AND quantity > 0 ORDER BY id DESC LIMIT $offset,$numOfrecs");
					$stmt->execute();
					$result = $stmt->fetchAll();
				}

 			?>

			<div class="container">
				<div class="row">
					<div class="col-xl-3 col-lg-4 col-md-5">
						<div class="sidebar-categories">
							<div class="head">Browse Categories</div>
							<ul class="main-categories">
								<li class="main-nav-list">
									<?php
										$catstmt = $pdo->prepare("SELECT * FROM categories ORDER BY id DESC");
										$catstmt->execute();
										$catResult = $catstmt->fetchAll();
									 ?>

									 <?php foreach ($catResult as $key => $value) { ?>
										 <a href="index.php?category_id=<?php echo $value['id']; ?>"><span class="lnr lnr-arrow-right"></span><?php echo escape($value['name']);?></a>
									 <?php } ?>
								</li>
							</ul>
						</div>

					</div>
					<div class="col-xl-9 col-lg-8 col-md-7">

			<div class="filter-bar d-flex flex-wrap align-items-center">
				<div class="pagination">
					<a href="?pageno=1" class="active">First</a>
					<a <?php if($pageno <= 1){echo 'disabled';}?>
						href="<?php if($pageno <= 1){echo '#';}else{echo "?pageno=".($pageno-1);}?>" class="prev-arrow">
						<i class="fa fa-long-arrow-left" aria-hidden="true"></i>
					</a>
					<a href="#" class="active"><?php echo $pageno;?></a>
					<a <?php if($pageno >= $total_pages){echo 'disabled';}?>
						 href="<?php if($pageno >= $total_pages){echo '#';}else{echo "?pageno=".($pageno+1);}?>" class="next-arrow">
						 <i class="fa fa-long-arrow-right" aria-hidden></i>
					</a>
					<a href="?pageno=<?php echo $total_pages;?>" class="active">Last</a>
				</div>
			</div>

				<!-- End Filter Bar -->
				<!-- Start Best Seller -->
				<section class="lattest-product-area pb-40 category-list">
					<div class="row">
							<?php
								if ($result) {
									foreach ($result as $key => $value) {?>
										<div class="col-lg-4 col-md-6">
											<div class="single-product">
												<a href="product_detail.php?id=<?php echo $value['id']; ?>">
													<img class="img-fluid" src="admin/images/<?php echo escape($value['image']);?>" alt="">
												</a>
												<div class="product-details">
													<h6><?php echo escape($value['name']);?></h6>
													<div class="price">
														<h6><?php echo escape($value['price']);?></h6>
													</div>
													<div class="prd-bottom">
														<form class="" action="addtocart.php" method="post">

															<input type="hidden" name="id" value="<?php echo escape($value['id']);?>">
															<input type="hidden" name="qty" value="1">

															<div class="social-info">
																<button type="submit" style="border:none; background:none;">
																	<span class="ti-bag"></span><p class="hover-text" style="margin-left:-10px;">add to bag</p>
																</button>
															</div>
															<a href="product_detail.php?id=<?php echo $value['id']; ?>" class="social-info" style="margin-left:10px;">
																<span class="lnr lnr-move"></span>
																<p class="hover-text">view more</p>
															</a>
														</form>
													</div>
												</div>
											</div>
										</div>
								<?php
									}
								}
							 ?>
					</div>
				</section>
			</div>
		</div>
	</div>
	<br>
	<?php include 'footer.php'; ?>
