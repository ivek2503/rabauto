<?php

session_start();

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM korisnici
            WHERE ID = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    
    <?php if (isset($user)): 
        
        //<!--<p>Pozdrav, <?= htmlspecialchars($user["username"]) !</p>
        
        //<p><a href="logout.php">Log out</a></p>-->
        header("location:/rabauto/pocetna.php"); 
        
    else: 
    header("location:/rabauto/login.php"); 
    endif; ?>
    
</body>
</html>
