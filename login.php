<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM korisnici
                    WHERE email_adresa = '%s'",
                   $mysqli->real_escape_string($_POST["email_adresa"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["hash_lozinka"])) {
            echo "Lozinka je ispravna!";
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["ID"];
            
            if ($user["admin"] == 1) {
                header("Location: admin.php");
            } else {
                header("Location: index.php");
            }
            exit;
        }
    }
    
    $is_invalid = true;
    echo $mysqli->error;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>PRIJAVA</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    
    <div class="container mt-5">
        <h1>PRIJAVA</h1>
        
        <?php if ($is_invalid): ?>
        <div class="alert alert-danger" role="alert">Neispravni podaci za prijavu. Molimo pokušajte ponovno.</div>
        <?php endif; ?>
        
        <form method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email_adresa" id="email_adresa"
                       value="<?= htmlspecialchars($_POST["email_adresa"] ?? "") ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Prijava</button>
        </form>
        <p class="mt-3">Nemaš račun? <a href="signup.php">Stvori ga!</a></p>
    </div>
    
</body>
</html>

