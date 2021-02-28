<?php
// pdo - more powerfull, supports multiple db, Object oriented;
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
//? when theres error during connection, throw exception
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// select

$statement = $pdo->prepare('SELECT * FROM products ORDER BY create_date DESC');

$statement->execute();
// fetch all table as associative array
$products = $statement->fetchAll(PDO::FETCH_ASSOC);

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
  <h1>Products Crud</h1>
  <p>
    <a href="create.php" class="btn btn-success">Create Product</a href="create.php">
  </p>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Image</th>
        <th scope="col">Title</th>
        <th scope="col">Price</th>
        <th scope="col">Create Date</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($products as $i => $product): ?>
      <tr>
        <th scope="row"><?= $i+1 ?></th>
        <td>
          <img src="<?= $product['image'] ?> " class='thumb-img' alt="">
        </td>
        <td><?= $product['title']?></td>
        <td><?= $product['price']?></td>
        <td><?= $product['create_date']?></td>
        <td>
          <button type="button" class="btn btn-sm btn-outline-primary">Edit</button>
          <form style='display: inline-block;' action='delete.php' method='post'>
            <input type="hidden" name='id' value='<?= $product['id'] ?>'>
            <button type='submit' class="btn btn-sm btn-outline-danger">Delete</button>
          </form>

        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>

</html>