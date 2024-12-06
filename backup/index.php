<?php

// Conexión a la base de datos MySQL
$connection = mysqli_connect('localhost', 'root', '', 'bd_ventas'); // Conecta al servidor localhost con usuario 'root', sin contraseña y selecciona la base de datos 'bd_ventas'.

// Array para almacenar los nombres de las tablas
$tables = array(); 

// Obtener todas las tablas de la base de datos
$result = mysqli_query($connection, "SHOW TABLES"); // Ejecuta la consulta para mostrar todas las tablas.
while ($row = mysqli_fetch_row($result)) { 
    $tables[] = $row[0]; // Agrega el nombre de cada tabla al array $tables.
}

// Variable que contendrá el contenido del backup
$return = ''; 

// Procesar cada tabla individualmente
foreach ($tables as $table) {
    // Obtener todos los datos de la tabla
    $result = mysqli_query($connection, "SELECT * FROM " . $table); 
    $num_fields = mysqli_num_fields($result); // Obtiene el número de columnas de la tabla.

    // Agregar instrucción para eliminar la tabla antes de recrearla
    $return .= 'DROP TABLE ' . $table . ';'; 

    // Obtener la instrucción SQL para crear la tabla
    $row2 = mysqli_fetch_row(mysqli_query($connection, "SHOW CREATE TABLE " . $table)); 
    $return .= "\n\n" . $row2[1] . ";\n\n"; // Agrega la instrucción `CREATE TABLE` al backup.

    // Recorrer todas las filas de la tabla
    for ($i = 0; $i < $num_fields; $i++) {
        while ($row = mysqli_fetch_row($result)) { // Obtiene cada fila de datos.
            $return .= "INSERT INTO " . $table . " VALUES("; // Comienza la instrucción `INSERT INTO`.

            // Recorrer todos los campos de la fila actual
            for ($j = 0; $j < $num_fields; $j++) {
                $row[$j] = addslashes($row[$j]); // Escapa caracteres especiales para evitar errores de sintaxis.
                if (isset($row[$j])) { 
                    $return .= '"' . $row[$j] . '"'; // Agrega el valor del campo entre comillas.
                } else { 
                    $return .= '""'; // Si el valor es NULL, agrega una cadena vacía.
                }
                if ($j < $num_fields - 1) { 
                    $return .= ','; // Agrega una coma entre los valores, excepto después del último.
                }
            }
            $return .= ");\n"; // Cierra la instrucción `INSERT INTO`.
        }
    }
    $return .= "\n\n\n"; // Agrega separadores entre las tablas.
}

// Crear un archivo para guardar el backup
$handle = fopen("backup.sql", "w+"); // Abre (o crea) el archivo `backup.sql` en modo escritura.
fwrite($handle, $return); // Escribe el contenido del backup en el archivo.
fclose($handle); // Cierra el archivo.

// Mensaje de confirmación
echo "Copia de seguridad realizada con éxito."; // Indica al usuario que el backup se completó.

?>
