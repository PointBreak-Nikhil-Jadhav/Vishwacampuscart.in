<?php
if (isset($_SESSION['user'])) {
  // header("Location: index.php");
} else {
  // header("Location: login.php");
  ?>
  <script>window.location.replace('login.php');</script>
  <?php
}
?>