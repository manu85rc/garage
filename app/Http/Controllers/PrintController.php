<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\EscposImage;
use Exception;

class PrintController extends Controller
{
    public function imprimirPdf(Request $request)
    {
        // Utiliza rutas con forward slashes para mayor compatibilidad en Windows
        $rutaPdf = 'C:/xampp/htdocs/repo/garage/laravel/public/mojo.pdf';
        // Nombre compartido de la impresora (ajústalo según tu configuración)
        $nombreImpresora = 'XP-58';

        // Ruta completa al ejecutable de Ghostscript (sin comillas por ahora)
        $gsPath = 'C:\Program Files\gs\gs9.55.0\bin\gswin64c.exe';
        // Colocar el ejecutable entre comillas
        $gsPathQuoted = '"' . $gsPath . '"';

        try {
            // Conectar a la impresora usando WindowsPrintConnector
            $connector = new WindowsPrintConnector($nombreImpresora);
            $printer = new Printer($connector);

            // Crear un archivo temporal para la imagen PNG resultante
            $tempFile = tempnam(sys_get_temp_dir(), 'escpos') . '.png';

            // Comando Ghostscript para convertir la primera página del PDF a PNG
            // -r203 establece la resolución a 203 dpi (ajusta según tus necesidades)
            // -dFirstPage=1 -dLastPage=1 procesan solo la primera página
            $gsCommand = $gsPathQuoted
                . " -q -dNOPAUSE -dBATCH -sDEVICE=png16m -r203 -dFirstPage=1 -dLastPage=1 -sOutputFile=" 
                . escapeshellarg($tempFile)
                . " " . escapeshellarg($rutaPdf);

            // Para depuración, puedes registrar el comando en un archivo:
            // file_put_contents(storage_path('logs/gs_command.log'), $gsCommand . "\n", FILE_APPEND);

            exec($gsCommand, $output, $returnVar);

            if ($returnVar !== 0) {
                throw new Exception("Error al convertir el PDF a PNG. Código de retorno: $returnVar. Salida: " . implode("\n", $output));
            }

            // Cargar la imagen convertida en formato ESC/POS
            $escposImage = EscposImage::load($tempFile);
            $printer->graphics($escposImage);
            $printer->feed();

            // Cortar el papel y cerrar la conexión
            $printer->cut();
            $printer->close();

            // Eliminar el archivo temporal
            unlink($tempFile);

            return response()->json(['message' => 'Impresión completada exitosamente.']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al imprimir: ' . $e->getMessage()], 500);
        }
    }
}
