<?php
session_start();

include "database.php";

// Provjera korisnikove sesije
if (!isset($_SESSION["user_id"])) {
    header("Location: /rabauto/login.php");
    exit;
}
$is_admin = false;
$user_id = $_SESSION["user_id"];
$sql_check_admin = "SELECT admin FROM korisnici WHERE ID = $user_id";
$result_check_admin = $mysqli->query($sql_check_admin);

if ($result_check_admin->num_rows > 0) {
    $row = $result_check_admin->fetch_assoc();
    $is_admin = $row['admin'] == 1;
}

// Ako korisnik nije administrator, preusmjeri ga na drugu stranicu
if (!$is_admin) {
    header("Location: /rabauto/index.php"); // Promijenite "index.php" u stranicu na koju želite preusmjeriti korisnika
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novi admini</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include "nav.php" ?><br><br>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Novi admini</h1>
        <!-- Tražilica -->
        <div class="mb-3">
            <input type="text" class="form-control" id="searchInput" placeholder="Pretraži korisnike po imenu ili emailu">
        </div>

        <!-- Tablica za prikaz rezultata -->
        <div id="searchResults" class="table-responsive">
            <!-- Podaci o korisnicima će se dinamički učitati ovdje -->
        </div>
    </div>

    <!-- Bootstrap JavaScript biblioteke -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            // Funkcija koja se poziva prilikom unosa teksta u tražilicu
            $('#searchInput').on('input', function(){
                var searchText = $(this).val().trim(); // Dohvati tekst iz tražilice

                // Ajax poziv za dohvat rezultata pretrage
                $.ajax({
                    url: 'pretrazi_korisnike.php', // PHP skripta koja će obraditi pretragu
                    method: 'post',
                    data: {search_text: searchText}, // Tekst za pretragu koji šaljemo na server
                    success: function(response){
                        $('#searchResults').html(response); // Prikaz rezultata pretrage na stranici
                    }
                });
            });
        });
    </script>
</body>
</html>
