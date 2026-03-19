<?php
require('checkcredi.php');
?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Validate and sanitize input data
  $pro_name = $_POST["productName"];
  $prodes = $_POST["description"];
  $price = floatval($_POST["price"]);
  $tags = $_POST["tags"];
  $status = $_POST["status"];
  $cat_id = $_POST["cat_id"];

  // Insert data into the database
  // $sql = "INSERT INTO product (pro_name, prodes, status, price, user_id, tags) 
  // VALUES ('$pro_name', '$prodes', 1, $price, " . $_SESSION['user']['id'] . ", '$tags')";
  $sql = "UPDATE product 
        SET pro_name = '$pro_name', 
            prodes = '$prodes', 
            price = $price, 
            tags = '$tags',
            cat_id = $cat_id,
            status = $status 
        WHERE id = " . $_GET['id'] . " and user_id = " . $_SESSION['user']['id'];
  if ($conn->query($sql)) {
    $pro_id = $_GET['id'];
    $targetDir = "upload/";  // Specify the target directory where you want to save uploaded images
    $targetFile1 = $targetDir . $pro_id . "-f1.jpg";
    $targetFile2 = $targetDir . $pro_id . "-f2.jpg";
    $targetFile3 = $targetDir . $pro_id . "-f3.jpg";





    if (isset($_FILES['image1'])) {
      // $check1 = getimagesize($_FILES["image1"]["tmp_name"]);
      $check1 = true;
      if ($check1 !== false) {
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["image1"]["tmp_name"], $targetFile1)) {
          // echo "The file " . basename($_FILES["image1"]["name"]) . " has been uploaded.";
          // echo "Record added successfully";
        } else {
          // echo "Sorry, there was an error uploading your file. {img1}";
        }
      } else {
        echo "File is not an image.";
      }
    }



    if (isset($_FILES['image2'])) {
      // $check2 = getimagesize($_FILES["image2"]["tmp_name"]);
      $check2 = true;
      if ($check2 !== false) {
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["image2"]["tmp_name"], $targetFile2)) {
          // echo "The file " . basename($_FILES["image1"]["name"]) . " has been uploaded.";
          // echo "Record added successfully";
        } else {
          // echo "Sorry, there was an error uploading your file.  {img2}";
        }
      } else {
        echo "File is not an image.";
      }
    }



    if (isset($_FILES['image3'])) {
      // $check3 = getimagesize($_FILES["image3"]["tmp_name"]);
      $check3 = true;
      if ($check3 !== false) {
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["image3"]["tmp_name"], $targetFile3)) {
          // echo "The file " . basename($_FILES["image1"]["name"]) . " has been uploaded.";
          // echo "Record added successfully";
        } else {
          // echo "Sorry, there was an error uploading your file.  {img3}";
        }
      } else {
        echo "File is not an image.";
      }
    }


    echo "Record added successfully";
  }
}
?>

<?php
$q = 'SELECT product.id as id, pro_name, prodes, price, status, create_date, 
file_name_1, file_name_2, file_name_3, tags, cat_id
FROM product
INNER JOIN pro_img
on product.id = pro_img.pro_id
where user_id =' . $_SESSION['user']['id'] . ' and product.id = ' . $_GET['id'];

