<?php

require_once "../../database.php";

// ID might not be given
$id = $_POST['id'] ?? null;

// jeigu tokio id nera, redirectina i index.php
if (!$id) {
  header("Location: index.php");
  exit;
}

$statement = $pdo->prepare('DELETE FROM products WHERE id = :id');
$statement->bindValue(':id', $id);
$statement->execute();

header("Location: index.php");


?>