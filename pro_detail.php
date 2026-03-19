<?php
require('checkcredi.php');
?>
</style>
<style>
  .carousel-item {
    /* display: flex;
    justify-content: center;
    align-items: center; */
    text-align: center;
    height: 50vh;
  }

  .carousel-inner {}

  .carousel-inner img {
    max-width: 100%;
    height: 100%;
    margin: auto;
    background-color: rgba(0, 0, 0, 0.5);
  }
</style>
<?php
// $q = 'SELECT product.id as id, pro_name, prodes, price, file_name_1, file_name_2, file_name_3
//         FROM product
//         INNER JOIN pro_img
//         on product.id = pro_img.pro_id
//         where status = 1 and product.id = ' . $_GET["id"];

$q = '
SELECT 
  product.id as id, 
  pro_name, 
  prodes, 
  price, 
  tags,
  file_name_1, 
  file_name_2, 
  file_name_3, 
  user_meta.umobile, 
  user_meta.uname,
  user_meta.umail
FROM  
  product
INNER JOIN 
  pro_img
on 
  product.id = pro_img.pro_id
INNER JOIN 
  user_meta
ON 
  product.user_id = user_meta.u_login_id
where 
  status = 1 and product.id = ' . $_GET["id"];

$result = $conn->query($q);
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) :
?>

    <div id="carouselExampleIndicators" class="carousel slide m-5" data-bs-ride="carousel" data-bs-interval="3000">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="upload/<?php echo $row['file_name_1'] ?>" alt="" class="bd-placeholder-img bd-placeholder-img-lg d-block">
        </div>
        <div class="carousel-item">
          <img src="upload/<?php echo $row['file_name_2'] ?>" alt="" class="bd-placeholder-img bd-placeholder-img-lg d-block">

        </div>
        <div class="carousel-item">
          <img src="upload/<?php echo $row['file_name_3'] ?>" alt="" class="bd-placeholder-img bd-placeholder-img-lg d-block">
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>

    <div class="container mt-5 mb-5">
      <hr>
    </div>

    <!-- Product Details -->
    <div class="container mt-4">
      <div class="row">
        <div class="col col-md-6 col-sm-12">
          <h1><?php echo $row['pro_name']; ?></h1>
          <p class="lead"><?php echo $row['prodes']; ?></p>
          <p class="display-4">&#8377;<?php echo $row['price']; ?></p>

          <!-- Buttons -->
          <div class="m-4">
            <a href="tel:<?php echo $row['umobile'] ?>" class="btn btn-primary">Call Now</a>
            <a href="https://api.whatsapp.com/send?phone=8806288365&text=Hi%20i%20am%20user%20of%20_<?php echo $APP_NAME; ?>_%20and%20interested%20in%20your%20*<?php echo $row['pro_name']; ?>*%20product%20which%20has%20price%20<?php echo $row['price']; ?>%20INR%20." class="btn btn-success">Chat On WhatsApp</a>
            <!-- <button type="button" class="btn btn-outline-secondary">More Details</button> -->
          </div>
        </div>
        <div class="col col-md-6 col-sm-12 text-end">
          <span>Seller Details:</span>
          <h3><?php echo $row['uname']; ?></h3>
          <p class="lead">+91 <?php echo $row['umobile']; ?></p>
          <p class="lead"><?php echo $row['umail']; ?></p>
        </div>
      </div>
    </div>

    <div class="container mt-4">
      <fieldset>
        <legend>Tags</legend>
        <?php
        $tagsArray = explode(",", $row['tags']);
        $index = 0;
        $numberOfTags = count($tagsArray);

        // Use a while loop to iterate through the array and print each element
        while ($index < $numberOfTags) {
          // echo $tagsArray[$index] . "<br>";
          echo '<span class="badge text-bg-info m-1 p-2">' . $tagsArray[$index] . '</span>';
          $index++;
        }
        ?>

      </fieldset>
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