<?php
session_start();

$mysqli = new mysqli('localhost', 'root', '', 'zavrsni_ivan_magdalenic');
// Provjera povezivanja s bazom podataka
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Provjera je li korisnik administrator
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
    header("Location: /rabauto/index.php");
    exit;
}

// Provjera postavljenosti podataka iz obrasca
if(isset($_POST['user_id']) && isset($_POST['admin'])){
    $user_id = $_POST['user_id'];
    $admin = $_POST['admin'];

    // Ažuriranje statusa admina u bazi podataka
    $sql_update_admin = "UPDATE korisnici SET admin = $admin WHERE ID = $user_id";
    if ($mysqli->query($sql_update_admin) === TRUE) {
        header("location: /rabauto/novi_admini.php ");
        exit;
    } else {
        echo "Greška prilikom ažuriranja statusa administratora: " . $mysqli->error;
    }
}
?>
