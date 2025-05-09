<?php
    require '../Config/config.php';
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id=".$_GET['id']);
    $stmt->execute();
    // echo "<script>alert('Are you sure you want to delete this item')</script>";
    header('Location: category.php');
 ?>
