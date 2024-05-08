<?php
session_start();

// Povezivanje s bazom podataka
include "database.php";

// Provjeri je li postavljen ID marke
if (isset($_GET['marka_id'])) {
    $markaId = $_GET['marka_id'];

    // Izvrši upit za dohvaćanje modela povezanih s odabranom markom
    $sql = "SELECT modeli.id_modela, modeli.naziv_modela 
            FROM modeli  
            WHERE modeli.id_marke = $markaId
            ORDER BY modeli.naziv_modela ASC";
    $result = $mysqli->query($sql);

    // Spremi modele u polje
    $models = [];
    while ($row = $result->fetch_assoc()) {
        $models[] = $row;
    }

    // Vrati modele kao JSON
    echo json_encode($models);
} else {
    echo 'Nema podataka';
}
?>
