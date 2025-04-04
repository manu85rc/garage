@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Caja</h2>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h4>Resumen del Servicio</h4>
                        <p><strong>Dinero Inicial:</strong> {{$inicial}}</p>
                        <p><strong>Ventas:</strong> {{$ventas}}</p>
                        {{-- <p><strong>Retiros:</strong> 0</p> --}}
                        <p><strong>Total:</strong>  {{$total}}
                        </p>

                    </div>
                    
                    {{-- <form action="{{ route('estacionamiento.procesar-factura', $estacionamiento->id) }}" method="POST">
                        @csrf
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('estacionamiento.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-success">Confirmar Facturación</button>
                        </div>
                    </form> --}}





                    <form action="{{ route('estacionamiento.edit.caja') }}" method="POST" class="mb-4">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="number"name="total" class="form-control @error('total') is-invalid @enderror" 
                                   placeholder="Ingrese monto a retirar" 
                                   {{-- maxlength="8" 
                                   minlength="3" 
                                   oninput="this.value = this.value.toUpperCase()"  --}}
                                   required>
                            <button class="btn btn-primary" type="submit">Retirar</button>
                            
                            {{-- @error('total')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror --}}
                        </div>
                    </form>







                </div>
            </div>
        </div>
    </div>
</div>
@endsection