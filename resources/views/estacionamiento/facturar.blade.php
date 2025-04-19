@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Facturar {{ $estacionamiento->servicio }}</h2>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h4>Resumen del Servicio</h4>
                        <p><strong>Patente:</strong> {{ $estacionamiento->patente }}</p>
                        <p><strong>Ingreso:</strong> {{ $estacionamiento->ingreso->format('d/m/Y H:i') }}</p>
                        <p class="{{($estacionamiento->time ? '':'d-none')}}"><strong>Tiempo estacionado:</strong> 
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
                        {{-- <div id="main">
                            <div class="form-check form-check-lg form-check-inline">
                                <input class="form-check-input" type="radio" name="mediodepago" id="exampleRadios1" value="Efectivo" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                    Efectivo
                                </label>
                            </div>
                            <div class="form-check  form-check-inline">
                                <input class="form-check-input" type="radio" name="mediodepago" id="exampleRadios2" value="MP">
                                <label class="form-check-label" for="exampleRadios2">
                                    Mercado pago
                                </label>
                            </div>
                            <div class="form-check  form-check-inline">
                                <input class="form-check-input" type="radio" name="mediodepago" id="exampleRadios3" value="Tarjeta">
                                <label class="form-check-label" for="exampleRadios3">
                                    Tarjeta
                                </label>
                            </div>
                            <div class="form-check  form-check-inline">
                                <input class="form-check-input" type="radio" name="mediodepago" id="exampleRadios4" value="Pendiente">
                                <label class="form-check-label" for="exampleRadios4">
                                    Pendiente
                                </label>
                            </div>
                        </div> --}}
                        <select id="focus" class="form-select form-select-lg mediodepago" multiple aria-label="multiple select example" aria-label="Default select example" name="mediodepago">
                            <option value="Efectivo" selected>Efectivo</option>
                            <option value="MP">Mercado Pago</option>
                            <option value="Tarjeta">Tarjeta</option>
                            <option value="Pendiente">Pendiente</option>
                          </select>
<script>
    document.getElementById("focus").focus();
</script>
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('estacionamiento.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-success">Confirmar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection