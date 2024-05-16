<?php
session_start();

include "database.php";

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
$sql = "SELECT * FROM marke ORDER BY naziv_marke ASC";
$result = $mysqli->query($sql);

$marke = [];
while ($row = $result->fetch_assoc()) {
    $marke[$row['ID_marke']] = $row['naziv_marke'];
}

$sql_zupanije = "SELECT * FROM zupanije ORDER BY naziv ASC";
$result_zupanije = $mysqli->query($sql_zupanije);

$zupanije = [];
while ($row_zupanije = $result_zupanije->fetch_assoc()) {
    $zupanije[$row_zupanije['id_zupanije']] = $row_zupanije['naziv'];
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $_SESSION['pretraga'] = $_POST;

    header("Location: /rabauto/rezultati.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RabAUTO - PRONAĐI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

</head>

<body>
    <?php include "nav.php"; ?>
    <br><br>
    <div class="container">
        <h1 class="mt-5 mb-3">Pretraži oglase</h1>
        <form method="post" action="rezultati.php" >
            <div class="mb-3">
                <label for="marka" class="form-label">
                    <H6>MARKA AUTOMOBILA</H6>
                </label>
                <select class="form-select" id="marka" name="marka">
                    <option value="">Odaberite marku</option>
                    <?php foreach ($marke as $id => $naziv_marke) : ?>
                        <option value="<?php echo $id; ?>"><?php echo $naziv_marke; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <hr>
            <div class="mb-3">
                <label for="model" class="form-label">
                    <h6>MODEL AUTOMOBILA</h6>
                </label>
                <select class="form-select" id="model" name="model" >
                    <option value="">Odaberite model</option>
                </select>
            </div>
            <hr>
            <div class="mb-3">
                <label for="zupanija" class="form-label">
                    <h6>ŽUPANIJA</h6>
                </label>
                <select class="form-select" id="zupanija" name="zupanija">
                    <option value="">Odaberite županiju</option>
                    <?php foreach ($zupanije as $id_zupanije => $naziv) : ?>
                        <option value="<?php echo $id_zupanije; ?>"><?php echo $naziv; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <hr>
            <div class="row">
                <h6>GODIŠTE</h6>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="min_godiste" class="form-label">Minimalno godište automobila</label>
                        <select class="form-select" id="min_godiste" name="min_godiste" required>
                            <option value="">Odaberite minimalno godište</option>
                            <?php
                            for ($i = 2024; $i >= 1970; $i--) {
                                echo "<option value='{$i}'>{$i}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="max_godiste" class="form-label">Maksimalno godište automobila</label>
                        <select class="form-select" id="max_godiste" name="max_godiste" required>
                            <option value="">Odaberite maksimalno godište</option>
                            <?php
                            for ($i = 2024; $i >= 1970; $i--) {
                                echo "<option value='{$i}'>{$i}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <hr>

            <div class="row">
                <h6>KILOMETRAŽA</h6>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="min_kilometraza" class="form-label">Minimalna kilometraža</label>
                        <input type="number" class="form-control" id="min_kilometraza" name="min_kilometraza" min="0" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="max_kilometraza" class="form-label">Maksimalna kilometraža</label>
                        <input type="number" class="form-control" id="max_kilometraza" name="max_kilometraza" min="0" required>
                    </div>
                </div>
            </div>
            <div id="kilometraza_slider"></div>
            <hr>
            <div class="row">
                <h6>CIJENA</h6>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="min_cijena" class="form-label">Minimalna cijena</label>
                        <input type="number" class="form-control" id="min_cijena" name="min_cijena" min="0" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="max_cijena" class="form-label">Maksimalna cijena</label>
                        <input type="number" class="form-control" id="max_cijena" name="max_cijena" min="0" required>
                    </div>
                </div>
            </div>
            <div id="cijena_slider"></div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="min_snaga" class="form-label">Minimalna konjska snaga:</label>
                        <input type="number" class="form-control" id="min_snaga" name="min_snaga" min="0" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="max_snaga" class="form-label">Maksimalna konjska snaga:</label>
                        <input type="number" class="form-control" id="max_snaga" name="max_snaga" min="0" required>
                    </div>
                </div>
            </div>
            <div id="snaga_slider"></div><br>
            <button type="submit" class="btn btn-primary">PRETRAŽI</button><br><br>
        </form>
    </div>

    <?php include "footer.php" ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
    <script>
        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }



        function odjava() {
            window.location.href = "/rabauto/logout.php";
        }



        $("#min_godiste").val(1970);
        $("#max_godiste").val(2024);




        $(document).ready(function() {
            $("#kilometraza_slider").slider({
                range: true,
                min: 0,
                max: 1000000, 
                step: 100,
                values: [0, 1000000], 
                slide: function(event, ui) {
                    $("#min_kilometraza").val(ui.values[0]);
                    $("#max_kilometraza").val(ui.values[1]);
                }
            });


            $("#min_kilometraza").val($("#kilometraza_slider").slider("values", 0));
            $("#max_kilometraza").val($("#kilometraza_slider").slider("values", 1));

            $("#min_kilometraza, #max_kilometraza").on("change", function() {
                var minKilometraza = $("#min_kilometraza").val();
                var maxKilometraza = $("#max_kilometraza").val();
                $("#kilometraza_slider").slider("values", [minKilometraza, maxKilometraza]);
            });
        });
        document.addEventListener('DOMContentLoaded', function() {

            document.getElementById('min_godiste').addEventListener('change', function() {
                var minGodiste = parseInt(this.value); 
                var maxGodisteDropdown = document.getElementById('max_godiste');

                for (var i = 1970; i <= 2024; i++) {
                    var option = maxGodisteDropdown.querySelector('option[value="' + i + '"]');
                    if (option !== null) {
                        option.disabled = false;
                    }
                }

                for (var i = 1970; i < minGodiste; i++) {
                    var option = maxGodisteDropdown.querySelector('option[value="' + i + '"]');
                    if (option !== null) {
                        option.disabled = true;
                    }
                }
            });
            document.getElementById('max_godiste').addEventListener('change', function() {
                var maxGodiste = parseInt(this.value); 
                var minGodisteDropdown = document.getElementById('min_godiste');

                for (var i = 1970; i <= 2024; i++) {
                    var option = minGodisteDropdown.querySelector('option[value="' + i + '"]');
                    if (option !== null) {
                        option.disabled = false;
                    }
                }

                for (var i = maxGodiste + 1; i <= 2024; i++) {
                    var option = minGodisteDropdown.querySelector('option[value="' + i + '"]');
                    if (option !== null) {
                        option.disabled = true;
                    }
                }
            });
        });




        $(document).ready(function() {

            $("#cijena_slider").slider({
                range: true,
                min: 0,
                max: 1000000,
                step: 100,
                values: [0, 1000000], 
                slide: function(event, ui) {
                    $("#min_cijena").val(ui.values[0]);
                    $("#max_cijena").val(ui.values[1]);
                }
            });

            $("#min_cijena").val($("#cijena_slider").slider("values", 0));
            $("#max_cijena").val($("#cijena_slider").slider("values", 1));


            $("#min_cijena, #max_cijena").on("change", function() {
                var minCijena = $("#min_cijena").val();
                var maxCijena = $("#max_cijena").val();
                $("#cijena_slider").slider("values", [minCijena, maxCijena]);
            });
        });



        $(document).ready(function() {
           
            $("#snaga_slider").slider({
                range: true,
                min: 0,
                max: 1000, 
                step: 10,
                values: [0, 1000], 
                slide: function(event, ui) {
            $("#min_snaga").val(ui.values[0]);
            $("#max_snaga").val(ui.values[1]);
        }
            });

            $("#min_snaga").val($("#snaga_slider").slider("values", 0));
            $("#max_snaga").val($("#snaga_slider").slider("values", 1));

            $("#min_snaga, #max_snaga").on("change", function() {
        var minSnaga = parseInt($("#min_snaga").val());
        var maxSnaga = parseInt($("#max_snaga").val());
        $("#snaga_slider").slider("values", [minSnaga, maxSnaga]);
    });
        });




        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('marka').addEventListener('change', function() {
                var markaId = this.value;
                var modelDropdown = document.getElementById('model');

                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            modelDropdown.innerHTML = '';

                            var models = JSON.parse(xhr.responseText);

                            var option = document.createElement('option');
                            option.text = "Odaberite model";
                            option.value = "";
                            modelDropdown.add(option);
                            models.forEach(function(model) {
                                var option = document.createElement('option');
                                option.text = model.naziv_modela;
                                option.value = model.id_modela;
                                modelDropdown.add(option);
                            });
                        } else {
                            console.error('Problem s dohvaćanjem modela');
                        }
                    }
                };

                xhr.open('GET', 'dohvati_modele.php?marka_id=' + markaId, true);
                xhr.send();
            });
        });

        function postaviModelID() {
            var modelDropdown = document.getElementById('model');
            var modelIDInput = document.getElementById('model_id');

            modelIDInput.value = modelDropdown.value;
        }
    </script>

<script>
        if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>

</html>