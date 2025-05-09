<?php
session_start();
require '../Config/config.php';
require '../Config/common.php';



if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header('Location: login.php');
}
if ($_SESSION['role'] != 1) {
  header('Location: login.php');
}

  ?>
 <?php include 'header.php';?>

    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Product Listings</h3>
        </div>

        <?php

             if (!empty($_GET['pageno'])) {
               $pageno = $_GET['pageno'];
             }else {
               $pageno = 1;
             }
             $numOfrecs = 3;
             $offset = ($pageno - 1) * $numOfrecs;

             if (empty($_POST['search'])) {
               $stmt = $pdo->prepare("SELECT * FROM products ORDER BY id  DESC");
               $stmt->execute();
               $rawResult = $stmt->fetchAll();

               $total_pages = ceil(count($rawResult) / $numOfrecs);

               $stmt = $pdo->prepare("SELECT * FROM products ORDER BY id DESC LIMIT $offset,$numOfrecs");
               $stmt->execute();
               $result = $stmt->fetchAll();
             }else {
               $searchKey = $_POST['search'];
               $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' ORDER BY id  DESC");
               $stmt->execute();
               $rawResult = $stmt->fetchAll();

               $total_pages = ceil(count($rawResult) / $numOfrecs);

               $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$numOfrecs");
               $stmt->execute();
               $result = $stmt->fetchAll();
             }

             ?>

        <!-- /.card-header -->
        <div class="card-body">
          <div class="" style="margin-left:900px;">
            <a href="product_add.php" type="button" class="btn btn-success">Create New Product</a>
          </div>

          <table class="table table-bordered mt-4 table-hover">
            <thead>
              <tr>
                <th style="width: 10px">#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Category</th>
                <th>In Stock</th>
                <th>Price</th>
                <th style="width:40px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if ($result) {
                  $i = 1;
                  foreach ($result as $value) {?>

                    <?php
                      $catstmt = $pdo->prepare("SELECT * FROM products WHERE id=".$value['category_id']);
                      $catstmt->execute();
                      $catresult = $catstmt->fetchAll();
                      $value['category_id']
                     ?>
              <tr>
                <td><?php echo $i;?></td>
                <td><?php echo escape($value['name']);?></td>
                <td><?php echo escape(substr($value['description'],0,30));?></td>
                <td><?php echo escape($catresult[0]['name']);?></td>
                <td><?php echo escape($value['quantity']);?></td>
                <td><?php echo escape($value['price']);?></td>
                <td>
                  <div class="btn-group">
                    <div class="container">
                    <a href="product_edit.php?id=<?php echo $value['id'];?>" type="button" class="btn btn-warning">Edit</a>
                    </div>
                    <div class="contaienr">
                    <a href="product_delete.php?id=<?php echo $value['id'];?>" type="button" class="btn btn-danger"  onclick="return confirm('Are you sure you want to logout?');">Delete</a>
                    </div>
                  </div>
                </td>
              </tr>
              <?php
              $i++;
                  }
                }
               ?>
            </tbody>
          </table>
            <br>
            <nav aria-lable="Page navigation example" style="float:right;">
              <ul class="pagination">
                <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                <li class="page-item <?php if($pageno <= 1){echo 'disabled';}?>">
                  <a class="page-link" href="<?php if($pageno <= 1){echo '#';}else{echo "?pageno=".($pageno-1);}?>">Previonus</a>
                </li>
                <li class="page-item"><a class="page-link" href="#"><?php echo $pageno;?></a></li>
                <li class="page-item <?php if($pageno >= $total_pages){echo 'disabled';}?>">
                  <a class="page-link" href="<?php if($pageno >= $total_pages){echo '#';}else{echo "?pageno=".($pageno+1);}?>">Next</a>
                </li>
                <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages;?>">Last</a></li>
              </ul>
            </nav>
      </div>

      </div>
    </div>

    <!-- Main content -->

<?php include 'footer.html'; ?>
