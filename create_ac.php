<?php
if (isset($_SESSION['user'])) {
  // header("Location: index.php");
  ?>
  <script>window.location.replace('index.php');</script>
  <?php
}
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
  $userName = mysqli_real_escape_string($conn, $_POST["user_name"]);
  $password = sha1($_POST["password"]); // Hash the password

  $q = "SELECT * FROM user_login WHERE user_name = '" . $userName . "'";

  $result = $conn->query($q);
  if (!($result->num_rows > 0)) {


    $u_login_id = 0;
    // Insert data into the database
    $query1 = "INSERT INTO user_login ( user_name, password) VALUES('$userName', '$password'); ";

    $result = $conn->query($query1);
    if ($result) {
      $result_id = $conn->query("SELECT * FROM user_login order by id desc limit 1");
      while ($row = $result_id->fetch_assoc()) :
        $u_login_id = $row['id'];
      endwhile;
    }
    $query2 = "INSERT INTO user_meta (u_login_id, uname, umobile, umail) VALUES (" . $u_login_id . ", '$fullName', '$mobile', '$email');";
    $result = $conn->query($query2);
    if ($result) {
      // echo "user created";
      echo "<script>alert('user created');
    window.location.href = 'login.php';</script>";
      // header("Location: login.php");
    } else {
      echo "user failed";
    }
  } else {
    echo "<script>alert('user name alerdy exist')";
  }

  // Close the database connection
  mysqli_close($conn);
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
</script>
<!-- Add this script in the head section -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
  $(document).ready(function () {
    $('#email, #userName').on('blur', function () {
      validateEmailAndUserName();
    });

    function validateEmailAndUserName() {
      // Validate email
      var email = $('#email').val();
      if (!isValidEmail(email)) {
        $('#emailError').text('Invalid email address. It should end with @vit.edu');
      } else {
        $('#emailError').text('');
      }

      // Validate user name
      var userName = $('#userName').val();
      if (!isValidUserName(userName)) {
        $('#userNameError').text('Invalid user name. It should end with @vit.edu');
      } else {
        $('#userNameError').text('');
      }
    }

    function isValidEmail(email) {
      return email.endsWith('@vit.edu');
    }

    function isValidUserName(userName) {
      return userName.endsWith('@vit.edu');
    }

    $('#password, #confirmPassword').on('keyup', function () {
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

    // Form submission
    $('#myForm').submit(function (event) {
      if (!isValidEmail($('#email').val()) || !isValidUserName($('#userName').val())) {
        event.preventDefault(); // Prevent form submission if email or user name is invalid
        alert('Please correct the email and/or user name before submitting the form.');
      }
    });
  });
</script>


<div class="container mt-5">
  <form method="post" id="myForm" onsubmit="checkPass();">
    <div class="mb-3">
      <label for="fullName" class="form-label">Full Name</label>
      <input value="<?php echo isset($_POST['uname']) ? $_POST['uname'] : '' ?>" type="text" class="form-control shadow" id="fullName" name="uname" placeholder="Enter your full name" required>
    </div>

    <div class="mb-3">
      <label for="mobile" class="form-label">Mobile</label>
      <input value="<?php echo isset($_POST['umobile']) ? $_POST['umobile'] : '' ?>" type="tel" class="form-control shadow" id="mobile" name="umobile" placeholder="Enter your mobile number" required>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input value="<?php echo isset($_POST['umail']) ? $_POST['umail'] : '' ?>" type="email" class="form-control shadow" id="email" name="umail" placeholder="Enter your email address" required>
      <span id="emailError" class="error"></span>
    </div>

    <div class="mb-3">
      <label for="userName" class="form-label">User Name</label>
      <input value="<?php echo isset($_POST['user_name']) ? $_POST['user_name'] : '' ?>" type="text" class="form-control shadow" id="userName" name="user_name" placeholder="Choose a username" required>
      <span id="userNameError" class="error"></span>
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