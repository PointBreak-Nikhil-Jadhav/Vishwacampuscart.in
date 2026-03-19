<?php
require_once('config.php');
include('inc/header.php');
include('inc/topnavbar.php');
?>


<?php
if (isset($_SESSION['user'])) {
  // header("Location: index.php");
?>
  <script>
    window.location.replace('index.php');
  </script>
<?php
}
?>
<?php
$invalid_credentials;
$username;
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve user input
  $username = $_POST["username"];
  $password = sha1($_POST["password"]);
  // Validate input (add more validation as needed)
  if (empty($username) || empty($password)) {
    $invalid_credentials = "Please enter both username and password.";
  } else {
    // Hash the password (use appropriate hashing algorithm)

    // Check the user in the database
    $query = "SELECT * FROM user_login WHERE user_name = '$username' AND password = '$password'";
    $result = $conn->query($query);
    if ($result->num_rows == 1) {
      // User authenticated successfully
      // echo "Login successful! Redirecting...";

      while ($row = $result->fetch_assoc()) {
        $user = [
          'id' => $row["id"],
          'username' => $row["user_name"],
          'create_date' => $row["create_date"]
        ];
      }


      $_SESSION['user'] = $user;
      // Redirect to a different page or perform additional actions
      // header("Location: index.php");
?>
      <script>
        window.location.replace('index.php');
      </script>
<?php
      exit();
    } else {
      // Invalid credentials
      $invalid_credentials = "Invalid username or password.";
    }
  }
}

// Close the database connection
$conn->close();
?>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h3 class="text-center">Login</h3>
        </div>
        <div class="card-body pb-2">
          <form method="post">
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" >
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
              <span class="text-danger"><?php echo isset($invalid_credentials) ? $invalid_credentials : '' ?></span>
            </div>
            <button type="submit" class="btn btn-primary btn-block mt-2 float-end">Login</button>
          </form>
        </div>
        <div class="card-footer p-0 d-flex justify-content-center align-items-center" style="height: 100%;">
          <p class="m-0" style="height: 100%;">Don't have an account? <a href="index.php?page=create_ac">Create Account Here</a></p>
        </div>
      </div>
    </div>
  </div>
</div>



<?php include('inc/header.php') ?>