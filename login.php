<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validar que se hayan enviado tanto el correo electrónico como la contraseña
    if (!isset($_POST["email"], $_POST["password"])) {
        die("Invalid request.");
    }
    
    $pdo = require __DIR__ . "/pdo_connection.php";
    
    // Preparar la consulta con un prepared statement
    $sql = "SELECT id, email, password FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $_POST["email"]]);
    
    // Obtener el usuario de la base de datos
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Verificar si se encontró un usuario y si la contraseña coincide
    if ($user && password_verify($_POST["password"], $user["password"])) {
        // Iniciar la sesión
        session_start();
        session_regenerate_id();
        $_SESSION["user_id"] = $user["id"];
        
        // Redirigir al usuario a la página de inicio
        header("Location: index.php");
        exit;
    }
    
    // Marcar el inicio de sesión como inválido si no se encontró el usuario o la contraseña es incorrecta
    $is_invalid = true;
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>

<body>

    <h1>Login</h1>

    <?php if ($is_invalid): ?>
    <p style="color: red;">Invalid email or password.</p>
    <?php endif; ?>

    <form method="post">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">

        <label for="password">Password</label>
        <input type="password" name="password" id="password">

        <button type="submit">Log in</button>
    </form>

</body>

</html>