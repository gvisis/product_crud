<?php
// pdo - more powerfull, supports multiple db, Object oriented;
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
//? when theres error during connection, throw exception
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// errors turi but virsuje, nes kitaip nemato kai tuscias create.php
$errors = [];

// issirasom situos i virsu, kad refreshinus atsimintu puslapis kas buvo ivesta jeigu yra klaida
$title = '';
$price = '';
$description = '';

// We need to check if method is POST only then we add something to DB 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $description = $_POST['description'];
  $price = $_POST['price'];
  $date = date('Y-m-d H:i:s');

  if (!$title) {
    $errors[] = "Product title is required";
  }
  
  if (!$price) {
    $errors[] = "Product price is required";
  }
  
  // will create images folder if doesnt exist
  if (!is_dir('images')) {
    mkdir('images');
  }

  // patikrinam jeigu nera klaidu, TIK tada idedam i DB
  if (empty($errors)) {
    
    // IMAGE UPLOAD 
    $image = $_FILES['image'] ?? null; // uploadinto failo pav.
    $imagePath = '';
    
    // check if image exists and name is not empty, otherwise will make empty folder for empty image
    if ($image && $image['tmp_name']) {
      // unique imagepath for image so filename doesnt repeat
      $imagePath = 'images/'.randomString(8).'/'.$image['name'];
      
      // accepts the filepath and returns directory where filepath is located
      mkdir(dirname($imagePath));
      //TODO: needs unique name for the image, as others can owerwrite it
      move_uploaded_file($image['tmp_name'], $imagePath);
    }
    // exit;
// ka norim insertint i DB
// products - db per kuria susisiekiam, title image yra indexai 
// When we get data from user and we want to put that data in the DB we use prepare() not exec() because its safer and of SQL injections.

$statemenet = $pdo->prepare("INSERT INTO products (title, image, description, price, create_date)
              VALUES (:title, :image, :description, :price, :date)");

//TODO: we bind :title to my variable $title;
$statemenet->bindValue(':title', $title);
$statemenet->bindValue(':image', $imagePath);
$statemenet->bindValue(':description', $description);
$statemenet->bindValue(':price', $price);
$statemenet->bindValue(':date', $date);

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
  <h1>Create new product</h1>

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