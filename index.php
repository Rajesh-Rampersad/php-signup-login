<?php
session_start();

$user = null;

if (isset($_SESSION["user_id"])) {
    $pdo = require __DIR__ . "/pdo_connection.php";

    $sql = "SELECT * FROM users WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $_SESSION["user_id"]]);
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
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

    <h1>Home</h1>

    <?php if (isset($user)): ?>

    <p>Hello <?= htmlspecialchars($user["name"]) ?></p>

    <p><a href="logout.php">Log out</a></p>

    <?php else: ?>

    <p><a href="login.php">Log in</a> or <a href="signup.html">sign up</a></p>

    <?php endif; ?>

</body>

</html>