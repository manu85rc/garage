<?php
//ticket lindo









// if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $barcode="888";
if ($barcode === '888') {

    // Ruta UNC de la impresora
    $printer = "\\\\192.168.100.4\\XP-58";
    // Construir el contenido del ticket usando comandos ESC/POS
    $content = "";
    $content .= "\x1B\x61\x01";       // Alinea al centro
    $content .= "hoy\n\n";      // Texto del ticket

    // $content .= "\x1D\x77\x02";        // Ancho del código de barras
    // $content .= "\x1D\x68\x30";        // Altura del código de barras
    // $content .= "\x1D\x6B\x04";        // Comando para imprimir código de barras (Code39)
    // $content .= $barcode;                // Datos del código de barras
    // $content .= "\x00";               // Terminador del comando

    $content .= "\n\n";               // Saltos de línea
    $content .= "\x1B\x61\x00";       // Vuelve a la alineación izquierda

    // Crear un archivo temporal para almacenar el contenido (modo binario)
    $file = tempnam(sys_get_temp_dir(), 'ticket_') . '.txt';
    file_put_contents($file, $content);
    
    // Enviar el archivo a la impresora usando el comando 'copy'
    // Se agregan comillas dobles para manejar rutas con espacios
    $cmd = "copy \"$file\" \"$printer\"";
    $output = shell_exec($cmd);
    
    // Eliminar el archivo temporal
    unlink($file);
    
    echo "<p>Ticket enviado a la impresora.</p>";
    echo "<pre>$output</pre>"; // Muestra la salida del comando (para depuración)
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Hola Mundo y Código de Barras</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      padding-top: 50px;
    }
    #barcode {
      margin: auto;
      display: block;
    }
  </style>
</head>
<body>
  <h1>Hola Mundo</h1>
  <!-- Elemento donde se generará el código de barras -->
  <svg id="barcode"></svg>

  <!-- Cargamos JsBarcode desde un CDN -->
  <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
  <script>
    // Generar el código de barras en el elemento SVG con el valor "666"
    JsBarcode("#barcode", "<?=$barcode?>", {
      format: "CODE39",   // Puedes cambiar el formato si lo necesitas
      width: 2,           // Ancho de cada barra
      height: 50,         // Altura del código de barras
      displayValue: true, // Muestra el valor numérico debajo
      margin: 10
    });

    // Variable para almacenar los caracteres leídos por el scanner
    let barcodeBuffer = '';
    let barcodeTimeout;

    // Escuchar eventos de teclado (los lectores de códigos suelen enviar la lectura como teclas)
    document.addEventListener('keydown', function(e) {
      // Si se presiona "Enter" asumimos que finalizó la lectura
      if (e.key === 'Enter') {
        // Si el código leído es "666", redirige a la URL indicada
        // if (barcodeBuffer.trim() === '<?=$barcode?>') {
            console.log(barcodeBuffer.trim());
        //   window.location.href = 'http://localhost/?result=<?=$barcode?>';
        // }
        barcodeBuffer = '';
        return;
      }
      
      // Acumula los caracteres leídos
      barcodeBuffer += e.key;
      
      // Reinicia el buffer si no se recibe entrada en 300ms (para lecturas rápidas de scanner)
      if (barcodeTimeout) clearTimeout(barcodeTimeout);
      barcodeTimeout = setTimeout(function() {
        barcodeBuffer = '';
      }, 300);
    });
  </script>
</body>
</html>
