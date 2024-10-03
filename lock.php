<?php
session_start();

// Si el usuario solicitó bloquear la cuenta
if (isset($_POST['lock_account'])) {
    // Marcar la cuenta como bloqueada
    $_SESSION['locked'] = true;

    // Redirigir a la página de desbloqueo
    header("Location: unlock.php");
    exit;
}
?>
