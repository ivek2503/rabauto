<?php
// Povezivanje s bazom podataka
$mysqli = new mysqli('localhost', 'root', '', 'zavrsni_ivan_magdalenic');

// Provjera povezivanja s bazom podataka
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if(isset($_GET['marka_id']) && !empty($_GET['marka_id'])) {
    $selected_marke = $_GET['marka_id'];

    // Pripremi upit za dohvaćanje modela povezanih s odabranim markama
    $sql = "SELECT * FROM modeli WHERE modeli.id_marke IN (".implode(',',$selected_marke).")";

    // Izvrši upit
    $result = $mysqli->query($sql);

    // Inicijaliziraj niz za modele
    $modeli = array();

    // Dohvati sve modele i spremi ih u niz
    while($row = $result->fetch_assoc()) {
        $modeli[] = $row;
    }
    var_dump($modeli);
    // Vrati modele kao JSON
    echo json_encode($modeli);
}
?>