$result = $conn->query($q);
$i = 1;
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) :
?>

    <div class="container mt-5">
      <form method="post" enctype="multipart/form-data">
        <!-- Product Name -->
        <div class="mb-3">
          <label for="productName" class="form-label">Product Name</label>
          <input value="<?php echo $row['pro_name']; ?>" type="text" class="form-control shadow" name="productName" placeholder="Enter product name" required>
        </div>

        <!-- Description -->
        <div class="mb-3">
          <label for="description" class="form-label">Description</label>
          <textarea class="form-control shadow" name="description" rows="3" placeholder="Enter product description" required><?php echo $row['prodes']; ?></textarea>
        </div>

        <!-- Price -->
        <div class="mb-3">
          <label for="price" class="form-label">Price</label>
          <input value="<?php echo $row['price']; ?>" type="number" class="form-control shadow" name="price" placeholder="Enter product price" min="1" required>
          <small id="priceHelp" class="form-text text-danger"></small>
        </div>

        <div class="mb-3">
          <label for="status" class="form-label">Sold</label>
          <select name="status" id="" class="form-control shadow">
            <option value="0" <?php echo $row['status'] == '0' ? 'selected' : '' ?>>Yes</option>
            <option value="1" <?php echo $row['status'] == '1' ? 'selected' : '' ?>>No</option>
          </select>
        </div>


        <!-- Image Upload with Preview -->
        <div class="mb-3">
          <label for="image1" class="form-label">Image 1</label>
          <input type="file" class="form-control shadow" name="image1" accept="image/*" require>
          <img id="preview1" class="img-thumbnail mt-2" style="max-width: 200px;" src="<?php echo 'upload/' . $row['file_name_1']; ?>">
        </div>

        <div class="mb-3">
          <label for="image2" class="form-label">Image 2</label>
          <input type="file" class="form-control shadow" name="image2" accept="image/*">
          <img id="preview2" class="img-thumbnail mt-2" style="max-width: 200px;" src="<?php echo 'upload/' . $row['file_name_2']; ?>">
        </div>

        <div class="mb-3">
          <label for="image3" class="form-label">Image 3</label>
          <input type="file" class="form-control shadow" name="image3" accept="image/*">
          <img id="preview3" class="img-thumbnail mt-2" style="max-width: 200px;" src="<?php echo 'upload/' . $row['file_name_3']; ?>">
        </div>

        <!-- category -->
        <div class="mb-3">
          <label for="" class="form-label">Category</label>
          <select name="cat_id" id="" class="form-control shadow" require>
            <option value="" disabled selected>Select your prodcut category</option>
            <?php
            $q = 'SELECT id, cat_name FROM category';
            $result = $conn->query($q);
            $i = 1;
            if ($result->num_rows > 0) {
              while ($row0 = $result->fetch_assoc()) :
            ?>
                <option 
                value="<?php echo $row0['id'] ?>"
                <?php echo $row0['id'] == $row['cat_id']?'selected': '' ?>
                >
                <?php echo $row0['cat_name']; ?></option>
            <?php
                $i++;
              endwhile;
            } ?>
          </select>
        </div>

        <!-- tags -->
        <div class="mb-3">
          <label for="description" class="form-label">Tags (Seprated By Comma,)</label>
          <input value="<?php echo $row['tags']; ?>" class="form-control shadow" name="tags" placeholder="Enter product tags for boost">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary  w-25 shadow">Submit</button>
        <a href="index.php?page=my_product" class="btn btn-secondary  w-25 shadow">Cancle</a>
      </form>
    </div>



  <?php
    $i++;
  endwhile;
} else {
  ?>
  <div class="container mt-5">
    <div class="alert alert-warning" role="alert">
      <h4 class="alert-heading">Oops!</h4>
      <p>Something Wrong. This product is not available. </p>
      <hr>
      <p class="mb-0">
        <a href="index.php?page=my_product" class="btn btn-primary">Go To My Products</a>
      </p>
    </div>
  </div>
<?php
}
?>

<!-- jQuery and JavaScript for Image Preview -->
<script>
  $(document).ready(function() {
    $('#price').on('input', function() {
      const price = parseFloat($(this).val());
      const priceHelp = $('#priceHelp');

      if (isNaN(price) || price <= 0) {
        priceHelp.text('Please enter a valid price greater than 0.');
      } else {
        priceHelp.text('');
      }
    });

    function previewImage(inputNumber) {
      const fileInput = $(`#image${inputNumber}`);
      const preview = $(`#preview${inputNumber}`);

      fileInput.change(function() {
        const file = this.files[0];

        if (file) {
          const reader = new FileReader();

          reader.onload = function(e) {
            preview.attr('src', e.target.result);
          };

          reader.readAsDataURL(file);
        } else {
          preview.attr('src', ''); // Clear the preview if no file is selected
        }
      });
    }

    // Call previewImage for each image input
    previewImage(1);
    previewImage(2);
    previewImage(3);
  });
</script>