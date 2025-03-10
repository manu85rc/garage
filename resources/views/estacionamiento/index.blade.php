@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Control de Estacionamiento</h2>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if (session('warning'))
                        <div class="alert alert-warning">
                            {{ session('warning') }}
                        </div>
                    @endif
                    
                    <!-- Formulario para ingresar patente -->
                    <form action="{{ route('estacionamiento.store') }}" method="POST" class="mb-4">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" name="patente" class="form-control @error('patente') is-invalid @enderror" 
                                   placeholder="Ingrese la patente (3-8 caracteres)" 
                                   maxlength="8" 
                                   minlength="3" 
                                   oninput="this.value = this.value.toUpperCase()" 
                                   required>
                            <button class="btn btn-primary" type="submit">Registrar Ingreso</button>
                            
                            @error('patente')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </form>
                    
                    <!-- Tabla de registros -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Patente</th>
                                    <th>Ingreso</th>
                                    <th>Salida</th>
                                    <th>Servicio</th>
                                    <th>Total</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($estacionamientos as $estacionamiento)
                                    <tr class="{{ is_null($estacionamiento->salida) ? 'table-warning' : '' }}">
                                        <td>{{ $estacionamiento->id }}</td>
                                        <td>{{ $estacionamiento->patente }}</td>
                                        <td>{{ $estacionamiento->ingreso->format('H:i') }}</td>
                                        <td>{{ $estacionamiento->salida ? $estacionamiento->salida->format('H:i') : 'Pendiente' }}</td>
                                        <td>{{ $estacionamiento->servicio }}</td>
                                        <td>{{ $estacionamiento->total ? '$' . number_format($estacionamiento->total, 2) : 'Pendiente' }}</td>
                                        <td>
                                            @if (is_null($estacionamiento->salida))
                                                <a href="{{ route('estacionamiento.edit', $estacionamiento->id) }}" class="btn btn-sm btn-info">Editar Servicio</a>
                                                <a href="{{ route('estacionamiento.facturar', $estacionamiento->id) }}" class="btn btn-sm btn-success">Facturar</a>
                                            @else
                                                <span class="badge bg-secondary">Completado</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No hay registros disponibles</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection