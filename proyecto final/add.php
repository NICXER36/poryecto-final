<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
 * Archivo para agregar nuevos proyectos
 * Este archivo maneja el formulario y la lógica para agregar
 * nuevos proyectos al portafolio, incluyendo la subida de imágenes
 */

// Incluir archivos necesarios
include 'auth.php';  // Verificación de autenticación
include 'db.php';    // Conexión a la base de datos

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "POST recibido<br>";

    // Obtener y sanitizar los datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $url_github = $_POST['url_github'];
    $url_produccion = $_POST['url_produccion'];
    $categoria = $_POST['categoria'];

    echo "Datos recibidos: $nombre, $descripcion, $url_github, $url_produccion, $categoria<br>";

    // Procesar la imagen subida
    $imagen = '';
    if (isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])) {
        $imagen = $_FILES['imagen']['name'];
        $tmp = $_FILES['imagen']['tmp_name'];
        if (!move_uploaded_file($tmp, "uploads/$imagen")) {
            die("Error al subir la imagen.");
        }
    }
    echo "Imagen subida<br>";

    // Insertar el nuevo proyecto en la base de datos
    $sql = "INSERT INTO proyectos (nombre, descripcion, url_github, url_produccion, imagen, categoria) 
            VALUES ('$nombre', '$descripcion', '$url_github', '$url_produccion', '$imagen', '$categoria')";

    if (!$conn->query($sql)) {
        die("Error al insertar el proyecto: " . $conn->error);
    }
    echo "Proyecto insertado<br>";

    header("Location: upload.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agregar Proyecto</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <!-- Contenedor principal del formulario -->
    <div class="main-content">
        <h2>Agregar Nuevo Proyecto</h2>
        <!-- Formulario para agregar proyecto -->
        <form method="post" enctype="multipart/form-data">
            <!-- Campo de título -->
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <!-- Campo de descripción -->
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" required></textarea>
            </div>
            <!-- Selector de categoría -->
            <div class="form-group">
                <label for="categoria">Categoría</label>
                <select id="categoria" name="categoria" required>
                    <option value="evaluacion">Evaluación</option>
                    <option value="taller">Taller</option>
                    <option value="autonoma">Tarea Autónoma</option>
                </select>
            </div>
            <!-- Campo para URL de GitHub -->
            <div class="form-group">
                <label for="url_github">URL GitHub</label>
                <input type="url" id="url_github" name="url_github">
            </div>
            <!-- Campo para URL de producción -->
            <div class="form-group">
                <label for="url_produccion">URL Producción</label>
                <input type="url" id="url_produccion" name="url_produccion">
            </div>
            <!-- Campo para subir imagen -->
            <div class="form-group">
                <label for="imagen">Imagen</label>
                <input type="file" id="imagen" name="imagen">
            </div>
            <!-- Botones de acción -->
            <button type="submit" class="submit-btn">Guardar Proyecto</button>
            <a href="upload.php" class="cancel-btn">Cancelar</a>
        </form>
    </div>
</body>
</html>