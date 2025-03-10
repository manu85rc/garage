<?php

namespace App\Http\Controllers;

use App\Models\Estacionamiento;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EstacionamientoController extends Controller
{
    /**
     * Mostrar listado de patentes registradas
     */
    public function index()
    {
        $estacionamientos = Estacionamiento::orderBy('ingreso', 'desc')->get();
        return view('estacionamiento.index', compact('estacionamientos'));
    }

    /**
     * Registrar ingreso de vehículo
     */
    public function store(Request $request)
    {
        $request->validate([
            'patente' => 'required|string|min:3|max:8|regex:/^[A-Z0-9]+$/'
        ]);

        $patente = strtoupper($request->patente);
        
        // Verificar si ya existe un registro pendiente con esta patente
        $pendiente = Estacionamiento::where('patente', $patente)
                                    ->whereNull('salida')
                                    ->first();
        
        if ($pendiente) {
            return redirect()->route('estacionamiento.facturar', $pendiente->id)
                            ->with('warning', 'Este vehículo ya está en el estacionamiento. Debe facturarlo.');
        }
        
        // Crear nuevo registro
        Estacionamiento::create([
            'patente' => $patente,
            'ingreso' => now(),
            'servicio' => 'xHora'
        ]);
        
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
}