<?php
// Ruta al archivo PDF
$rutaPdf = 'C:\\xampp\\htdocs\\repo\\garage\\laravel\\public\\mojo.pdf';

// Nombre compartido de la impresora
$printer = "\\\\192.168.100.4\\XP-58";

// Construir el comando para copiar el PDF a la impresora
$cmd = "copy \"$rutaPdf\" \"$printer\"";

// Ejecutar el comando
$output = shell_exec($cmd);

// Mostrar la salida para depuración
echo "Resultado del comando: " . htmlspecialchars($output);

?>
