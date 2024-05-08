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
    header("Location: /rabauto/index.php"); 
    exit;
}

// Dohvaćanje marki iz baze podataka
$sql = "SELECT * FROM marke";
$result = $mysqli->query($sql);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["nova_marka"])) {
        $nova_marka = $_POST["nova_marka"];
        // Izvršavanje upita za dodavanje nove marke
        $sql_insert = "INSERT INTO marke (naziv_marke) VALUES ('$nova_marka')";
        if ($mysqli->query($sql_insert) === TRUE) {
            // Osvježavanje stranice
            header("Location: ".$_SERVER['PHP_SELF']); 
            exit;
        } else {
            echo "Error: " . $sql_insert . "<br>" . $mysqli->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>nove marke</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include "nav.php" ?><br><br>
    <div class="container"><br>
    <h2>Dodaj novu marku</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" class="form-control" name="nova_marka" placeholder="Unesite naziv nove marke" required>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">Dodaj</button>
                </div>
            </div>
        </form><br>
        <h2>Sve marke</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Naziv marke</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['ID_marke']; ?></td>
                        <td><?php echo $row['naziv_marke']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        
    </div>
</body>
</html>
