<?php
// =======================
// CONFIGURACIÓN DB
// =======================
$host = "localhost";
$user = "root";
$pass = "";
$db   = "tecnico";

// =======================
// CONEXIÓN
// =======================
$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// =======================
// CREAR BASE DE DATOS
// =======================
$conn->query("CREATE DATABASE IF NOT EXISTS $db");
$conn->select_db($db);

// =======================
// CREAR TABLA
// =======================
$sql = "
CREATE TABLE IF NOT EXISTS contactos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    mensaje TEXT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql);

// =======================
// GUARDAR DATOS
// =======================
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre   = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $mensaje  = $_POST['mensaje'];

    $stmt = $conn->prepare("INSERT INTO contactos (nombre, telefono, mensaje) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $telefono, $mensaje);

    if ($stmt->execute()) {
        echo "
        <script>
            alert('Se registró con éxito ✔');
            window.location.href = '../index.html#contacto';
        </script>";
    } else {
        echo "
        <script>
            alert('Error al registrar');
            window.history.back();
        </script>";
    }

    $stmt->close();
}

$conn->close();
?>