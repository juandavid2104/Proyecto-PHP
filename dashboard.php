<?php
session_start();


// Archivo donde se guardarán los posts
$posts_file = 'posts.json';

// Verificar si la cuenta está bloqueada
if (isset($_SESSION['locked']) && $_SESSION['locked']) {
    header("Location: unlock.php");
    exit;
}

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Cargar los posts desde el archivo JSON si existe
if (file_exists($posts_file)) {
    $posts_data = file_get_contents($posts_file);
    $_SESSION['posts'] = json_decode($posts_data, true);
} else {
    $_SESSION['posts'] = [];
}

// Si se envía el formulario para crear un post
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_post'])) {
    $new_post = [
        'title' => htmlspecialchars($_POST['title']),
        'content' => htmlspecialchars($_POST['content']),
        'author' => $_SESSION['username'], // Asociar el post al usuario actual
        'created_at' => date("Y-m-d H:i:s") // Agregar la fecha y hora de creación
    ];

    // Guardar el nuevo post en la sesión
    $_SESSION['posts'][] = $new_post;

    // Guardar los posts en el archivo JSON
    file_put_contents($posts_file, json_encode($_SESSION['posts']));
}

// Mostrar la bienvenida al usuario
echo "<h2>Bienvenido, " . $_SESSION['username'] . "!</h2>";

// Mostrar el listado de usuarios activos
if (isset($_SESSION['usuarios_activos'])) {
    echo "<h3>Usuarios que han iniciado sesión:</h3>";
    echo "<ul>";
    foreach ($_SESSION['usuarios_activos'] as $usuario) {
        echo "<li>" . htmlspecialchars($usuario) . "</li>";
    }
    echo "</ul>";
} else {
    echo "No hay usuarios activos.";
}
?>

<h2>Crea un nuevo post</h2>
<form action="dashboard.php" method="post">
    <input type="text" name="title" placeholder="Título" required><br>
    <textarea name="content" placeholder="Escribe tu post aquí" required></textarea><br>
    <input type="submit" name="create_post" value="Crear Post">
</form>

<h2>Listado de Posts</h2>
<?php
// Mostrar todos los posts
if (!empty($_SESSION['posts'])) {
    foreach ($_SESSION['posts'] as $post) {
        echo "<h3>" . htmlspecialchars($post['title']) . "</h3>";
        echo "<p>" . htmlspecialchars($post['content']) . "</p><hr>";
    }
} else {
    echo "<p>No hay posts disponibles.</p>";
}
?>

<!-- Botón de bloquear cuenta -->
<form action="lock.php" method="post">
    <input type="submit" name="lock_account" value="Bloquear cuenta">
</form>

<!-- Botón de cerrar sesión -->
<form action="logout.php" method="post">
    <input type="submit" value="Cerrar sesión">
</form>



