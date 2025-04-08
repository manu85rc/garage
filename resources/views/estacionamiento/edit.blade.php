@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Editar Servicio</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('estacionamiento.update', $estacionamiento->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="patente" class="form-label">Patente</label>
                            <input type="text" class="form-control" id="patente" value="{{ $estacionamiento->patente }}" readonly>
                        </div>
                        
                        <div class="mb-3">
                            <label for="ingreso" class="form-label">Hora de Ingreso</label>
                            <input type="text" class="form-control" id="ingreso" value="{{ $estacionamiento->ingreso->format('d/m/Y H:i') }}" readonly>
                        </div>
                        
                        <div class="mb-3">
                            <label for="servicio" class="form-label">Servicio</label>
                            <select name="servicio" id="servicio" class="form-select @error('servicio') is-invalid @enderror" required>
                                <option value="xHora" {{ $estacionamiento->servicio == 'xHora' ? 'selected' : '' }}>Por Hora Auto 🚗</option>
                                <option value="xHoraMoto" {{ $estacionamiento->servicio == 'xHoraMoto' ? 'selected' : '' }}>Por Hora Moto 🏍️</option>
                                <option value="Estadía6" {{ $estacionamiento->servicio == 'Estadía6' ? 'selected' : '' }}>Estadía 6Hs ($15.000)</option>
                                <option value="Estadía12" {{ $estacionamiento->servicio == 'Estadía12' ? 'selected' : '' }}>Estadía 12Hs ($20.000)</option>
                                <option value="Estadía24" {{ $estacionamiento->servicio == 'Estadía24' ? 'selected' : '' }}>Estadía 24hs ($30.000)</option>
                                <option value="Lavado13" {{ $estacionamiento->servicio == 'Lavado13' ? 'selected' : '' }}>Lavado 🚗($13.000)</option>
                                <option value="Lavado16" {{ $estacionamiento->servicio == 'Lavado16' ? 'selected' : '' }}>Lavado 🚚($16.000)</option>
                            </select>
                            
                            @error('servicio')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('estacionamiento.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Actualizar Servicio</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection