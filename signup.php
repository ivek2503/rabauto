<!DOCTYPE html>
<html>

<head>
    <title>REGISTRACIJA</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">

    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
    <script src="/js/validation.js" defer></script>
</head>

<body>

    <h1>REGISTRACIJA</h1>

    <?php
    $errors = [];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (empty($_POST["ime"])) {
            $errors["ime"] = "Ime je obavezno polje";
        }

        if (empty($_POST["prezime"])) {
            $errors["prezime"] = "Prezime je obavezno polje";
        }

        if (empty($_POST["username"])) {
            $errors["username"] = "Korisničko ime je obavezno polje";
        }

        if (!filter_var($_POST["email_adresa"], FILTER_VALIDATE_EMAIL)) {
            $errors["email_adresa"] = "Unesite ispravnu email adresu";
        }

        if (strlen($_POST["password"]) < 8) {
            $errors["password"] = "Lozinka mora imati barem 8 znakova";
        }

        if (!preg_match("/[a-z]/i", $_POST["password"])) {
            $errors["password"] = "Lozinka mora sadržavati barem jedno slovo";
        }

        if (!preg_match("/[0-9]/", $_POST["password"])) {
            $errors["password"] = "Lozinka mora sadržavati barem jedan broj";
        }

        if ($_POST["password"] !== $_POST["password_confirmation"]) {
            $errors["password_confirmation"] = "Lozinke se moraju podudarati";
        }

        if (empty($errors)) {
            $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

            $mysqli = require __DIR__ . "/database.php";

            $checkEmailQuery = "SELECT COUNT(*) FROM korisnici WHERE email_adresa = ?";
            $checkEmailStmt = $mysqli->prepare($checkEmailQuery);

            if (!$checkEmailStmt) {
                die("SQL greška: " . $mysqli->error);
            }

            $checkEmailStmt->bind_param("s", $_POST["email_adresa"]);
            $checkEmailStmt->execute();
            $checkEmailStmt->bind_result($existingEmailCount);
            $checkEmailStmt->fetch();
            $checkEmailStmt->close();

            if ($existingEmailCount > 0) {
                $errors["email_adresa"] = "E-mail adresa '{$_POST["email_adresa"]}' već postoji. Molimo odaberite drugu e-mail adresu.";
            }

            $checkUsernameQuery = "SELECT COUNT(*) FROM korisnici WHERE username = ?";
            $checkUsernameStmt = $mysqli->prepare($checkUsernameQuery);

            if (!$checkUsernameStmt) {
                die("SQL greška: " . $mysqli->error);
            }

            $checkUsernameStmt->bind_param("s", $_POST["username"]);
            $checkUsernameStmt->execute();
            $checkUsernameStmt->bind_result($existingUsernameCount);
            $checkUsernameStmt->fetch();
            $checkUsernameStmt->close();

            if ($existingUsernameCount > 0) {
                $errors["username"] = "Korisničko ime '{$_POST["username"]}' već postoji. Molimo odaberite drugo korisničko ime.";
            }

            $sql = "INSERT INTO korisnici (ime, prezime, username, email_adresa, hash_lozinka)
                    VALUES (?, ?, ?, ?, ?)";

            $stmt = $mysqli->stmt_init();

            if (!$stmt->prepare($sql)) {
                die("SQL greška: " . $mysqli->error);
            }

            $stmt->bind_param(
                "sssss",
                $_POST["ime"],
                $_POST["prezime"],
                $_POST["username"],
                $_POST["email_adresa"],
                $password_hash
            );

            if ($stmt->execute()) {
                header("Location: signup-success.html");
                exit;
            } else {
                $errors["sql_error"] = "Greška prilikom izvršavanja SQL upita: " . $stmt->error;
            }
        }
    }
    ?>
    <?php foreach ($errors as $error) : ?>
        <div class="error-box">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form action="signup.php" method="post" id="signup" novalidate>
        <div>
            <label for="name">ime</label>
            <input type="text" id="ime" name="ime">
        </div>
        <div>
            <label for="name">prezime</label>
            <input type="text" id="prezime" name="prezime">
        </div>
        <div>
            <label for="name">korisničko ime</label>
            <input type="text" id="username" name="username">
        </div>
        <div>
            <label for="email">email</label>
            <input type="email" id="email_adresa" name="email_adresa">
        </div>
        <div>
            <label for="password">lozinka</label>
            <input type="password" id="password" name="password">
        </div>
        <div>
            <label for="password_confirmation">ponovi lozinku</label>
            <input type="password" id="password_confirmation" name="password_confirmation">
        </div>
        <button>Sign up</button>
    </form>

</body>

</html>