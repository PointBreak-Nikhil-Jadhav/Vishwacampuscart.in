<?php
require('checkcredi.php');
?>

<style>
  .card {
    margin: 10px;
  }

  .pro-img {
    height: 20rem;
  }
</style>
<div class="container mt-3 d-flex justify-content-between align-items-center flex-wrap">

  <?php
  if (isset($_GET['fsearch'])) {
    $q = 'SELECT product.id as id, pro_name, prodes, price, file_name_1, file_name_2, file_name_3
    FROM product
    INNER JOIN pro_img
    on product.id = pro_img.pro_id
    LEFT JOIN category
    on category.id = product.cat_id
    where status = 1 and (tags like \'%' . $_GET['fsearch'] . '%\'  OR cat_name like \'%' . $_GET['fsearch'] . '%\')';
  } else if (isset($_GET['cat_id'])) {
    $q = 'SELECT product.id as id, pro_name, prodes, price, file_name_1, file_name_2, file_name_3
    FROM product
    INNER JOIN pro_img
    on product.id = pro_img.pro_id
    INNER JOIN category
    on category.id = product.cat_id
    where status = 1 and category.id = ' . $_GET['cat_id'];
  } else {
    $q = 'SELECT product.id as id, pro_name, prodes, price, file_name_1, file_name_2, file_name_3
        FROM product
        INNER JOIN pro_img
        on product.id = pro_img.pro_id
        where status = 1';
  }


  $result = $conn->query($q);

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) :
  ?>

      <div class="card" style="width: 20rem;">
        <div id="productCarousel" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active d-flex justify-content-center align-items-center pro-img">
              <img src="upload/<?php echo $row['file_name_1']; ?>" class="d-block w-100" alt="Product Image 1">
            </div>
          </div>
        </div>
        <div class="card-body">
          <h5 class="card-title">
            <?php echo $row['pro_name']; ?>
          </h5>
          <p class="card-text">
            <?php echo $row['prodes']; ?>
          </p>
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item">Price: &#8377;
            <?php echo $row['price']; ?>
          </li>
        </ul>
        <div class="card-body">
          <a href="index.php?page=pro_detail&id=<?php echo $row['id']; ?>" class="btn btn-primary">More Details</a>
        </div>
      </div>

    <?php
    endwhile;
  } else {
    ?>
    <div class="container mt-5">
      <div class="alert alert-warning" role="alert">
        <h4 class="alert-heading">Oops!</h4>
        <p>This product is not available. Please check back later or explore our other products.</p>
        <hr>
        <p class="mb-0">
          <a href="index.php?page=list" class="btn btn-primary">Browse Products</a>
        </p>
      </div>
    </div>
  <?php
  }
  ?>



</div>