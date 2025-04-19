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
        $estacionamientos = Estacionamiento::whereNull('cajasid')->whereNull('anular')
        ->orwhereIn('servicio', ['Estadía6', 'Estadía6', 'Estadía12', 'Estadía24','Lavadoauto','Lavadochata'])->whereNull('anular')->where('ingreso', '>=', Carbon::now()->sub('25 hour'))
        ->orderBy('id', 'asc')->get();

        $efectivo = Estacionamiento::whereNull('cajasid')->whereNull('anular')->where('mediodepago', 'Efectivo')->get();
        /*
        $lavados = Estacionamiento::whereIn('servicio', ['lavadoauto', 'lavadochata'])->count();
--      echo $lavados;        exit;
        */

        $subtotal = number_format(Caja::orderBy('created_at', 'desc')->value('total') + $efectivo->sum('total'), 0);

        $total = '$' . $subtotal ?? 'nulo';

       $estacionamientos->map(function ($estacionamiento) {
            $estacionamiento->mediodepago = $estacionamiento->mediodepago == 'Efectivo' ? '':($estacionamiento->mediodepago == 'Tarjeta' ? '💳':$estacionamiento->mediodepago);
            $estacionamiento->estadia=false;
            $estacionamiento->lavado=false;
            switch ($estacionamiento->servicio) {
                case 'Estadía6':
                    $estacionamiento->estadia=true;
                    break;
                case 'Estadía12':
                    $estacionamiento->estadia=true;
                    break;
                case 'Estadía24':
                    $estacionamiento->estadia=true;
                    break;
                case 'Lavadoauto':
                    $estacionamiento->lavado=true;
                    break;
                case 'Lavadochata':
                    $estacionamiento->lavado=true;
                    break;
            }
            // switch ($estacionamiento->servicio) {
            //     case 'xHora':
            //         return $estacionamiento->servicio = 'x Hora';
            //     case 'xHoraMoto':
            //         return $estacionamiento->servicio = 'x Hora Moto';
            //     case 'Estadía6':
            //         return  $estacionamiento->servicio = 'Estadía 6Hs';
            //     case 'Estadía12':
            //         return    $estacionamiento->servicio = 'Estadía 12Hs';
            //     case 'Estadía24':
            //         return   $estacionamiento->servicio = 'Estadía 24Hs';
            //     case 'Lavadoauto':
            //         return   $estacionamiento->servicio = 'Lavado Auto';
            //     case 'Lavadochata':
            //         return   $estacionamiento->servicio = 'Lavado Chata';
            //     default:
            //     return $estacionamiento->servicio = '';
            // }

            // $estacionamiento->servicio = $estacionamiento->mediodepago == 'Efectivo' ? '':($estacionamiento->mediodepago == 'Tarjeta' ? '💳':$estacionamiento->mediodepago);

            return $estacionamiento;
        });

        // $efectivo = Estacionamiento::whereNull('cajasid')->where('mediodepago', 'Efectivo')->get();



        $lavadoshoy = Estacionamiento::whereIn('servicio', ['Lavadoauto', 'Lavadochata'])->whereDate('ingreso', Carbon::today())->count();
        $lavadosayer = Estacionamiento::whereIn('servicio', ['Lavadoauto', 'Lavadochata'])->whereDate('ingreso', Carbon::yesterday())->count();

        return view('estacionamiento.index', compact('estacionamientos', 'total', 'lavadoshoy', 'lavadosayer'));
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
        $pendiente = Estacionamiento::where('patente', $patente)->whereNull('anular')
                                    ->whereNull('salida')
                                    ->first();
        
        if ($pendiente) {
            return redirect()->route('estacionamiento.facturar', $pendiente->id)
                            ->with('warning', 'Este vehículo ya está en el estacionamiento. Debe facturarlo.');
        }
        
        // Crear nuevo registro
       $save = Estacionamiento::create([
            'patente' => $patente,
            'ingreso' => now()->timezone('America/Argentina/Buenos_Aires'),
            'servicio' => 'xHora'
        ]);
        $this->printTicket($patente,$save->id);
        
        return redirect()->route('estacionamiento.index')
                        ->with('success', 'Nuevo Ingreso '.$patente.' registrado correctamente.');
    }

    /**
     * Mostrar formulario para editar servicios
     */
    public function edit($id)
    {
        $estacionamiento = Estacionamiento::findOrFail($id);
        return view('estacionamiento.edit', compact('estacionamiento'));
    }



    public function delete($id)
    {
        Estacionamiento::where('id', $id)->update(['anular' => 1]);




        // $estacionamiento = Estacionamiento::findOrFail($id);
        // return view('estacionamiento.edit', compact('estacionamiento'));

        return redirect()->route('estacionamiento.index')
                        ->with('warning', 'registro anulado');


    }





    /**
     * Actualizar servicio del estacionamiento
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'servicio' => 'required|in:xHora,xHoraMoto,Estadía6,Estadía12,Estadía24,Lavadoauto,Lavadochata'
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
        if ($estacionamiento->total !== null) {

            if ($estacionamiento->mediodepago !== 'Pendiente') {
                return redirect()->route('estacionamiento.index')
                                ->with('warning', 'Este registro ya ha sido facturado.');
            }else{//Pendiente
                $total = $estacionamiento->total;
                $tiempoEstacionado = $estacionamiento->ingreso->diffInMinutes($estacionamiento->salida);
                $total = $this->calcularTotal($estacionamiento->servicio, $tiempoEstacionado);
                return view('estacionamiento.facturar', compact('estacionamiento', 'tiempoEstacionado', 'total'));
            }
        }
        
        // Calculamos el tiempo y el total a pagar según el servicio
        $ahora = Carbon::now()->timezone('America/Argentina/Buenos_Aires');
        $estacionamiento->salida = $ahora;
        $estacionamiento->save();

        $tiempoEstacionado = $estacionamiento->ingreso->diffInMinutes($estacionamiento->salida);
        
        $total = $this->calcularTotal($estacionamiento->servicio, $tiempoEstacionado);
        
       
            switch ($estacionamiento->servicio) {
                case 'xHora':
                case 'xHoraMoto':
                case 'Estadía6':
                $estacionamiento->time = true;
                break;
            }
   
        
        return view('estacionamiento.facturar', compact('estacionamiento', 'tiempoEstacionado', 'total'));
    }

    /**
     * Procesar la facturación
     */
    public function procesarFactura($id,Request $request)
    {

        $estacionamiento = Estacionamiento::findOrFail($id);
        
        // Si ya está facturado, redirigir al índice
        if ($estacionamiento->mediodepago !== null) {
            if ($estacionamiento->mediodepago !== 'Pendiente') {
                return redirect()->route('estacionamiento.index')
                ->with('warning', 'Este registro ya ha sido facturado.');
            }

        }
        
        // $ahora = Carbon::now()->timezone('America/Argentina/Buenos_Aires');
        $salida = $estacionamiento->salida;
        $tiempoEstacionado = $estacionamiento->ingreso->diffInMinutes($salida);
        
        $total = $this->calcularTotal($estacionamiento->servicio, $tiempoEstacionado);
        
        // Actualizar el registro
        $estacionamiento->total = $total;
        //$estacionamiento->salida = $salida;
        $estacionamiento->mediodepago = $request->mediodepago;;
        $estacionamiento->save();
        
        return redirect()->route('estacionamiento.index')
                        ->with('success', 'Vehículo facturado correctamente. Total: $' . number_format($total, 2));
    }

    /**
     * Calcular el total según el servicio y tiempo
     */
    private function calcularTotal($servicio, $minutos)
    {

        $minutos = $minutos-5;

        switch ($servicio) {
            case 'xHora':
                // Primera media hora: $1,600
                $total = 2000;
                
                // Después de los primeros 30 minutos, se suma $600 por cada 15 minutos adicionales
                if ($minutos > 30) {
                    $minutosAdicionales = $minutos - 30;
                    $periodosDe15 = ceil($minutosAdicionales / 15);
                    $total += $periodosDe15 * 1000;
                }
                return $total;

            case 'xHoraMoto':
                // Primera media hora: $1,600
                $total = 1000;
                
                // Después de los primeros 30 minutos, se suma $600 por cada 15 minutos adicionales
                if ($minutos > 30) {
                    $minutosAdicionales = $minutos - 30;
                    $periodosDe15 = ceil($minutosAdicionales / 15);
                    $total += $periodosDe15 * 500;
                }
                return $total;
                
            case 'Estadía6':
                return 15000;

            case 'Estadía12':

                return 20000;
            case 'Estadía24':

                return 30000;

            case 'Lavadoauto':
                return 13000;

            case 'Lavadochata':
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
        $otros = Carbon::now()->timezone('America/Argentina/Buenos_Aires');
        $ingresos=0;
        
        // $total = 3;
        

        $estacionamientos = Estacionamiento::whereNull('cajasid')->whereNull('anular')->orderBy('total', 'asc')->orderBy('ingreso', 'desc')->get();
        $efectivo = Estacionamiento::whereNull('cajasid')->whereNull('anular')->where('mediodepago', 'Efectivo')->get();

        $ventas = '$' . number_format($efectivo->sum('total'));
        $subtotal = number_format(Caja::orderBy('created_at', 'desc')->value('total') + $efectivo->sum('total'), 0);

        $total = '$' . $subtotal ?? 'nulo';

        return view('estacionamiento.caja', compact('inicial', 'ventas', 'total'));
    }

    public function editCaja(Request $request)
    {
        // $inicial ='$' . number_format( Caja::orderBy('created_at', 'desc')->value('total'));
        // $otros = Carbon::now()->timezone('America/Argentina/Buenos_Aires');
        // $ingresos=0;
        // $estacionamientos = Estacionamiento::orderBy('total', 'asc')->orderBy('ingreso', 'desc')->get();
        $efectivo = Estacionamiento::whereNull('cajasid')->where('mediodepago', 'Efectivo')->get();
        // $ventas = '$' . number_format($efectivo->sum('total'));
        $subtotal = Caja::orderBy('created_at', 'desc')->value('total') + $efectivo->sum('total')   ;

        // echo $subtotal;exit;
        $total=($subtotal??0) - ($request->total??0);

        $lastCaja = Caja::orderBy('created_at', 'desc')->value('id');
        Estacionamiento::whereNot('mediodepago', 'Pendiente')->whereNull('anular')->whereNotNull('total')->update(['cajasid' => $lastCaja]);

        Caja::create([
            'total' => $total,
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
        $ip="192.168.129.7";
        // $printer = "\\\\192.168.129.4\\XP-58";
        $printer = "\\\\$ip\\XP-58";
        $cmd = "copy \"$file\" \"$printer\"";
        $output = shell_exec($cmd);
        unlink($file);
    }











}