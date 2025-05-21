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

  <style media="screen">
    /* .search_icon{
      border-top-left-radius:10px;
    } */
  </style>

    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Best Seller</h3>
        </div>

        <?php
          $currentDate = date("Y-m-d");
          $stmt = $pdo->prepare("SELECT * FROM sale_order_detail GROUP BY product_id HAVING SUM(quantity) > 5 ORDER BY id DESC");
          $stmt->execute();
          $result = $stmt->fetchAll();
         ?>

        <!-- /.card-header -->
        <div class="card-body">
          <table class="table table-bordered mt-4 table-hover" id="d-table">
            <thead>
              <tr>
                <th style="width: 10px">#</th>
                <th>Product</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if ($result) {
                  $i = 1;
                  foreach ($result as $value) {?>
                    <?php
                      $userstmt = $pdo->prepare("SELECT * FROM products WHERE id=".$value['product_id']);
                      $userstmt->execute();
                      $userResult = $userstmt->fetchAll();
                     ?>
              <tr>
                <td><?php echo $i;?></td>
                <td><?php echo escape($userResult[0]['name']);?></td>
              </tr>
              <?php
              $i++;
                  }
                }
               ?>
            </tbody>
          </table>
            <br>
      </div>

      </div>
    </div>

    <!-- Main content -->

<?php include 'footer.html'; ?>
