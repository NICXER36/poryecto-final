<?php
/**
 * Archivo principal del portafolio
 * Este archivo muestra la página principal que contiene los proyectos
 * organizados por categorías: evaluaciones, talleres y tareas autónomas
 */

// Incluir archivos necesarios
include 'auth.php';  // Verificación de autenticación
include 'db.php';    // Conexión a la base de datos

// Inicializar arrays para almacenar proyectos por categoría
$evaluaciones = [];
$talleres = [];
$autonomas = [];

// Consultar todos los proyectos ordenados por fecha de creación
$result = $conn->query("SELECT * FROM proyectos ORDER BY created_at DESC");

// Clasificar los proyectos en sus respectivas categorías
while($row = $result->fetch_assoc()) {
    if ($row['categoria'] === 'evaluacion') {
        $evaluaciones[] = $row;
    } elseif ($row['categoria'] === 'taller') {
        $talleres[] = $row;
    } elseif ($row['categoria'] === 'autonoma') {
        $autonomas[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio • Nicolas Huenchullan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #181c22;
            --secondary-color: #00adb5;
            --accent-color: #ff2e63;
            --text-color: #eeeeee;
            --light-bg: #23272f;
            --white: #23272f;
            --shadow: 0 8px 32px rgba(0,0,0,0.22);
            --transition: all 0.3s cubic-bezier(.25,.8,.25,1);
            --gradient: linear-gradient(135deg, #00adb5 0%, #222831 100%);
            --gradient-accent: linear-gradient(120deg, #ff2e63 0%, #00adb5 100%);
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(120deg, #23272f 0%, #181c22 100%);
            color: var(--text-color);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        body::before {
            content: '';
            position: fixed;
            top: -120px;
            left: -120px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, #00adb5 0%, transparent 70%);
            opacity: 0.18;
            z-index: 0;
        }
        body::after {
            content: '';
            position: fixed;
            bottom: -120px;
            right: -120px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, #ff2e63 0%, transparent 70%);
            opacity: 0.13;
            z-index: 0;
        }
        .main-header {
            background: var(--gradient);
            box-shadow: var(--shadow);
            border-bottom: 1px solid var(--secondary-color);
            padding: 1.5rem 2.5rem !important;
            min-height: 70px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }
        .main-header h1 {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-color);
            letter-spacing: 2px;
            margin: 0;
            text-shadow: 0 2px 8px rgba(0,173,181,0.08);
        }
        .main-header nav {
            display: flex;
            gap: 1.2rem;
        }
        .add-btn, .delete-btn {
            padding: 0.7rem 1.5rem;
            font-size: 1.1rem;
            border-radius: 8px;
            background: transparent;
            border: 2px solid var(--secondary-color);
            color: var(--secondary-color);
            font-weight: 700;
            transition: var(--transition);
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(0,173,181,0.08);
        }
        .add-btn:hover, .delete-btn:hover {
            background: var(--secondary-color);
            color: var(--primary-color);
            border-color: var(--secondary-color);
        }
        .main-content {
            max-width: 100vw;
            padding: 2.5rem 1rem 1.5rem 1rem;
            margin-top: 120px;
            position: relative;
            z-index: 1;
        }
        section {
            margin-bottom: 3.2rem;
            background: var(--light-bg);
            border-radius: 22px;
            box-shadow: var(--shadow);
            padding: 2.5rem 2rem 2.5rem 2rem;
            max-width: 950px;
            margin-left: auto;
            margin-right: auto;
            border: 1.5px solid #23272f;
            position: relative;
        }
        section h2 {
            color: var(--secondary-color);
            margin-bottom: 1.7rem;
            font-size: 1.6rem;
            text-align: left;
            letter-spacing: 1px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 0.7rem;
        }
        .section-badge {
            display: inline-block;
            background: var(--gradient-accent);
            color: #fff;
            font-size: 0.95rem;
            font-weight: 700;
            border-radius: 12px;
            padding: 0.2rem 1.1rem;
            margin-left: 0.7rem;
            letter-spacing: 1px;
            box-shadow: 0 2px 8px rgba(255,46,99,0.08);
        }
        hr.section-divider {
            border: none;
            border-top: 2px solid #393e46;
            margin: 2.5rem 0 2.5rem 0;
            opacity: 0.18;
        }
        .carousel {
            max-width: 700px;
            margin: 0 auto 2.5rem auto;
        }
        .carousel .card {
            min-height: 260px;
            max-height: 370px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            background: #23272f;
            border-radius: 22px;
            box-shadow: var(--shadow);
            padding: 1.7rem 1.3rem 1.3rem 1.3rem;
            border: 1.5px solid #23272f;
            transition: var(--transition);
        }
        .carousel .card:hover {
            box-shadow: 0 12px 40px rgba(0,173,181,0.16);
            border-color: var(--secondary-color);
        }
        .carousel .project-image {
            max-height: 150px;
            min-height: 100px;
            object-fit: cover;
            border-radius: 14px;
            margin-bottom: 1.1rem;
            background: #181c22;
            box-shadow: 0 2px 12px rgba(0,173,181,0.10);
        }
        .card-body {
            width: 100%;
            padding: 0;
            text-align: center;
        }
        .card-title {
            font-size: 1.22rem;
            font-weight: 800;
            color: var(--secondary-color);
            margin-bottom: 0.6rem;
        }
        .card-text {
            font-size: 1.08rem;
            color: #b0bec5;
            margin-bottom: 0.9rem;
        }
        .carousel .btn {
            margin: 0 0.18rem 0.4rem 0.18rem;
            font-size: 1.05rem;
            border-radius: 8px;
            font-weight: 700;
            padding: 0.5rem 1.2rem;
        }
        .carousel .btn-outline-info {
            border-color: #00adb5;
            color: #00adb5;
            background: transparent;
        }
        .carousel .btn-outline-info:hover {
            background: #00adb5;
            color: #23272f;
        }
        .carousel .btn-outline-success {
            border-color: #21e6c1;
            color: #21e6c1;
            background: transparent;
        }
        .carousel .btn-outline-success:hover {
            background: #21e6c1;
            color: #23272f;
        }
        .carousel .btn-warning {
            color: #222831;
            background: #ffd600;
            border: none;
        }
        .carousel .btn-danger {
            background: #ff2e63;
            border: none;
        }
        .form-group {
            margin-bottom: 1.4rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--secondary-color);
            font-weight: 600;
            font-size: 1.08rem;
        }
        input[type=text], input[type=password], input[type=url], textarea {
            width: 100%;
            padding: 1.1rem;
            border: 2px solid #23272f;
            background: #181c22;
            color: var(--text-color);
            border-radius: 8px;
            font-size: 1.05rem;
            transition: var(--transition);
            outline: none;
        }
        input[type=text]:focus, input[type=password]:focus, input[type=url]:focus, textarea:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 2px rgba(0,173,181,0.18);
        }
        .submit-btn, .cancel-btn {
            background: var(--secondary-color);
            color: var(--primary-color);
            padding: 1rem 2.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.08rem;
            font-weight: 700;
            margin-right: 0.9rem;
            margin-top: 0.7rem;
            transition: var(--transition);
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 2px 8px rgba(0,173,181,0.08);
        }
        .submit-btn:hover, .cancel-btn:hover {
            background: #00cfcf;
            color: #181c22;
            box-shadow: 0 2px 12px rgba(0,173,181,0.18);
        }
        .error-message {
            background: #ff2e63;
            color: #fff;
            border-radius: 8px;
            padding: 1rem 1.2rem;
            margin-bottom: 1.4rem;
            text-align: center;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(255,46,99,0.10);
        }
        @media screen and (max-width: 1100px) {
            .main-content {
                padding: 1.2rem 0.5rem;
                margin-top: 100px;
            }
            section {
                padding: 1.2rem 0.5rem 1.5rem 0.5rem;
                max-width: 98vw;
            }
            .carousel {
                max-width: 98vw;
            }
        }
        @media screen and (max-width: 700px) {
            .main-content {
                margin-top: 80px;
            }
            section {
                padding: 0.7rem 0.2rem 1rem 0.2rem;
                max-width: 100vw;
            }
            .carousel {
                max-width: 100vw;
            }
            .carousel .card {
                padding: 0.7rem 0.2rem 0.7rem 0.2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Encabezado con navegación -->
    <header class="main-header" style="padding: 1rem; background: var(--gradient); display: flex; justify-content: space-between; align-items: center;">
        <h1 style="color: var(--text-color); margin: 0;">Portafolio</h1>
        <nav>
            <a href="add.php" class="add-btn">+ Agregar Proyecto</a>
            <a href="logout.php" class="delete-btn">Cerrar sesión</a>
        </nav>
    </header>

    <!-- Contenido principal -->
    <main class="main-content">
        <!-- Sección de Evaluaciones -->
        <section>
            <h2>Evaluaciones</h2>
            <?php include 'carrusel.php'; mostrar_carrusel($evaluaciones, 'evaluaciones'); ?>
        </section>
        <!-- Sección de Talleres -->
        <section>
            <h2>Talleres</h2>
            <?php mostrar_carrusel($talleres, 'talleres'); ?>
        </section>
        <!-- Sección de Tareas Autónomas -->
        <section>
            <h2>Tareas Autónomas</h2>
            <?php mostrar_carrusel($autonomas, 'autonomas'); ?>
        </section>
    </main>

    <!-- Scripts necesarios -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>