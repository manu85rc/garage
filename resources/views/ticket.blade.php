<?php
// Inicializa la impresora con comandos ESC/POS
$ticket  = "\x1B\x40"; // Reinicia la impresora
$ticket .= "\x1B\x61\x01"; // Alinea al centro

// Encabezado en negrita y doble tamaño
$ticket .= "\x1B\x21\x30"; // Establece modo de doble ancho y doble alto
$ticket .= "GARAGE PARAGUAY\n";
$ticket .= "\x1B\x21\x00"; // Vuelve al estilo normal

$ticket .= "------------------------------\n";

// Fecha y hora de ingreso
$fecha = now()->timezone('America/Argentina/Buenos_Aires')->format("d/m/Y");
$hora = now()->timezone('America/Argentina/Buenos_Aires')->format("H:i");
$ticket .= "Fecha:\n";
$ticket .= "$fecha\n";
$ticket .= "\x1B\x21\x00"; // Vuelve al estilo normal
$ticket .= "Hora:\n";
$ticket .= "\x1B\x21\x20"; // Establece modo de doble ancho y doble alto
$ticket .= "$hora\n";
$ticket .= "\x1B\x21\x00"; // Vuelve al estilo normal
// Datos del vehículo y cliente
$ticket .= "Patente:\n";

$ticket .= "\x1B\x21\x30"; // Establece modo de doble ancho y doble alto
$ticket .= "AA666BB\n";
$ticket .= "\x1B\x21\x40"; // Establece modo de doble ancho y doble alto


$ticket .= "\x1B\x21\x00"; // Vuelve al estilo normal
// $ticket .= "Cliente: JUAN PEREZ\n";




// $ticket .= "------------------------------\n";

// Impresión del código de barras (Code39)
// Es importante envolver el dato con asteriscos (*) para el formato Code39
$ticket .= "\x1B\x61\x01";       // Centra el código de barras
$barcodeData = "*FI121DF*";
$ticket .= "\x1D\x68\x50";       // Define la altura del código de barras (80 puntos)
$ticket .= "\x1D\x77\x03";       // Define el ancho del código de barras
$ticket .= "\x1D\x6B\x04" . $barcodeData . "\x00"; // Imprime el código de barras


// $ticket .= "\x1B\x61\x00"; // Vuelve a alinear a la izquierda
$ticket .= "Direccion: Paraguay 960\n\n\n";
$ticket .= "\n\n";

// En este ejemplo, se guarda el ticket en un archivo temporal y se envía a la impresora.
// Ajusta la ruta UNC de la impresora según tu entorno (este ejemplo es para Windows)
$file = tempnam(sys_get_temp_dir(), 'ticket_') . '.txt';
file_put_contents($file, $ticket);

$printer = "\\\\192.168.100.4\\XP-58";
$cmd = "copy \"$file\" \"$printer\"";
$output = shell_exec($cmd);
unlink($file);

// Muestra el contenido del ticket en pantalla para depuración (opcional)
echo "<pre>" . htmlspecialchars($ticket) . "</pre>";
?>
