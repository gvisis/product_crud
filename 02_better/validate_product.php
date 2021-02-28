<?php
$title = $_POST['title'];
$description = $_POST['description'];
$price = $_POST['price'];
$date = date('Y-m-d H:i:s');
$imagePath = '';

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
  $imagePath = $product['image'];
  
  // check if image exists and name is not empty, otherwise will make empty folder for empty image
  if ($image && $image['tmp_name']) {
    if ($product['image']) {
      unlink($product['image']);
    };
    
    // unique imagepath for image so filename doesnt repeat
    $imagePath = 'images/'.randomString(8).'/'.$image['name'];
    
    // accepts the filepath and returns directory where filepath is located
    mkdir(dirname($imagePath));
    //TODO: needs unique name for the image, as others can owerwrite it
    move_uploaded_file($image['tmp_name'], $imagePath);
  }
}
  // exit;
// ka norim insertint i DB
// products - db per kuria susisiekiam, title image yra indexai 
// When we get data from user and we want to put that data in the DB we use prepare() not exec() because its safer and of SQL injections.
?>