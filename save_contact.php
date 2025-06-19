<?php
$servername = "localhost";
$username = "root"; // Cambia si es necesario
$password = ""; // Cambia si es necesario
$dbname = "web";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$nombre = trim($_POST['Name'] ?? '');
$email = trim($_POST['Email'] ?? '');
$mensaje = trim($_POST['Mensaje'] ?? '');

// Validar datos básicos
if (empty($nombre) || empty($email) || empty($mensaje)) {
    die("Error: Todos los campos son obligatorios.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Error: El correo electrónico no es válido.");
}

// Sanitizar datos
$nombre = htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
$mensaje = htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8');

// Preparar y bind
$stmt = $conn->prepare("INSERT INTO contactos (Nombre, Email, Mensaje) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nombre, $email, $mensaje);

if ($stmt->execute()) {
    echo "Registro guardado correctamente.";
} else {
    echo "Error al guardar el registro: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
