<?php
session_start();

// Povezivanje s bazom podataka
$mysqli = new mysqli('localhost', 'root', '', 'zavrsni_ivan_magdalenic');

// Provjera povezivanja s bazom podataka
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Provjera korisnikove sesije
if (!isset($_SESSION["user_id"])) {
    header("Location: /rabauto/login.php");
    exit;
}
echo var_dump($_POST);
// Provjera jesu li svi potrebni podaci prisutni
if (isset($_POST['model_id'], $_POST['godiste'], $_POST['kilometraza'], $_POST['cijena'], $_POST['snaga'], $_POST['opis'])) {
    // Podaci iz obrasca
    echo "bokic";
    $model = $_POST['model_id'];
    $godiste = $_POST['godiste'];
    $kilometraza = $_POST['kilometraza'];
    $cijena = $_POST['cijena'];
    $snaga = $_POST['snaga'];
    $opis = $_POST['opis'];
    $prodavac_id = $_SESSION["user_id"]; // ID prodavatelja dobiven iz sesije

    
    $datum = date("Y-m-d");

    // Unos oglasa
    $sql = "INSERT INTO oglasi (cijena, opis, godiste, kilometraza, snaga, datum_objave, ID_prodavaca, id_modela, aktivan) VALUES ($cijena, '$opis', $godiste, $kilometraza, $snaga, '$datum', $prodavac_id, $model, true)";

    if ($mysqli->query($sql) == true) {
        $oglas_id = $mysqli->insert_id; // ID novog oglasa
        var_dump($_FILES);
        // Spremanje slika
        $slike = $_FILES['slike'];

        foreach ($slike['tmp_name'] as $index => $tmp_name) {
            $naziv_slike = uniqid() . '_' . $slike['name'][$index]; // Generiranje jedinstvenog naziva slike
            $lokacija = "C:\\xampp\\htdocs\\rabauto\\slike\\" . $naziv_slike; // Putanja do slike

            // Premještanje slike na odredište
            move_uploaded_file($tmp_name, $lokacija);

            // Unos URL-a slike u bazu podataka
            $sql_slika = "INSERT INTO slike (id_oglas, url) VALUES ('$oglas_id', '$naziv_slike')";
            $mysqli->query($sql_slika);
        }

        // Preusmjeravanje nakon uspješnog spremanja
        header("Location: /rabauto/uspijesno_objavljeno.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $mysqli->error;
    }
}

$mysqli->close();
?>
