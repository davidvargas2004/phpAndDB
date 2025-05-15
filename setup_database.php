<?php
// Archivo: setup_database.php

// --- Configuración del servidor MySQL (NO de la base de datos específica todavía) ---
// Necesitas un usuario con permisos para CREAR BASES DE DATOS y CREAR TABLAS
$server_host = 'localhost'; // O la IP/nombre del servidor MySQL
$server_user = 'root';      // Usuario con permisos de creación (puede ser el mismo que usas normalmente)
$server_password = '';  // Contraseña para el usuario del servidor (¡Cuidado con dejarla vacía si tienes contraseña!)

// --- Nombre de la Base de Datos y Tabla a crear ---
$dbname = 'nombre_de_tu_bd'; // ** Reemplaza con el nombre que quieres para tu BD **
$tablename = 'empleado';

// --- Sentencia SQL para CREAR LA BASE DE DATOS (si no existe) ---
$sql_create_db = "CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;";
// Usamos comillas invertidas (`) alrededor del nombre de la BD por si tuviera caracteres especiales, aunque no es estrictamente necesario si es simple.

// --- Sentencia SQL para CREAR LA TABLA EMPLEADO (si no existe) ---
// Esta es la estructura corregida con los campos adicionales
$sql_create_table = "CREATE TABLE IF NOT EXISTS `$tablename` (
    documento VARCHAR(20) PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    sexo CHAR(1) NOT NULL,
    domicilio VARCHAR(255),
    fechaingreso DATE,
    fechanacimiento DATE,
    sueldobasico DECIMAL(10, 2),
    estado_civil VARCHAR(50),
    tipo_sangre VARCHAR(5),
    usuario_red_social VARCHAR(100) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
// ENGINE=InnoDB es el motor recomendado para MySQL/MariaDB por soporte a transacciones.
// DEFAULT CHARSET y COLLATE son importantes para manejar correctamente caracteres especiales.

// --- Proceso de Creación ---
try {
    // 1. Conectar al servidor MySQL (SIN especificar la base de datos inicialmente)
    // Usamos PDO
    $pdo_server = new PDO("mysql:host=$server_host", $server_user, $server_password);
    // Configurar PDO para reportar errores como excepciones
    $pdo_server->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conexión al servidor MySQL exitosa.<br>";

    // 2. Ejecutar la sentencia para crear la base de datos
    $pdo_server->exec($sql_create_db);
    echo "Base de datos `$dbname` verificada/creada exitosamente.<br>";

    // Cerrar la conexión al servidor (ya no la necesitamos)
    $pdo_server = null;

    // 3. Ahora conectar a la base de datos específica que acabamos de crear/verificar
    $pdo_db = new PDO("mysql:host=$server_host;dbname=$dbname;charset=utf8mb4", $server_user, $server_password);
    // Configurar PDO para reportar errores como excepciones y modo fetch por defecto
    $pdo_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo_db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);


    echo "Conexión a la base de datos `$dbname` exitosa.<br>";

    // 4. Ejecutar la sentencia para crear la tabla dentro de esa base de datos
    $pdo_db->exec($sql_create_table);
    echo "Tabla `$tablename` verificada/creada exitosamente dentro de `$dbname`.<br>";

    echo "<br><strong>¡Configuración de base de datos completada!</strong>";

} catch (\PDOException $e) {
    // Capturar y mostrar errores
    die("Error durante la configuración de la base de datos: " . $e->getMessage());
    // En un entorno de producción, deberías loggear el error
}

// Cerrar la conexión a la base de datos al finalizar
$pdo_db = null;

?>