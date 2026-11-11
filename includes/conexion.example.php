<?php

$servidor = "HOST_DE_BASE_DE_DATOS";
$baseDatos = "NOMBRE_DE_BASE_DE_DATOS";
$usuario = "USUARIO_DE_BASE_DE_DATOS";
$contrasena = "CONTRASENA_DE_BASE_DE_DATOS";

try {
    $conexion = new PDO(
        "mysql:host=$servidor;dbname=$baseDatos;charset=utf8mb4",
        $usuario,
        $contrasena
    );

    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $error) {
    error_log("Error de conexión: " . $error->getMessage());
    die("No fue posible conectar con la base de datos.");
}
?>