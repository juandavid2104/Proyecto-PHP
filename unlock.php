<?php
session_start();
// Verifica si la cuenta está bloqueada
if (!isset($_SESSION['locked']) || !$_SESSION['locked']) {
    // Si la cuenta no está bloqueada, redirigir al dashboard
    header("Location: dashboard.php");
    exit;
}
$usuarios_validos = [
    ['username' => 'admin', 'password' => 'admin'],
    ['username' => 'user2', 'password' => 'password2']
];

// Verifica si se envió el formulario de desbloqueo
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_SESSION['username']; // El usuario ya está en la sesión
    $password = $_POST['password'];

    // Busca el usuario en la lista de usuarios válidos
    foreach ($usuarios_validos as $usuario) {
        if ($usuario['username'] == $username && $usuario['password'] == $password) {
            // Si la contraseña es correcta, desbloquear la cuenta
            $_SESSION['locked'] = false;

            // Redirigir al dashboard
            header("Location: dashboard.php");
            exit;
        }
    }

    // Si la contraseña es incorrecta, mostrar un mensaje de error
    $error = "Contraseña incorrecta. Inténtalo de nuevo.";
}
?>

<h2>Desbloquear cuenta</h2>
<?php
if (isset($error)) {
    echo "<p style='color: red;'>$error</p>";
}
?>
<form action="unlock.php" method="post">
    <input type="password" name="password" placeholder="Contraseña" required><br>
    <input type="submit" value="Desbloquear">
</form>
