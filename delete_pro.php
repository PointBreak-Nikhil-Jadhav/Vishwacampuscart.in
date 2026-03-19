<?php
require('checkcredi.php');
?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  if (isset($_GET['id'])) {
    if (isset($_GET['delete'])) {
      if ($_GET['delete'] == 'true') {
        if (deletepro($_GET['id'], $conn)) {
          // delete success
?>
          <script>
            alert("Product Deleted.");
            window.location.replace('index.php?page=my_product')
          </script>
        <?php
        } else {
          // delete failed 
        ?>
          <script>
            alert("Product Deletion Failed.");
            window.location.replace('index.php?page=my_product')
          </script>
<?php
        }
      }
    }
  }
}

function deletepro($id, $conn): bool
{
  $ret = false;
  $q = "DELETE FROM product WHERE id = " . $id;
  echo $q;
  $result = $conn->query($q);
  if ($result) {
    $q = "DELETE FROM pro_img WHERE pro_id = " . $id;
    $result = $conn->query($q);
    $ret = true;
  }
  return $ret;
}
