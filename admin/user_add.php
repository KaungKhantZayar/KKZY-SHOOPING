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

if ($_POST) {
  if (empty($_POST['name']) OR empty($_POST['email']) OR empty($_POST['password']) OR strlen($_POST['password']) < 4){
    if (empty($_POST['title'])) {
      $nameError = 'Name cannot be empty';
    }
    if (empty($_POST['content'])) {
      $emailError = 'Email cannot be empty';
    }
    if (empty($_POST['password'])) {
      $passwordError = 'Password cannot be empty';
    }
    elseif  (strlen($_POST['password']) < 4) {
      $passwordError = 'Password should be 4 characters at least';
    }
  }else {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $passwordhash = password_hash($password, PASSWORD_DEFAULT);
    if (isset($_POST['role'])) {
      $role = 1;
    }else {
      $role = 0;
    }
  $stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email");
  $user = $stmt->bindValue('email', $email);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user) {
    echo "<script>alert('Email duplicate')</script>";
  }else {
    $stmt = $pdo->prepare("INSERT INTO users(name,email,role,password) VALUES (:name,:email,:role,:password)");
    $result = $stmt->execute(
      array(':name'=>$name,':email'=>$email,':role'=>$role,':password'=>$passwordhash)
    );
      if ($result) {
        echo "<script>alert('Sussessfully added');window.location.href='user_list.php';</script>";
      }
    }
  }
}

  ?>
 <?php include 'header.php';?>

<div class="container mt-5" style="width:700px;">
    <div class="card">
        <div class="card-body">
          <form class="" action="" method="post">
            <!-- <input name="_token" type="hidden" value="<?php echo $_SESSION['_token'];?>"> -->
          <label for="">Username</label><p style="color:red;"><?php echo empty($nameError) ? '' : '*'.$nameError;?></p>
          <input type="text" name="name" value="" class="form-control">


          <label for="" class="mt-3">Email</label><p style="color:red;"><?php echo empty($emailError) ? '' : '*'.$emailError;?></p>
          <input type="email" name="email" value="" class="form-control">

          <label for="" class="mt-3">Password</label><p style="color:red;"><?php echo empty($passwordError) ? '' : '*'.$passwordError; ?></p>
          <input type="password" name="password" value="" class="form-control">

          <label for="vechicle3" class="mt-3">Admin or User</label><br>
          <input type="checkbox" name="role" value="">

          <br>
          <input type="submit" class="btn btn-success mt-3" name="button" value="SUBMIT">
          <a href="user_list.php"><button type="button" name="button" class="btn btn-danger mt-3">Back</button></a>
        </form>
        </div>
    </div>
</div>

<?php include 'footer.html'; ?>
