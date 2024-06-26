<?php
session_start();


if (!isset($_SESSION["user_id"])) {

    header("Location: /rabauto/login.php");
    exit; 
}
define('SECRET_KEY', 'tajni_kljuc_za_hashiranje');


$user_id_hashed = hash_hmac('sha256', $_SESSION["user_id"], SECRET_KEY);


if (!isset($_COOKIE['user_id']) || $_COOKIE['user_id'] !== $user_id_hashed) {

    session_unset();
    session_destroy();
    

    header("Location: /rabauto/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RabAUTO - početna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>
<body>
<?php include "nav.php";?>



<div id="hero-carousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#hero-carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#hero-carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#hero-carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>

    <div class="carousel-inner">
      <div class="carousel-item active c-item">
        <img src="audi_RS6.jpg" class="d-block w-100 c-img" alt="Slide 1">
        <div class="carousel-caption top-0 mt-4">
          <p class="mt-5 fs-3 text-uppercase">Dobrodošli u svijet Rabljenih automobila!</p>
          <h1 class="display-1 fw-bolder text-capitalize">RabAUTO</h1>
          <a href="pronadi.php" class="btn btn-primary px-4 py-2 fs-5 mt-5">PRONAĐI</a>
      <a href="objavi.php" class="btn btn-primary px-4 py-2 fs-5 mt-5">OBJAVI</a>
        </div>
      </div>
      <div class="carousel-item c-item">
        <img src="auti2.jpg" class="d-block w-100 c-img" alt="Slide 2">
        <div class="carousel-caption top-0 mt-4">
          <p class="text-uppercase fs-3 mt-5">želiš pronaći automobil koji prilići tebi? pritisni gumb <b>pronađi</b> i zabavi se!</p>
          <p class="display-1 fw-bolder text-capitalize">PRONAĐI AUTOMOBIL</p>
          <a href="pronadi.php" class="btn btn-primary px-4 py-2 fs-5 mt-5">PRONAĐI</a>
        </div>
      </div>
      <div class="carousel-item c-item">
        <img src="auti3.jpg" class="d-block w-100 c-img" alt="Slide 3">
        <div class="carousel-caption top-0 mt-4">
          <p class="text-uppercase fs-3 mt-5">želiš li objaviti svoj automobil na naš oglasnik? Pritisni gumb <b>objavi</b> i ubrzo će ti se javiti kupac!</p>
          <p class="display-1 fw-bolder text-capitalize">OBJAVI OGLAS</p>
          <a href="objavi.php" class="btn btn-primary px-4 py-2 fs-5 mt-5">OBJAVI</a>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#hero-carousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#hero-carousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button><br><br><br>
  </div>
  <div class="container mt-5">
  <div class="row">
    <div class="col-md-4">
      <div class="card text-center h-100">
        <div class="card-body d-flex flex-column justify-content-center">
          <h5 class="card-title">Broj zadovoljnih kupaca</h5>
          <p class="card-text fs-1">6405 😊</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-center h-100">
        <div class="card-body d-flex flex-column justify-content-center">
          <h5 class="card-title">Broj prodanih automobila</h5>
          <p class="card-text fs-1">7234 🚗</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-center h-100">
        <div class="card-body d-flex flex-column justify-content-center">
          <h5 class="card-title">Broj postavljenih oglasa</h5>
          <p class="card-text fs-1">10794 📝</p>
        </div>
      </div>
    </div>
  </div>
</div><br><br><br><br><br>
<?php include "footer.php"?>




<script>
  
  function topFunction() {
    document.body.scrollTop = 0; 
    document.documentElement.scrollTop = 0; 
  }
  function odjava() {
    window.location.href = "/rabauto/logout.php";
}
</script>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>