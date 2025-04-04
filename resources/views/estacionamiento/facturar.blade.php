@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Facturar Estacionamiento</h2>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h4>Resumen del Servicio</h4>
                        <p><strong>Patente:</strong> {{ $estacionamiento->patente }}</p>
                        <p><strong>Ingreso:</strong> {{ $estacionamiento->ingreso->format('d/m/Y H:i') }}</p>
                        <p><strong>Tiempo estacionado:</strong> 
                            @php
                                $horas = floor($tiempoEstacionado / 60);
                                $minutos = $tiempoEstacionado % 60;
                            @endphp
                            {{ $horas }} hora(s) y {{ $minutos }} minuto(s)
                        </p>
                        <p><strong>Servicio:</strong> {{ $estacionamiento->servicio }}</p>
                        <p><strong>Total a pagar:</strong> <b>${{ number_format($total, 0) }}</b></p>
                    </div>
                    
                    <form action="{{ route('estacionamiento.procesar-factura', $estacionamiento->id) }}" method="POST">
                        @csrf
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('estacionamiento.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-success">Confirmar Facturación</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection