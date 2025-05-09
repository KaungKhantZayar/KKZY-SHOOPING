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
    if (empty($_POST['name']) || empty($_POST['description'])) {
      if (empty($_POST['name'])) {
        $nameError = 'Category name is required';
      }
      if (empty($_POST['description'])) {
        $descError = 'Description is required';
      }
    }else {
      $id = $_POST['id'];
      $name = $_POST['name'];
      $description = $_POST['description'];

      $stmt = $pdo->prepare("UPDATE categories SET name=:name, description=:description WHERE id=:id");

      $result = $stmt->execute(
        array(':name'=>$name, ':description'=>$description, ':id'=>$id)
      );

      if ($result) {
        echo "<script>alert('Category Updated');window.location.href='category.php'</script>";
      }
    }
  }

  $stmt = $pdo->prepare("SELECT * FROM categories WHERE id=".$_GET['id']);
  $stmt->execute();

  $result = $stmt->fetchAll();

 ?>


 <div class="content">
   <div class="container p-4">
     <div class="row">
       <div class="col-md-6 mt-5" style="margin-left:280px;">
         <div class="card p-4">
           <h3>Edit Add Page</h3>
           <form class="" action="cat_edit.php" method="post">
             <!-- <input name="_token" type="" value="<?= $_SESSION['_token']; ?>"> -->
             <input type="hidden" name="id" value="<?php echo escape($result[0]['id']);?>">

             <div class="form-floating mb-3 mt-3">
               <input type="text" class="form-control" id="email" placeholder="Enter Category Name" name="name" value="<?php echo escape($result[0]['name']);?>">
               <p style="color:red;"><?php echo empty($nameError) ? '' : '*'.$nameError; ?></p>

             </div>

             <div class="form-floating mt-3 mb-3">
               <input type="text" class="form-control" id="pwd" placeholder="Enter Description" name="description" value="<?php echo escape($result[0]['description']);?>">
               <p style="color:red;"><?php echo empty($descError) ? '' : '*'.$descError; ?></p>
             </div>

             <!-- <label for="pwd">Enter Image</label>
             <div class=" mt-2 mb-3">
               <input type="file" name="" value="">
             </div> -->

             <div class="form-group mt-4">
               <input type="submit" class="btn btn-success" name="" value="Submit">
               <a href="category.php" class="btn btn-danger">Back</a>
             </div>
           </form>
         </div>
       </div>
     </div>
   </div>
 </div>


<?php include 'footer.html'; ?>
