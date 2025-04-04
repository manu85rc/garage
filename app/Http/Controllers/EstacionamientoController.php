<?php

namespace App\Http\Controllers;

use App\Models\Estacionamiento;
use App\Models\Caja;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EstacionamientoController extends Controller
{
    /**
     * Mostrar listado de patentes registradas
     */
    public function index()
    {
        $estacionamientos = Estacionamiento::orderBy('total', 'asc')->orderBy('ingreso', 'desc')->get();

        $subtotal = number_format(Caja::orderBy('created_at', 'desc')->value('total') + $estacionamientos->sum('total'), 0);

        $total = '$' . $subtotal ?? 'nulo';
        return view('estacionamiento.index', compact('estacionamientos', 'total'));
    }

    /**
     * Registrar ingreso de vehículo
     */
    public function store(Request $request)
    {
        $request->validate([
            'patente' => 'required|string|min:3|max:10|regex:/^[A-Z0-9]+$/'
        ]);

        $patente = strtoupper($request->patente);

  

        // if (substr($patente, 0, 1) === '#') {
            if (preg_match('/^000\d+$/', $patente)) {
            $patente = substr($patente, 3);
            // $patente=23;
        //    echo  $patente;
        //    exit;
        return redirect()->route('estacionamiento.facturar', ['id' => $patente]);
            // exit;
        }





        
        // Verificar si ya existe un registro pendiente con esta patente
        $pendiente = Estacionamiento::where('patente', $patente)
                                    ->whereNull('salida')
                                    ->first();
        
        if ($pendiente) {
            return redirect()->route('estacionamiento.facturar', $pendiente->id)
                            ->with('warning', 'Este vehículo ya está en el estacionamiento. Debe facturarlo.');
        }
        
        // Crear nuevo registro
       $save = Estacionamiento::create([
            'patente' => $patente,
            'ingreso' => now(),
            'servicio' => 'xHora'
        ]);
        $this->printTicket($patente,$save->id);
        
        return redirect()->route('estacionamiento.index')
                        ->with('success', 'Vehículo registrado correctamente.');
    }

    /**
     * Mostrar formulario para editar servicios
     */
    public function edit($id)
    {
        $estacionamiento = Estacionamiento::findOrFail($id);
        return view('estacionamiento.edit', compact('estacionamiento'));
    }

    /**
     * Actualizar servicio del estacionamiento
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'servicio' => 'required|in:xHora,xHoraMoto,Estadía6,Estadía12,Estadía24,Lavado13,Lavado16'
        ]);
        
        $estacionamiento = Estacionamiento::findOrFail($id);
        $estacionamiento->servicio = $request->servicio;
        $estacionamiento->save();
        
        return redirect()->route('estacionamiento.index')
                        ->with('success', 'Servicio actualizado correctamente.');
    }

    /**
     * Mostrar vista de facturación
     */
    public function facturar($id)
    {
        $estacionamiento = Estacionamiento::findOrFail($id);
        
        // Si ya está facturado, redirigir al índice
        if ($estacionamiento->salida !== null) {
            return redirect()->route('estacionamiento.index')
                            ->with('warning', 'Este registro ya ha sido facturado.');
        }
        
        // Calculamos el tiempo y el total a pagar según el servicio
        $ahora = Carbon::now();
        $tiempoEstacionado = $estacionamiento->ingreso->diffInMinutes($ahora);
        
        $total = $this->calcularTotal($estacionamiento->servicio, $tiempoEstacionado);
        
        return view('estacionamiento.facturar', compact('estacionamiento', 'tiempoEstacionado', 'total'));
    }

    /**
     * Procesar la facturación
     */
    public function procesarFactura($id)
    {
        $estacionamiento = Estacionamiento::findOrFail($id);
        
        // Si ya está facturado, redirigir al índice
        if ($estacionamiento->salida !== null) {
            return redirect()->route('estacionamiento.index')
                            ->with('warning', 'Este registro ya ha sido facturado.');
        }
        
        $ahora = Carbon::now();
        $tiempoEstacionado = $estacionamiento->ingreso->diffInMinutes($ahora);
        
        $total = $this->calcularTotal($estacionamiento->servicio, $tiempoEstacionado);
        
        // Actualizar el registro
        $estacionamiento->salida = $ahora;
        $estacionamiento->total = $total;
        $estacionamiento->save();
        
        return redirect()->route('estacionamiento.index')
                        ->with('success', 'Vehículo facturado correctamente. Total: $' . number_format($total, 2));
    }

    /**
     * Calcular el total según el servicio y tiempo
     */
    private function calcularTotal($servicio, $minutos)
    {
        switch ($servicio) {
            case 'xHora':
                // Primera media hora: $1,600
                $total = 1700;
                
                // Después de los primeros 30 minutos, se suma $600 por cada 15 minutos adicionales
                if ($minutos > 30) {
                    $minutosAdicionales = $minutos - 30;
                    $periodosDe15 = ceil($minutosAdicionales / 15);
                    $total += $periodosDe15 * 850;
                }
                return $total;

            case 'xHoraMoto':
                // Primera media hora: $1,600
                $total = 850;
                
                // Después de los primeros 30 minutos, se suma $600 por cada 15 minutos adicionales
                if ($minutos > 30) {
                    $minutosAdicionales = $minutos - 30;
                    $periodosDe15 = ceil($minutosAdicionales / 15);
                    $total += $periodosDe15 * 425;
                }
                return $total;
                
            case 'Estadía6':
                return 12000;

            case 'Estadía12':

                return 15000;
            case 'Estadía24':

                return 25000;

            case 'Lavado13':
                return 13000;

            case 'Lavado16':
                return 16000;
                
            default:
                return 0;
        }
    }

    public function caja()
    {
        $inicial ='$' . number_format( Caja::orderBy('created_at', 'desc')->value('total'));
        
        // Si ya está facturado, redirigir al índice
        // if ($total !== null) {
        //     return redirect()->route('estacionamiento.index')
        //                     ->with('warning', 'Este registro ya ha sido facturado.');
        // }
        
        // Calculamos el tiempo y el total a pagar según el servicio
        $otros = Carbon::now();
        $ingresos=0;
        
        // $total = 3;
        



        $estacionamientos = Estacionamiento::orderBy('total', 'asc')->orderBy('ingreso', 'desc')->get();
        $ventas = '$' . number_format($estacionamientos->sum('total'));
        $subtotal = number_format(Caja::orderBy('created_at', 'desc')->value('total') + $estacionamientos->sum('total'), 0);

        $total = '$' . $subtotal ?? 'nulo';





        return view('estacionamiento.caja', compact('inicial', 'ventas', 'total'));
    }

    public function editCaja(Request $request)
    {
        // $request->validate([
        //     'patente' => 'required|string|min:3|max:8|regex:/^[A-Z0-9]+$/'
        // ]);

        // Crear nuevo registro
        Caja::create([
            'total' => $request->total,
            'name' => 'Fito',
            // 'servicio' => 'xHora'
        ]);
        
        return redirect()->route('estacionamiento.index')
                        ->with('success', 'Retiro Correcto.');
    }





    public function printTicket($patente, $id)
    {
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
        $ticket .= "$patente\n";
        $ticket .= "\x1B\x21\x40"; // Establece modo de doble ancho y doble alto
        $ticket .= "\x1B\x21\x00"; // Vuelve al estilo normal
        // $ticket .= "Cliente: JUAN PEREZ\n";
        // $ticket .= "------------------------------\n";
        // Impresión del código de barras (Code39)
        // Es importante envolver el dato con asteriscos (*) para el formato Code39
        $ticket .= "\x1B\x61\x01";       // Centra el código de barras
        $barcodeData = "000$id";
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
        //$printer = "\\\\192.168.100.4\\XP-58";

        $printer = "\\\\192.168.129.4\\XP-58";
        $cmd = "copy \"$file\" \"$printer\"";
        $output = shell_exec($cmd);
        unlink($file);
    }











}