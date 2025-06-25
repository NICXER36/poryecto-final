<?php
/**
 * Archivo de verificación de autenticación
 * Este archivo verifica si el usuario ha iniciado sesión
 * Si no hay sesión activa, redirige al usuario a la página de login
 */

// Iniciar la sesión PHP
session_start();

// Verificar si existe una sesión de usuario activa
if (!isset($_SESSION['user'])) {
    // Si no hay sesión, redirigir al login
    header("Location: index.php");
    exit;
}
?>
  