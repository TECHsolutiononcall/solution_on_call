<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inicializar variables
$nombre = $documento = $fechaCita = $correo = $telefono = $descripcion = "";
$mensaje = "";

// Verifica si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoge los datos del formulario de manera segura
    $nombre = htmlspecialchars(trim($_POST["NombreCompleto"]));
    $documento = htmlspecialchars(trim($_POST["NumeroDocumento"]));
    $fechaCita = htmlspecialchars(trim($_POST["FechaCita"]));
    $correo = htmlspecialchars(trim($_POST["Correo"]));
    $telefono = htmlspecialchars(trim($_POST["NumeroTelefono"]));
    $descripcion = htmlspecialchars(trim($_POST["Descripción"]));

    // Verifica si todos los campos requeridos están llenos
    if (!empty($nombre) && !empty($documento) && !empty($fechaCita) && !empty($correo) && !empty($telefono) && !empty($descripcion)) {
        // Configura la conexión a la base de datos
        $servername = "localhost"; // Cambia si tu servidor tiene otro nombre
        $username = "root"; // Cambia según tu configuración
        $password = ""; // Cambia según tu configuración
        $dbname = "tech_solutions"; // Cambia al nombre de tu base de datos

        // Crear conexión
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verifica la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Prepara la consulta SQL
        $stmt = $conn->prepare("INSERT INTO citas (nombre, documento, fecha, correo, telefono, descripcion) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nombre, $documento, $fechaCita, $correo, $telefono, $descripcion);

        // Ejecuta la consulta
        if ($stmt->execute()) {
            $mensaje = "<div class='alert alert-success'>Cita agendada con éxito.</div>";
        } else {
            $mensaje = "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }

        // Cierra la conexión
        $stmt->close();
        $conn->close();
    } else {
        $mensaje = "<div class='alert alert-warning'>Por favor completa todos los campos.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formulario de Cita</title>
    <link rel="icon" href="images/logos/logo_nosotros.png" type="image/gif" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css"> <!-- Asegúrate de tener este archivo -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif; /* Fuente general */
        }
        .form-container {
            background-color: #ffffff; /* Fondo blanco para el formulario */
            border-radius: 12px; /* Bordes redondeados */
            padding: 40px; /* Espaciado interno */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1); /* Sombra más pronunciada */
            margin-top: 50px;
        }
        .form-heading {
            margin-bottom: 30px;
            font-weight: bold; /* Negrita para el título */
        }
        .field_custom {
            border: 1px solid #ced4da; /* Borde del campo */
            border-radius: 5px; /* Bordes redondeados */
            padding: 12px; /* Espaciado interno */
            width: 100%;
            transition: border-color 0.3s; /* Transición suave */
        }
        .field_custom:focus {
            border-color: #007bff; /* Color del borde en foco */
            outline: none; /* Sin contorno */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Sombra en foco */
        }
        .btn {
            background-color: #007bff; /* Color del botón */
            color: white; /* Texto blanco */
            padding: 12px 25px; /* Espaciado interno */
            border-radius: 5px; /* Bordes redondeados */
            border: none; /* Sin borde */
            font-weight: bold; /* Negrita para el texto */
            transition: background-color 0.3s; /* Transición suave */
        }
        .btn:hover {
            background-color: #0056b3; /* Color en hover */
            transform: translateY(-2px); /* Efecto de elevación en hover */
        }
        .alert-container {
            margin-bottom: 20px; /* Espacio entre el mensaje y el formulario */
        }
        .footer {
            margin-top: 50px; /* Espaciado para el pie de página */
            text-align: center; /* Centrar el texto */
            font-size: 0.9em; /* Tamaño de fuente más pequeño */
        }
    </style>
</head>

<body>

<div class="container">
    <div class="form-container">
        <h2 class="text-center form-heading">Agendar Cita</h2>
        <?php if ($mensaje): ?>
            <div class="alert-container">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        <form action="simple_form.php" method="post">
            <div class="form-group">
                <label for="NombreCompleto">Nombre Completo</label>
                <input type="text" name="NombreCompleto" class="form-control field_custom" required>
            </div>
            <div class="form-group">
                <label for="NumeroDocumento">Número de Documento</label>
                <input type="text" name="NumeroDocumento" class="form-control field_custom" required>
            </div>
            <div class="form-group">
                <label for="FechaCita">Fecha de Cita</label>
                <input type="datetime-local" name="FechaCita" class="form-control field_custom" required>
            </div>
            <div class="form-group">
                <label for="Correo">Correo Electrónico</label>
                <input type="email" name="Correo" class="form-control field_custom" required>
            </div>
            <div class="form-group">
                <label for="NumeroTelefono">Número de Teléfono</label>
                <input type="text" name="NumeroTelefono" class="form-control field_custom" required>
            </div>
            <div class="form-group">
                <label for="Descripción">Descripción</label>
                <textarea name="Descripción" class="form-control field_custom" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>

            <div class="contenido">
                <p>Contenido de la página...</p>
            <!-- Agrega más contenido si lo necesitas -->
            </div>
              <!-- Botón flotante para WhatsApp -->
                <a href="https://wa.me/3116018024" class="btn-flotante-whatsapp" target="_blank">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/WhatsApp_icon.png" alt="WhatsApp" />
                </a>


        </form>
    </div>
</div>

<div class="footer">
    <p>&copy; 2024 Tech Solutions. Todos los derechos reservados.</p>
</div>

</body>
</html>
