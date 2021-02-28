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