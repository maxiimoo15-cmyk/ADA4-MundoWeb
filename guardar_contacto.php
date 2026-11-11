
<?php

// Verificar que el formulario se haya enviado mediante POST.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: contacto.html");
    exit;
}

// Recibir los datos del formulario.
$nombre = trim($_POST["nombre"] ?? "");
$correo = trim($_POST["correo"] ?? "");
$tema = $_POST["tema"] ?? "";
$mensaje = trim($_POST["mensaje"] ?? "");
$recomendacion = $_POST["recomendacion"] ?? "";
$acepto = isset($_POST["acepto"]);

// Validar los datos en el servidor.
$temasPermitidos = [
    "html",
    "css",
    "javascript",
    "historia",
    "otro"
];

$errores = [];

if (strlen($nombre) < 3 || strlen($nombre) > 80) {
    $errores[] = "El nombre debe tener entre 3 y 80 caracteres.";
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL) ||
    strlen($correo) > 150) {
    $errores[] = "El correo electrónico no es válido.";
}

if (!in_array($tema, $temasPermitidos, true)) {
    $errores[] = "Selecciona un tema válido.";
}

if (strlen($mensaje) < 10 || strlen($mensaje) > 500) {
    $errores[] = "El comentario debe tener entre 10 y 500 caracteres.";
}

if (!in_array($recomendacion, ["si", "no"], true)) {
    $errores[] = "Selecciona una recomendación válida.";
}

if (!$acepto) {
    $errores[] = "Debes confirmar la información antes de enviar.";
}

// Función para mostrar una respuesta al usuario.
function mostrarRespuesta($titulo, $contenido) {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo htmlspecialchars($titulo); ?> | MundoWeb</title>
        <link rel="stylesheet" href="css/estilos.css">
    </head>
    <body>
        <header class="encabezado">
            <a class="logo" href="index.html">MundoWeb</a>
            <nav class="menu">
                <a href="index.html">Inicio</a>
                <a href="contacto.html">Contacto</a>
            </nav>
        </header>

        <main>
            <section class="seccion">
                <h1><?php echo htmlspecialchars($titulo); ?></h1>
                <?php echo $contenido; ?>
                <p>
                    <a class="boton" href="contacto.html">
                        Volver al formulario
                    </a>
                </p>
            </section>
        </main>

        <footer class="pie">
            <p>MundoWeb | Proyecto académico</p>
        </footer>
    </body>
    </html>
    <?php
    exit;
}

// Si hay errores, mostrarlos.
if (!empty($errores)) {

    $contenido = "<ul>";

    foreach ($errores as $error) {
        $contenido .= "<li>" . htmlspecialchars($error) . "</li>";
    }

    $contenido .= "</ul>";

    mostrarRespuesta("Revisa tus datos", $contenido);
}

// Guardar la información en MySQL.
try {

    require_once "includes/conexion.php";

    $consulta = $conexion->prepare(
        "INSERT INTO mensajes_contacto
        (nombre, correo, tema, mensaje, recomendacion)
        VALUES
        (:nombre, :correo, :tema, :mensaje, :recomendacion)"
    );

    $consulta->execute([
        ":nombre" => $nombre,
        ":correo" => $correo,
        ":tema" => $tema,
        ":mensaje" => $mensaje,
        ":recomendacion" => $recomendacion
    ]);

    mostrarRespuesta(
        "¡Mensaje enviado correctamente!",
        "<p>Gracias por compartir tu opinión. Tu comentario fue guardado en nuestra base de datos.</p>"
    );

} catch (PDOException $error) {

    error_log("Error al guardar mensaje: " . $error->getMessage());

    mostrarRespuesta(
        "Error al enviar",
        "<p>No fue posible guardar tu comentario. Inténtalo nuevamente más tarde.</p>"
    );
}

?>
