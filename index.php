







<?php
require_once('config.php');
include('inc/header.php');
include('inc/topnavbar.php');


?>

<style>
  .bg-img-top {
    background-image: url('img/index-top-back.jpg');
    height: 80vh;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
  }

  .con {
    background-color: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(3px);
    width: 100%;
    height: 100%;
  }

  .con div p {
    text-shadow: 1px 1px 4px #fff;
  }
</style>


<?php
if (isset($_GET['page'])) {
  include($_GET['page'] . '.php');
} else {
?>
  <div class="container-fluid bg-img-top shadow">
    <div class="con">
      <div class="d-flex justify-content-center align-items-center position-absolute bottom-50 w-100">
        <p class="h1 text-center" style="font-weight: bold; font-size:4rem;">Buy, Sell & Exchange <br> <span style=" font-size:3rem;">Anything You Want!</span></p>
      </div>
      <div class="d-flex justify-content-center align-items-center position-absolute bottom-0 w-100 mb-5">
        <input id="search-ip-lg" class="form-control w-50 shadow-lg" style="font-size: 1.1rem;" type="search" placeholder="Search Your Need Here...." aria-label="Search">
        <button id="search-lg" class="btn btn-success ms-1 shadow-lg" style="font-size: 1.1rem;">Search</button>
      </div>
      <script>
        $('#search-lg').click(() => {
          window.location.replace(
            "index.php?page=list&fsearch=" + $('#search-ip-lg').val()
          );
        });
      </script>
    </div>
  </div>

  <div class="container d-flex justify-content-center align-items-center mt-5 mb-5">
    <a class="btn w-50 bg-secondary text-white fw-bold fs-4 shadow-lg" href="index.php?page=list">Expore</a>
  </div>
<?php
}
?>

<?php
include('inc/footer.php');
?>