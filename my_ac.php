<?php
require('checkcredi.php');
?>

<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Include your database connection file
  // include('db_connection.php');

  // Retrieve and sanitize form data
  $fullName = mysqli_real_escape_string($conn, $_POST["uname"]);
  $mobile = mysqli_real_escape_string($conn, $_POST["umobile"]);
  $email = mysqli_real_escape_string($conn, $_POST["umail"]);
  // $userName = mysqli_real_escape_string($conn, $_POST["user_name"]);
  $password = sha1($_POST["password"]); // Hash the password

  // $q = "SELECT * FROM user_login WHERE user_name = '" . $userName . "'"; // use to check duplicate user

  // $result = $conn->query($q);
  if (true/*!($result->num_rows > 0)*/) {


    $u_login_id = 0;
    // Insert data into the database
    $query1 = "UPDATE user_login
    SET password = '$password' WHERE id = " . $_SESSION['user']['id'];

    $result = $conn->query($query1);
    if ($result) {
      $result_id = $conn->query("SELECT * FROM user_login order by id desc limit 1");
      while ($row = $result_id->fetch_assoc()) :
        $u_login_id = $row['id'];
      endwhile;
    }
    $query2 = "UPDATE user_meta
    SET uname = '$fullName', umobile = '$mobile', umail = '$email'
    WHERE u_login_id = " . $_SESSION['user']['id'];
    $result = $conn->query($query2);
    if ($result) {
      // echo "user created";
      echo "<script>alert('user updated');</script>";
      // header("Location: login.php");
    } else {
      echo "<script>alert('user failed')";
    }
  } else {
    echo "<script>alert('user name alerdy exist')";
  }

  // Close the database connection
  // mysqli_close($conn);
}
?>

<script>
  $(document).ready(function() {
    $('#password, #confirmPassword').on('keyup', function() {
      if ($('#password').val() == $('#confirmPassword').val()) {
        $('#passwordMatch').html('Matching').css('color', 'green');
      } else {
        $('#passwordMatch').html('Not Matching').css('color', 'red');
      }
    });

    function checkPass() {
      if ($('#password').val() == $('#confirmPassword').val()) {
        return true;
      }
      return false;
    }
  });

  function checkPass() {
    if ($('#password').val() == $('#confirmPassword').val()) {
      return true;
    }
    return false;
  }
</script>

<?php
$q = 'SELECT uname, umobile, umail, user_name FROM user_meta INNER JOIN user_login ON
      user_meta.u_login_id = user_login.id
      WHERE user_login.id = ' . $_SESSION['user']['id'];

$result = $conn->query($q);
$i = 1;
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) :
?>



    <div class="container mt-5">
      <form method="post" onsubmit="return checkPass()">
        <div class="mb-3">
          <label for="fullName" class="form-label">Full Name</label>
          <input value="<?php echo isset($row['uname']) ? $row['uname'] : '' ?>" type="text" class="form-control shadow" id="fullName" name="uname" placeholder="Enter your full name" required>
        </div>

        <div class="mb-3">
          <label for="mobile" class="form-label">Mobile</label>
          <input value="<?php echo isset($row['umobile']) ? $row['umobile'] : '' ?>" type="tel" class="form-control shadow" id="mobile" name="umobile" placeholder="Enter your mobile number" required>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input value="<?php echo isset($row['umail']) ? $row['umail'] : '' ?>" type="email" class="form-control shadow" id="email" name="umail" placeholder="Enter your email address" required>
        </div>

        <div class="mb-3">
          <label for="userName" class="form-label">User Name</label>
          <input value="<?php echo isset($row['user_name']) ? $row['user_name'] : '' ?>" type="text" class="form-control shadow disabled" style="background:rgba(128,128,128, 0.5);" id="userName" placeholder="Choose a username" required readonly>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control shadow" id="password" name="password" placeholder="Enter your password" required>
        </div>

        <div class="mb-3">
          <label for="confirmPassword" class="form-label">Confirm Password</label>
          <input type="password" class="form-control shadow" id="confirmPassword" placeholder="Confirm your password" required>
          <small id="passwordMatch"></small>
        </div>

        <button type="submit" class="btn btn-primary w-25 shadow">Submit</button>
        <a href="index.php" class="btn btn-secondary w-25 shadow">Cancle</a>
      </form>
    </div>

  <?php
    $i++;
  endwhile;
} else {
  ?>
  <td class="text-center" colspan="7">Oops! Something Wrong.<br> No Records Found.</td>

<?php
}
?>