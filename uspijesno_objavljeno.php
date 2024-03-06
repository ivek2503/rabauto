<?php
session_start();


if (!isset($_SESSION["user_id"])) {

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
<nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="pocetna.php">RabAUTO</a>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="pronadi.php">Pronađi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="objavi.php">Objavi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="racun.php">Račun</a>
        </li>
        <li class="nav-item">
          <button class="btn btn-danger ml-2" onclick="odjava()">Odjavi se</button>
        </li>
      </ul>
    </div>
  </div>
</nav>

<br><br><br><br><br><br><br><br>
<div class="container">
    <div class="success-message">
        <i class="fas fa-check-circle fa-5x text-success"></i> 
        <h1>Oglas je uspješno objavljen</h1>
    </div>
</div>

<footer class="bg-dark text-white py-4 fixed-bottom">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <p>Stranica za završni rad - Ivan Magdalenić</p>
      </div>
      <div class="col-md-6 text-end">
        <button onclick="topFunction()" id="back-to-top-btn" class="btn btn-light"><i class="fas fa-arrow-up"></i> Povratak na vrh</button>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-6">
        <ul class="list-inline">
          <li class="list-inline-item"><a href="https://www.facebook.com/ivan.magdalenic.3" class="text-white"><i class="fab fa-facebook-square"></i></a></li>
          <li class="list-inline-item"><a href="https://www.instagram.com/magdalenic25?igsh=MXNqN2VxMWFpM3V2MQ%3D%3D&utm_source=qr" class="text-white"><i class="fab fa-instagram"></i></a></li>
          
        </ul>
      </div>
      <div class="col-md-6 text-end">
        <p>&copy; 2024 Ivan Magdalenić</p>
      </div>
    </div>
  </div>
</footer>




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