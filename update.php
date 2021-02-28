<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


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

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  <link rel="stylesheet" href="app.css">

  <title>Products Crud</title>
</head>

<body>
  <h1>Update item: <?= $product['title'] ?></h1>

  <!-- check if errors arrejus nera tuscisa(jei yra klaidu) -->
  <?php if (!empty($errors)): ?>
  <div class="alert alert-danger">
    <?php foreach($errors as $error): ?>
    <div><?= $error ?></div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <!-- to upload files we need enctype... -->
  <form action="" method="post" enctype="multipart/form-data">

    <?php if ($product['image']) : ?>
    <img src="<?= $product['image'] ?>" class='update-img'>
    <?php endif; ?>

    <div class="mb-3">
      <label>Product Image</label>
      <br>
      <input type="file" name="image">
    </div>
    <div class="mb-3">
      <label>Product title</label>
      <input type="text" class="form-control" name="title" value="<?= $title ?>">
    </div>
    <div class="mb-3">
      <label>Description</label>
      <textarea type="text" class="form-control" name="description"><?= $description ?></textarea>
    </div>
    <div class="mb-3">
      <label>Product price</label>
      <input type="number" step=".01" class="form-control" name="price" value="<?= $price ?>">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href='./index.php' class="btn btn-secondary">Back</a href='../'>
  </form>

</body>

</html>