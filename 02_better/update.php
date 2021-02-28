<?php

require_once "database.php";
require_once "functions.php";

$id = $_GET['id'] ?? null;
if (!$id) {
  header("Location: index.php");
  exit;
}

// Select specific product from DB
$statement = $pdo->prepare('SELECT * FROM products WHERE id = :id');
$statement->bindValue(':id', $id);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);

$errors = [];

$title = $product['title'];
$price = $product['price'];
$description = $product['description'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  require_once "validate_product.php";
  
  if (empty($errors)) {
   
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

?>
<?php include_once "views/partials/header.php"; ?>

<h1>Update item: <?= $product['title'] ?></h1>

<?php include_once "views/products/form.php" ?>

</body>

</html>