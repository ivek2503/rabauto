<?php
session_start();


include "database.php";


if (isset($_GET['marka_id'])) {
    $markaId = $_GET['marka_id'];

    $sql = "SELECT modeli.id_modela, modeli.naziv_modela 
            FROM modeli  
            WHERE modeli.id_marke = $markaId
            ORDER BY modeli.naziv_modela ASC";
    $result = $mysqli->query($sql);


    $models = [];
    while ($row = $result->fetch_assoc()) {
        $models[] = $row;
    }

    echo json_encode($models);
} else {
    echo 'Nema podataka';
}
?>
