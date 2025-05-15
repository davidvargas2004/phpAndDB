<?php
// Archivo: reportes_empleados.php (modificado)

// 1. Incluir el archivo de conexión a la base de datos
require_once 'conexion.php';

// ** IMPORTANTE: Define el valor del salario mínimo aquí **
$salario_minimo = 1000.00; // <-- VALOR A REEMPLAZAR


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes de Empleados</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        /* Estilos básicos opcionales */
        body { margin: 20px; }
         /* Los estilos de tabla ahora se manejarían principalmente con clases de Bootstrap */
    </style>
</head>
<body>

    <div class="container"> <h1 class="my-4">Reportes de Empleados</h1> <?php
        // --- Consulta 1: Cumpleaños en Mayo (Rosas y Corbatas) ---
        echo "<h2 class='mt-4'>1. Cumpleaños en Mayo</h2>"; // Clases de Bootstrap para margen
        echo "<p>Cantidad de regalos a comprar para el mes de Mayo:</p>";

        $sql1 = "SELECT
                    sexo,
                    COUNT(*) AS total_cumpleaneros_mayo
                FROM
                    empleado
                WHERE
                    MONTH(fechanacimiento) = 5
                GROUP BY
                    sexo;";

        try {
            $stmt1 = $pdo->query($sql1);
            $rosas = 0;
            $corbatas = 0;
            $found_may_birthdays = false;

            // ... (El resto de la lógica de la consulta 1 es la misma) ...
             while ($row1 = $stmt1->fetch()) {
                 $found_may_birthdays = true;
                 if ($row1['sexo'] === 'f') {
                     $rosas = $row1['total_cumpleaneros_mayo'];
                 } elseif ($row1['sexo'] === 'm') {
                     $corbatas = $row1['total_cumpleaneros_mayo'];
                 }
             }

             if ($found_may_birthdays) {
                 echo "<ul>"; // Puedes añadir clases de lista de Bootstrap aquí si quieres
                 echo "<li>Ramos de rosas (Sexo Femenino): " . $rosas . "</li>";
                 echo "<li>Corbatas (Sexo Masculino): " . $corbatas . "</li>";
                 echo "</ul>";
             } else {
                 echo "<p>No hay empleados con cumpleaños en Mayo.</p>";
             }


        } catch (\PDOException $e) {
            echo "<div class='alert alert-danger' role='alert'>Error al ejecutar la consulta de cumpleaños: " . htmlspecialchars($e->getMessage()) . "</div>"; // Clases de alerta de Bootstrap
        }

        echo "<hr>"; // Separador visual

        // --- Consulta 2: Cantidad de empleados agrupados por sexo ---
        echo "<h2 class='mt-4'>2. Cantidad de Empleados por Sexo</h2>";

        // ... (La lógica de la consulta 2 es la misma) ...
        $sql2 = "SELECT sexo, COUNT(*) AS total_empleados FROM empleado GROUP BY sexo;";
         try {
             $stmt2 = $pdo->query($sql2);

             echo "<ul>"; // Puedes añadir clases de lista de Bootstrap aquí si quieres
             if ($stmt2->rowCount() > 0) {
                 while ($row2 = $stmt2->fetch()) {
                     $sexo_display = ($row2['sexo'] === 'f') ? 'Femenino' : 'Masculino';
                     echo "<li>Sexo " . $sexo_display . ": " . $row2['total_empleados'] . "</li>";
                 }
             } else {
                  echo "<li>No se encontraron datos de empleados.</li>";
             }
             echo "</ul>";

         } catch (\PDOException $e) {
             echo "<div class='alert alert-danger' role='alert'>Error al ejecutar la consulta por sexo: " . htmlspecialchars($e->getMessage()) . "</div>";
         }


        echo "<hr>";

        // --- Consulta 3: Sueldos con aumento del 10%, ordenado por nombre ASC ---
        echo "<h2 class='mt-4'>3. Sueldos con Aumento del 10%</h2>";

        // ... (La lógica de la consulta 3 es la misma) ...
        $sql3 = "SELECT nombre, sueldobasico * 1.10 AS sueldo_con_aumento FROM empleado ORDER BY nombre ASC;";
         try {
             $stmt3 = $pdo->query($sql3);

             // Aplicar clases de tabla de Bootstrap: table, table-striped, table-bordered, etc.
             echo "<table class='table table-striped table-bordered'>";
             echo "<thead class='table-dark'><tr><th>Nombre</th><th>Sueldo con Aumento</th></tr></thead>";
             echo "<tbody>";

             if ($stmt3->rowCount() > 0) {
                 while ($row3 = $stmt3->fetch()) {
                     echo "<tr>";
                     echo "<td>" . htmlspecialchars($row3['nombre']) . "</td>";
                     echo "<td>" . number_format($row3['sueldo_con_aumento'], 2) . "</td>";
                     echo "</tr>";
                 }
             } else {
                 echo "<tr><td colspan='2'>No se encontraron empleados.</td></tr>";
             }

             echo "</tbody>";
             echo "</table>";

         } catch (\PDOException $e) {
             echo "<div class='alert alert-danger' role='alert'>Error al ejecutar la consulta de sueldos: " . htmlspecialchars($e->getMessage()) . "</div>";
         }


        echo "<hr>";

        // --- Consulta 4: Total de la nómina agrupada por sexo ---
        echo "<h2 class='mt-4'>4. Total de Nómina por Sexo</h2>";

        // ... (La lógica de la consulta 4 es la misma) ...
        $sql4 = "SELECT sexo, SUM(sueldobasico) AS total_nomina_por_sexo FROM empleado GROUP BY sexo;";
         try {
             $stmt4 = $pdo->query($sql4);

             echo "<ul>"; // Puedes añadir clases de lista de Bootstrap aquí si quieres
              if ($stmt4->rowCount() > 0) {
                  while ($row4 = $stmt4->fetch()) {
                     $sexo_display = ($row4['sexo'] === 'f') ? 'Femenino' : 'Masculino';
                     echo "<li>Sexo " . $sexo_display . ": " . number_format($row4['total_nomina_por_sexo'], 2) . "</li>";
                 }
             } else {
                  echo "<li>No se encontraron datos de nómina.</li>";
             }
             echo "</ul>";

         } catch (\PDOException $e) {
             echo "<div class='alert alert-danger' role='alert'>Error al ejecutar la consulta de nómina: " . htmlspecialchars($e->getMessage()) . "</div>";
         }


        echo "<hr>";

        // --- Consulta 5: Total de empleados que ganan más del salario mínimo ---
        echo "<h2 class='mt-4'>5. Total de Empleados que Ganan Más del Salario Mínimo</h2>";
        echo "<p class='mb-3'>*(Salario Mínimo considerado: $" . number_format($salario_minimo, 2) . ")*</p>"; // Muestra el valor usado, clase de margen

        // ... (La lógica de la consulta 5 es la misma) ...
        $sql5 = "SELECT COUNT(*) AS total_empleados_sobre_minimo FROM empleado WHERE sueldobasico > :salario_minimo";
         try {
             $stmt5 = $pdo->prepare($sql5);
             $stmt5->bindParam(':salario_minimo', $salario_minimo, PDO::PARAM_STR);
             $stmt5->execute();
             $resultado5 = $stmt5->fetch();

             if ($resultado5) {
                 echo "<p>Cantidad: <strong>" . $resultado5['total_empleados_sobre_minimo'] . "</strong></p>"; // Usar strong para resaltar
             } else {
                 echo "<p>No se pudo obtener el conteo.</p>";
             }

         } catch (\PDOException $e) {
             echo "<div class='alert alert-danger' role='alert'>Error al ejecutar la consulta de salario mínimo: " . htmlspecialchars($e->getMessage()) . "</div>";
         }

        ?>

    </div> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>