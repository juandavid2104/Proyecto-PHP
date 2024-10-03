<?php
session_start();

// Simulación de usuarios para validar el inicio de sesión (sin base de datos)
$usuarios_validos = [
    'admin' => 'admin',
    'usuario1' => 'abcd',
    'usuario2' => '5678'
];

// Verificar si se envió el formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['user'];
    $password = $_POST['password'];

    // Validar si el usuario y la contraseña son correctos
    if (isset($usuarios_validos[$username]) && $usuarios_validos[$username] === $password) {
        $_SESSION['username'] = $username;
        $_SESSION['usuarios_activos'][] = $username; // Agregar el usuario a la lista de usuarios activos
        header("Location: dashboard.php");
        exit;
    } else {
        $error_message = "Usuario o contraseña incorrectos";
    }
}
?>

<h2>Iniciar sesión</h2>
<form action="login.php" method="post">
    <input type="text" name="user" placeholder="Usuario" required><br>
    <input type="password" name="password" placeholder="Contraseña" required><br>
    <input type="submit" value="Iniciar sesión">
</form>

<?php
// Mostrar mensaje de error si el inicio de sesión falla
if (isset($error_message)) {
    echo "<p style='color:red;'>" . htmlspecialchars($error_message) . "</p>";
}
?>
