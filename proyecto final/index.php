<?php
session_start();
include 'db.php';

$evaluaciones = [];
$talleres = [];
$autonomas = [];
$result = $conn->query("SELECT * FROM proyectos ORDER BY created_at DESC");
while($row = $result->fetch_assoc()) {
    if ($row['categoria'] === 'evaluacion') {
        $evaluaciones[] = $row;
    } elseif ($row['categoria'] === 'taller') {
        $talleres[] = $row;
    } elseif ($row['categoria'] === 'autonoma') {
        $autonomas[] = $row;
    }
}

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y sanitizar las credenciales
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Encriptar la contraseña con MD5

    // Consultar la base de datos para verificar las credenciales
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    // Si se encuentra un usuario, iniciar sesión y redirigir
    if ($result->num_rows === 1) {
        $_SESSION['user'] = $username;
        header("Location: upload.php");
    } else {
        $error = "Credenciales incorrectas";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Iniciar Sesión</title>
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
        .login-header {
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
        .login-header h1 {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-color);
            letter-spacing: 2px;
            margin: 0;
            text-shadow: 0 2px 8px rgba(0,173,181,0.08);
        }
        .login-btn {
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
        .login-btn:hover {
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
        .landing-hero {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            margin-top: 0;
            margin-bottom: 2.5rem;
            position: relative;
            z-index: 1;
        }
        .landing-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 6px solid var(--secondary-color);
            background: #23272f;
            box-shadow: 0 6px 32px rgba(0,173,181,0.18);
            margin-bottom: 1.2rem;
        }
        .landing-welcome {
            background: var(--white);
            color: var(--secondary-color);
            border-radius: 20px;
            padding: 2.2rem 2rem 1.5rem 2rem;
            max-width: 480px;
            text-align: center;
            box-shadow: var(--shadow);
            border: 1.5px solid #23272f;
            margin-bottom: 2.2rem;
            position: relative;
        }
        .landing-welcome h2 {
            color: var(--secondary-color);
            font-size: 1.7rem;
            margin-bottom: 0.7rem;
            font-weight: 800;
        }
        .landing-welcome p {
            color: #b0bec5;
            font-size: 1.13rem;
            margin-bottom: 0.5rem;
        }
        .landing-divider {
            width: 80px;
            height: 4px;
            background: var(--gradient-accent);
            border-radius: 2px;
            margin: 1.2rem auto 0.7rem auto;
            opacity: 0.7;
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
            .landing-avatar {
                width: 90px;
                height: 90px;
            }
            .landing-welcome {
                padding: 1rem 0.5rem;
                max-width: 98vw;
            }
        }
    </style>
</head>
<body>
    <!-- Header con botón de login -->
    <header class="login-header">
        <h1>Portafolio</h1>
        <form method="post" style="margin:0;">
            <button type="submit" class="login-btn">Iniciar Sesión</button>
        </form>
    </header>
    <div class="main-content">
        <div class="landing-hero">
            <!-- Imagen circular (avatar) -->
            <img src="assets/img/sushi.jpg" alt="Avatar" class="landing-avatar">
            <!-- Recuadro de bienvenida -->
            <div class="landing-welcome">
                <h2>¡Bienvenido!</h2>
                <p>Explora mi portafolio de proyectos.<br>Inicia sesión para agregar, editar o eliminar tus trabajos.</p>
                <div class="landing-divider"></div>
            </div>
        </div>
        <!-- Mostrar mensaje de error si existe -->
        <?php if(isset($error)): ?>
            <div class="error-message" style="max-width:400px;margin:0 auto 1.5rem auto;"><?= $error ?></div>
        <?php endif; ?>
        <!-- Formulario de inicio de sesión (oculto, solo se muestra al hacer click en el botón) -->
        <div id="login-form-container" style="display:none;max-width:400px;margin:0 auto 2rem auto;">
            <form method="post">
                <div class="form-group">
                    <label for="username">Usuario</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="submit-btn">Entrar</button>
            </form>
        </div>
        <!-- Carruseles de proyectos -->
        <section>
            <h2>Evaluaciones <span class="section-badge">Evaluaciones</span></h2>
            <?php include 'carrusel.php'; mostrar_carrusel($evaluaciones, 'evaluaciones', true); ?>
        </section>
        <hr class="section-divider">
        <section>
            <h2>Talleres <span class="section-badge">Talleres</span></h2>
            <?php mostrar_carrusel($talleres, 'talleres', true); ?>
        </section>
        <hr class="section-divider">
        <section>
            <h2>Tareas Autónomas <span class="section-badge">Autónomas</span></h2>
            <?php mostrar_carrusel($autonomas, 'autonomas', true); ?>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mostrar el formulario de login al hacer click en el botón
        document.querySelector('.login-btn').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('login-form-container').style.display = 'block';
            this.style.display = 'none';
        });
    </script>
</body>
</html>