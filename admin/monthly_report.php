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
          <h3 class="card-title">Monthly Reports</h3>
        </div>

        <?php
          $currentDate = date("Y-m-d");
          $fromDate = date("Y-m-d", strtotime($currentDate . '+1 day'));
          $toDate = date("Y-m-d", strtotime($currentDate . '-1 month'));

          $stmt = $pdo->prepare("SELECT * FROM sale_orders WHERE order_date<:from_date AND order_date>=:todate ORDER BY id DESC");
          $stmt->execute([':from_date'=>$fromDate,':todate'=>$toDate]);
          $result = $stmt->fetchAll();
         ?>

        <!-- /.card-header -->
        <div class="card-body">
          <!-- <form class="" action="" method="post">
            <div class="input-group mb-3" style="width:250px; margin-left:750px;">
              <input type="date" class="form-control" placeholder="Search" name="search">
              <div class="input-group-append">
                <button class="input-group-text search_icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search-heart" viewBox="0 0 16 16">
                    <path d="M6.5 4.482c1.664-1.673 5.825 1.254 0 5.018-5.825-3.764-1.664-6.69 0-5.018"/>
                    <path d="M13 6.5a6.47 6.47 0 0 1-1.258 3.844q.06.044.115.098l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1-.1-.115h.002A6.5 6.5 0 1 1 13 6.5M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11"/>
                  </svg>
                </button>
              </div>
            </div>
          </form> -->


          <table class="table table-bordered mt-4 table-hover" id="d-table">
            <thead>
              <tr>
                <th style="width: 10px">#</th>
                <th>UserID</th>
                <th>Total Amount</th>
                <th>Order Date</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if ($result) {
                  $i = 1;
                  foreach ($result as $value) {?>
                    <?php
                      $userstmt = $pdo->prepare("SELECT * FROM users WHERE id=".$value['user_id']);
                      $userstmt->execute();
                      $userResult = $userstmt->fetchAll();
                     ?>
              <tr>
                <td><?php echo $i;?></td>
                <td><?php echo escape($userResult[0]['name']);?></td>
                <td><?php echo escape($value['total_price']);?></td>
                <td><?php echo escape(date("Y-m-d", strtotime($value['order_date'])));?></td>
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
