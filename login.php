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
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    
    <h1>PRIJAVA</h1>
    
    <?php if ($is_invalid): ?>
    <div class="error-box">Neispravni podaci za prijavu. Molimo pokušajte ponovno.</div>
    <?php endif; ?>
    
    <form method="post">
        <label for="email">email</label>
        <input type="email" name="email_adresa" id="email_adresa"
               value="<?= htmlspecialchars($_POST["email_adresa"] ?? "") ?>"  required>
        
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
        
        <button>Prijava</button>
    </form>
    <p>Nemaš račun? <a href="signup.php">Stvori ga!</a></p>
    
</body>
</html>