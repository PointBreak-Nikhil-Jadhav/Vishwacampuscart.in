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
  <div class="container mt-5">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <h2>My Produts</h2>
      <a href="index.php?page=sell" class="btn btn-outline-success shadow">Add New Prodcut To Sell</a>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Description</th>
          <th scope="col" class="text-center">Status</th>
          <th scope="col" class="text-end">Price &#8377;</th>
          <th scope="col" class="text-end">Post Date</th>
          <th scope="col" class="text-center">Manage</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $q = 'SELECT product.id as id, pro_name, prodes, price, status, create_date, file_name_1, file_name_2, file_name_3
        FROM product
        INNER JOIN pro_img
        on product.id = pro_img.pro_id
        where user_id =' . $_SESSION['user']['id'];

        $result = $conn->query($q);
        $i = 1;
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) :
        ?>


            <tr>
              <th scope="row"><?php echo $i ?></th>
              <td><?php echo $row['pro_name']; ?></td>
              <td><?php echo $row['prodes']; ?></td>

              <td class="text-center">
                <?php
                if ($row['status'] == 0) {
                  echo '<span class="badge rounded-pill text-bg-success">Sold</span>';
                } else {
                  echo '<span class="badge rounded-pill text-bg-warning">Not Sold</span>';
                }
                ?>
              </td>

              <td class="text-end"><?php echo $row['price']; ?></td>
              <td class="text-end"><?php echo $row['create_date']; ?></td>
              <td class="text-center">
                <a class="shadow badge rounded-pill text-bg-primary p-2 w-50 m-1  text-decoration-none" href="index.php?page=manage_pro&id=<?php echo $row['id'] ?>">Edit</a>
                <a class="shadow badge rounded-pill text-bg-danger p-2 w-50 m-1 text-decoration-none" href="index.php?page=delete_pro&id=<?php echo $row['id'] ?>&delete=true">Delete</a>
              </td>
            </tr>


          <?php
            $i++;
          endwhile;
        } else {
          ?>
          <td class="text-center" colspan="7">Oops! No Records Found.</td>

        <?php
        }
        ?>

      </tbody>
    </table>
  </div>

</div>