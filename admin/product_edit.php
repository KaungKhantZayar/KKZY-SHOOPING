<?php
session_start();
require '../Config/config.php';
require '../Config/common.php';
include 'header.php';

  if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header('Location: login.php');
  }
  if ($_SESSION['role'] != 1) {
    header('Location: login.php');
  }

  if ($_POST) {
    if (empty($_POST['name']) || empty($_POST['description'])  || empty($_POST['category']) || empty($_POST['quantity']) || empty($_POST['price'])) {
      if (empty($_POST['name'])) {
        $nameError = 'Category name is required';
      }
      if (empty($_POST['description'])) {
        $descError = 'Description is required';
      }
      if (empty($_POST['category'])) {
        $catError = 'Category is required';
      }
      if (empty($_POST['quantity'])) {
        $qtyError = 'Quantity is required';
      }elseif (is_numeric($_POST['quantity']) != 1) {
        $qtyError = 'Quantity should be integer value';
      }
      if (empty($_POST['price'])) {
        $priceError = 'Price is required';
      }elseif (is_numeric($_POST['price']) != 1) {
        $priceError = 'Price should be integer value';
      }
    }else {
      if ($_FILES['image']['name'] != null) {

        $file = 'images/'.($_FILES['image']['name']);
        $imageType = pathinfo($file,PATHINFO_EXTENSION);

       if ($imageType != 'jpg' && $imageType != 'jpeg' && $imageType != 'png') {
          echo "<script>alert('Image should be jpg,jpeg,png')</script>";
        }else {
          $name = $_POST['name'];
          $desc = $_POST['description'];
          $category = $_POST['category'];
          $qty = $_POST['quantity'];
          $price = $_POST['price'];
          $image = $_FILES['image']['name'];
          $id = $_GET['id'];

          move_uploaded_file($_FILES['image']['tmp_name'],$file);

          $stmt = $pdo->prepare("UPDATE products SET name=:name,description=:description,category_id=:category,price=:price,quantity=:quantity,image=:image WHERE id='$id'");

          $result = $stmt->execute(
            array(':name'=>$name, ':description'=>$desc, ':category'=>$category, ':price'=>$price, ':quantity'=>$qty, ':image'=>$image)
          );

          if ($result) {
              echo "<script>alert('Product is updated');window.location.href='index.php';</script>";
          }
        }
      }else {

          $name = $_POST['name'];
          $desc = $_POST['description'];
          $category = $_POST['category'];
          $qty = $_POST['quantity'];
          $price = $_POST['price'];
          $id = $_GET['id'];
          $stmt = $pdo->prepare("UPDATE products SET name=:name,description=:description,category_id=:category,price=:price,quantity=:quantity WHERE id='$id'");

          $result = $stmt->execute(
            array(':name'=>$name,':description'=>$desc,':category'=>$category,':price'=>$price,':quantity'=>$qty)
          );

          if ($result) {
            echo "<script>alert('Product is updated');window.location.href='index.php';</script>";
          }
        }
      }
    }

  $stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$_GET['id']);
  $stmt->execute();

  $result = $stmt->fetchAll();

 ?>


 <div class="content">
   <div class="container p-4">
     <div class="row">
       <div class="col-md-6 mt-5" style="margin-left:280px;">
         <div class="card p-4">
           <h3>Category Edit Page</h3>
           <form class="" action="" method="post" enctype="multipart/form-data">
             <input type="hidden" name="id" value="<?php echo $result[0]['id']; ?>">
             <div class="form-floating mb-3 mt-3">
               <input type="text" class="form-control" placeholder="Enter Category Name" name="name" value="<?php echo escape($result[0]['name']);?>">
               <label for="">Name</label><p style="color:red;"><?php echo empty($nameError) ? '' : '*'.$nameError; ?></p>
             </div>

             <div class="form-floating mt-3 mb-3">
               <input type="text" class="form-control" placeholder="Enter Description" name="description" value="<?php echo escape($result[0]['description']);?>">
               <label for="pwd">Description</label><p style="color:red;"><?php echo empty($descError) ? '' : '*'.$descError; ?></p>
             </div>

             <div class="form-floating mt-3 mb-3">
                <?php
                  $catStmt = $pdo->prepare("SELECT * FROM categories");
                  $catStmt->execute();
                  $catResult = $catStmt->fetchAll();
                 ?>
               <select name="category" class="form-control">
                 <option value="">SELECT CATEGORY</option>
                 <?php foreach ($catResult as $value) {?>
                   <option value="<?php echo $value['id']; ?>" <?php if($value['id'] == $result[0]['category_id']){ echo "selected"; } ?>><?php echo $value['name'] ?></option>
                 <?php } ?>
               </select>
               <label for="pwd">Category</label><p style="color:red;"><?php echo empty($catError) ? '' : '*'.$catError; ?></p>
             </div>

             <div class="form-floating mb-3 mt-3">
               <input type="number" class="form-control" placeholder="Enter Category Name" name="quantity" value="<?php echo escape($result[0]['quantity']);?>">
               <label for="">Quantity</label><p style="color:red;"><?php echo empty($qtyError) ? '' : '*'.$qtyError; ?></p>
             </div>

             <div class="form-floating mb-3 mt-3">
               <input type="number" class="form-control" placeholder="Enter Category Name" name="price" value="<?php echo escape($result[0]['price']);?>">
               <label for="">Price</label><p style="color:red;"><?php echo empty($priceError) ? '' : '*'.$priceError; ?></p>
             </div>

             <div class="form-floating mb-3 mt-3">
               <input type="file" class="form-control" name="image">
               <img src="images/<?php echo escape($result[0]['image']); ?>" alt="" width="150" height="150">
               <label for=""><b>Image</b></label><p style="color:red;"></p>
             </div>

             <div class="form-group mt-4">
               <input type="submit" class="btn btn-success" name="" value="Submit">
               <a href="index.php" class="btn btn-danger">Back</a>
             </div>
           </form>
         </div>
       </div>
     </div>
   </div>
 </div>


<?php include 'footer.html'; ?>
