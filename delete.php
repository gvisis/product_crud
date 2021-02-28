<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ID might not be given
$id = $_POST['id'] ?? null;

// jeigu tokio id nera, redirectina i index.php
if (!$id) {
  header("Location: index.php");
  exit;
}
var_dump($id);
?>