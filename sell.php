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
  $cat_id = $_POST["cat_id"];

  // Insert data into the database
  $sql = "INSERT INTO product (pro_name, prodes, status, price, user_id, tags, cat_id) 
  VALUES ('$pro_name', '$prodes', 1, $price, " . $_SESSION['user']['id'] . ", '$tags', $cat_id)";


  if ($conn->query($sql)) {
    $result_id = $conn->query("SELECT * FROM product order by id desc limit 1");
    while ($row = $result_id->fetch_assoc()) :
      $pro_id = $row['id'];
    endwhile;

    if (
      $conn->query("INSERT INTO pro_img (pro_id, file_name_1, file_name_2, file_name_3) 
                  VALUES($pro_id, '" . $pro_id . "-f1.jpg', '" . $pro_id . "-f2.jpg', '" . $pro_id . "-f3.jpg')")
    ) {
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
    } else {
      echo "Record added successfully, but image upload failed!";
    }
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
?>
<div class="container mt-5">
  <form method="post" enctype="multipart/form-data">
    <!-- Product Name -->
    <div class="mb-3">
      <label for="productName" class="form-label">Product Name</label>
      <input type="text" class="form-control shadow" name="productName" placeholder="Enter product name" required>
    </div>

    <!-- Description -->
    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea class="form-control shadow" name="description" rows="3" placeholder="Enter product description" required></textarea>
    </div>

    <!-- Price -->
    <div class="mb-3">
      <label for="price" class="form-label">Price</label>
      <input type="number" class="form-control shadow" name="price" placeholder="Enter product price" min="1" required>
      <small id="priceHelp" class="form-text text-danger"></small>
    </div>

    <!-- Image Upload with Preview -->
    <div class="mb-3">
      <label for="image1" class="form-label">Image 1</label>
      <input type="file" class="form-control shadow" name="image1" accept="image/*" require>
      <img id="preview1" class="img-thumbnail mt-2" style="max-width: 200px;">
    </div>

    <div class="mb-3">
      <label for="image2" class="form-label">Image 2</label>
      <input type="file" class="form-control shadow" name="image2" accept="image/*">
      <img id="preview2" class="img-thumbnail mt-2" style="max-width: 200px;">
    </div>

    <div class="mb-3">
      <label for="image3" class="form-label">Image 3</label>
      <input type="file" class="form-control shadow" name="image3" accept="image/*">
      <img id="preview3" class="img-thumbnail mt-2" style="max-width: 200px;">
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
          while ($row = $result->fetch_assoc()) :
        ?>
            <option value="<?php echo $row['id'] ?>"><?php echo $row['cat_name']; ?></option>
        <?php
            $i++;
          endwhile;
        } ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="" class="form-label">Tags (Seprated By Comma,)</label>
      <input class="form-control shadow" name="tags" placeholder="Enter product tags for boost">
    </div>


    <!-- Submit Button -->
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>

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