<?php
require_once "database.php";
require_once "functions.php";

// errors turi but virsuje, nes kitaip nemato kai tuscias create.php
$errors = [];

// issirasom situos i virsu, kad refreshinus atsimintu puslapis kas buvo ivesta jeigu yra klaida
$title = '';
$price = '';
$description = '';
$product = [
  'image' => ''
];
// We need to check if method is POST only then we add something to DB 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require_once "validate_product.php";
  if (empty($errrors)) {
    $statemenet = $pdo->prepare("INSERT INTO products (title, image, description, price, create_date)
                  VALUES (:title, :image, :description, :price, :date)");

    //TODO: we bind :title to my variable $title;
    $statemenet->bindValue(':title', $title);
    $statemenet->bindValue(':image', $imagePath);
    $statemenet->bindValue(':description', $description);
    $statemenet->bindValue(':price', $price);
    $statemenet->bindValue(':date', date('Y-m-d H:i:s'));

    // After everything
    $statemenet->execute(); // makes a change in the database;
    header('Location: index.php');
    exit;
  }
}
?>
<?php include_once "views/partials/header.php"; ?>
<h1>Create new product</h1>

<?php include_once "views/products/form.php" ?>

</body>

</html>