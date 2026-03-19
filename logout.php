<?php
require_once('config.php');
?>


<?php
session_destroy();
// header("Location: index.php");
?>
  <script>window.location.replace('index.php');</script>
  <?php
?>