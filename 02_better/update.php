<?php

require_once "database.php";


$id = $_GET['id'] ?? null;
if (!$id) {
  header("Location: index.php");
  exit;
}

$statement = $pdo->prepare('SELECT * FROM products WHERE id = :id');
$statement->bindValue(':id', $id);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);

$errors = [];

$title = $product['title'];
$price = $product['price'];
$description = $product['description'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $description = $_POST['description'];
  $price = $_POST['price'];

  if (!$title) {
    $errors[] = "Product title is required";
  }
  
  if (!$price) {
    $errors[] = "Product price is required";
  }
  
  if (!is_dir('images')) {
    mkdir('images');
  }
  
  if (empty($errors)) {
    
    $image = $_FILES['image'] ?? null; // uploadinto failo pav.
    $imagePath = $product['image'];
    

    if ($image && $image['tmp_name']) {
  // if product has image
    if ($product['image']) {
      unlink($product['image']);
    }
      $imagePath = 'images/'.randomString(8).'/'.$image['name'];
      
      mkdir(dirname($imagePath));

      move_uploaded_file($image['tmp_name'], $imagePath);
    }

$statemenet = $pdo->prepare("UPDATE products SET title = :title, image = :image, description = :description, price = :price WHERE id = :id");

//TODO: we bind :title to my variable $title;
$statemenet->bindValue(':title', $title);
$statemenet->bindValue(':image', $imagePath);
$statemenet->bindValue(':description', $description);
$statemenet->bindValue(':price', $price);
$statemenet->bindValue(':id', $id);

// After everything
$statemenet->execute(); // makes a change in the database;
header('Location: index.php');
exit;
  }
}

function randomString($n) {
  $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $str = '';
  for ($i = 0; $i < $n; $i++) {
    $index = rand(0,strlen($chars) - 1);
    $str .= $chars[$index];
  }
  return $str;
}
?>
<?php include_once "views/partials/header.php"; ?>
<h1>Update item: <?= $product['title'] ?></h1>
<?php include_once "views/products/form.php" ?>
</body>

</html>