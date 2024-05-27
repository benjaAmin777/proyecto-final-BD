<?php
session_start();
$servername = "localhost";
$username = "root"; // Cambia esto por tu usuario de la base de datos
$password = ""; // Cambia esto por tu contraseña de la base de datos
$dbname = "final_proyecto";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = sha1($_POST['password']); // Encriptar la contraseña ingresada con SHA1

    $sql = "SELECT * FROM usuarios WHERE usNombre = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ss", $user, $pass);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Usuario y contraseña correctos
            $_SESSION['username'] = $user;
            echo "¡Login exitoso!";
            // Redireccionar a la página de bienvenida o dashboard
            // header("Location: welcome.php");
        } else {
            // Usuario o contraseña incorrectos
            echo "Usuario o contraseña incorrectos.";
        }

        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta.";
    }
}

$conn->close();
?>
