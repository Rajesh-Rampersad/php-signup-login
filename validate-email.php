<?php

// Incluye el archivo de configuración de la base de datos
$pdo = include __DIR__ . "/pdo_connection.php"; // Asegúrate de que la extensión sea .php, no . .


$sql = "SELECT * FROM users WHERE email = :email";

// Intenta preparar la consulta SQL
$stmt = $pdo->prepare($sql);

// Verifica si la preparación de la consulta fue exitosa
if ($stmt === false) {
    die("Error preparing SQL statement");
}

// Intenta ejecutar la consulta preparada
if ($stmt->execute([':email' => $_GET["email"]]) === false) {
    die("Error executing SQL statement");
}

// Verifica si el correo electrónico está disponible
$is_available = $stmt->rowCount() === 0;

// Establece el encabezado de respuesta como JSON
header("Content-Type: application/json");

// Devuelve la respuesta como JSON
echo json_encode(["available" => $is_available]);