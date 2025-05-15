<?php
// Archivo: conexion.php

// --- Configuración de la base de datos ---
// Asegúrate de que estos datos coinciden con los usados en setup_database.php
$host = 'localhost'; // O la IP/nombre del servidor de la base de datos
$dbname = 'nombre_de_tu_bd'; // ** Reemplaza con el nombre real de tu base de datos **
$user = 'tu_usuario_bd'; // ** Reemplaza con tu usuario de base de datos **
$password = 'tu_password_bd'; // ** Reemplaza con tu contraseña de base de datos **
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Reportar errores como excepciones
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Obtener filas como arrays asociativos por defecto
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Deshabilitar emulación de prepared statements (usar prepared statements nativos de MySQL)
];

$pdo = null; // Inicializamos la variable de conexión

try {
    // Intentar establecer la conexión
    $pdo = new PDO($dsn, $user, $password, $options);
    // Si la conexión es exitosa, la variable $pdo contiene el objeto de conexión.
    // No mostramos un mensaje de éxito aquí normalmente, solo manejamos errores.

} catch (\PDOException $e) {
    // Manejar el error de conexión de la base de datos
    // En un entorno de desarrollo, puedes mostrar el error:
    die("Error de conexión a la base de datos: " . $e->getMessage());
    // En un entorno de producción, solo deberías loggear el error y mostrar un mensaje genérico al usuario.
}

// Cuando este archivo es incluido en otro script, la variable $pdo estará disponible
// y contendrá el objeto de conexión si todo fue exitoso.
?>