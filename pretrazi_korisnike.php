<?php
session_start();

include "database.php";

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

// Provjera je li postavljen tekst za pretragu
if (isset($_POST['search_text'])) {
    $searchText = $_POST['search_text'];

    // SQL upit za pretragu korisnika po imenu ili emailu
    $sql = "SELECT * FROM korisnici WHERE username LIKE '%$searchText%' OR email_adresa LIKE '%$searchText%'";
    $result = $mysqli->query($sql);

    // Prikaz rezultata u tablici
    if ($result->num_rows > 0) {
        echo '<table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Ime</th>
                        <th>Prezime</th>
                        <th>Admin</th>
                    </tr>
                </thead>
                <tbody>';
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["ime"] . "</td>
                    <td>" . $row["prezime"] . "</td>
                    <td>" . $row["username"] . "</td>
                    <td>" . $row["email_adresa"] . "</td>
                    <td>
                    <form method='post' action='update_admin.php'> <!-- Forma za ažuriranje statusa admina -->
            <input type='hidden' name='user_id' value='".$row["ID"]."'>
            <input type='checkbox' name='admin' value='1' ". ($row['admin'] == 1 ? 'checked' : '') ." onchange='updateAdminStatus(this)'>
        </form>
                </td>
                </tr>";
        }
        echo '</tbody></table>';
    } else {
        echo '<p class="text-center">Nema rezultata.</p>';
    }
}
?>
<script>
function updateAdminStatus(checkbox) {
    // Prikupljanje podataka iz checkboxa i skrivenog polja (user_id)
    var adminStatus = checkbox.checked ? 1 : 0;
    var userId = checkbox.form.querySelector('[name="user_id"]').value;
    
    // Slanje AJAX zahtjeva za ažuriranje statusa admina
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "update_admin.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            // Ažurirajte sučelje ako je potrebno
        }
    };
    xhr.send("user_id=" + userId + "&admin=" + adminStatus);
}
</script>
