@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1>  

             
                    </h1>
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
                        <div class="input-group mb-3 inputpatente">
                            <input type="text" name="patente" class="form-control @error('patente') is-invalid @enderror" 
                                   placeholder="" 
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
                    <script>
document.addEventListener('DOMContentLoaded', function() {
    const patenteInput = document.querySelector('input[name="patente"]');
    
    // Enfoca el input inicialmente
    patenteInput.focus();
    
    // Captura clics en cualquier parte del documento
    document.addEventListener('click', function(event) {
        // Evita redireccionar el foco si el usuario está interactuando con otro input o select
        const isFormElement = event.target.tagName === 'INPUT' || 
                             event.target.tagName === 'SELECT' || 
                             event.target.tagName === 'TEXTAREA' || 
                             event.target.tagName === 'BUTTON';
        
        if (!isFormElement) {
            event.preventDefault();
            patenteInput.focus();
        }
    });
    
    // Captura pulsaciones de teclas en cualquier parte del documento
    document.addEventListener('keydown', function(event) {
        // Evita redireccionar el foco si el usuario está escribiendo en otro input o select
        const activeElement = document.activeElement;
        const isFormElement = activeElement.tagName === 'INPUT' || 
                             activeElement.tagName === 'SELECT' || 
                             activeElement.tagName === 'TEXTAREA';
        
        if (!isFormElement || activeElement !== patenteInput) {
            // No interfiere con teclas de control como F5, Ctrl+R, etc.
            if (!event.ctrlKey && !event.altKey && !event.metaKey && event.key !== 'F5') {
                patenteInput.focus();
            }
        }
    });
    
    // Enfoca el input cuando la ventana recupera el foco
    window.addEventListener('focus', function() {
        patenteInput.focus();
    });
});
                        </script>
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
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($estacionamientos as $estacionamiento)
                                
                                    <tr class="{{ is_null($estacionamiento->mediodepago) ? 'table-warning' :($estacionamiento->mediodepago == 'Pendiente'? 'table-danger':($estacionamiento->estadia ? 'table-success':'')) }} {{$estacionamiento->anular ? 'anular':''}}">
                                        {{-- <td>{{ $estacionamiento->id }}</td> --}}
                                        <td>{{ $estacionamiento->id }}</td>
                                        <td> <strong>{{ $estacionamiento->patente }}</strong></td>
                                        <td>{{ $estacionamiento->ingreso->format('H:i') }}      {{ $estacionamiento->ingreso->format('d/m') == now()->format('d/m') ? '':$estacionamiento->ingreso->format('d/m') }}</td>
                                        <td>{{ $estacionamiento->total ? $estacionamiento->salida->format('H:i') : '' }}</td>
                                        <td id="servicio" class="servicio" >


                                            {{-- <div class="mb-3"> --}}
                                                {{-- <label for="servicio" class="form-label">Servicio</label> --}}
                                                <select id="servicioid" name="servicio" class="form-select @error('servicio') is-invalid @enderror"  onchange="ServiciosEstacionamiento({{ $estacionamiento->id }}, '{{ $estacionamiento->patente }}',this.value)" {{($estacionamiento->total) ? 'disabled':''}}>
                                                    <option value="xHora" {{ $estacionamiento->servicio == 'xHora' ? 'selected' : '' }}>x Hora</option>
                                                    <option value="xHoraMoto" {{ $estacionamiento->servicio == 'xHoraMoto' ? 'selected' : '' }}>Por Hora Moto</option>
                                                    <option value="Estadía6" {{ $estacionamiento->servicio == 'Estadía6' ? 'selected' : '' }}>Estadía 6Hs</option>
                                                    <option value="Estadía12" {{ $estacionamiento->servicio == 'Estadía12' ? 'selected' : '' }}>Estadía 12Hs</option>
                                                    <option value="Estadía24" {{ $estacionamiento->servicio == 'Estadía24' ? 'selected' : '' }}>Estadía 24hs</option>
                                                    <option value="Lavadoauto" {{ $estacionamiento->servicio == 'Lavadoauto' ? 'selected' : '' }}>Lavado Auto</option>
                                                    <option value="Lavadochata" {{ $estacionamiento->servicio == 'Lavadochata' ? 'selected' : '' }}>Lavado Chata</option>
                                                </select>
                                                
                                                @error('servicio')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            {{-- </div> --}}
                                            {{-- {{ $estacionamiento->servicio ? $estacionamiento->servicio :'Editar' }}  --}}





                                            {{-- <button type="button" class="btn eliminar" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="eliminarEstacionamiento({{ $estacionamiento->id }}, '{{ $estacionamiento->patente }}')"> --}}

                                            {{-- </button> --}}
                                            {{-- <a href="{{ route('estacionamiento.edit', $estacionamiento->id) }}" class="serv">{{ $estacionamiento->servicio ? $estacionamiento->servicio :'Editar' }}   </a> --}}
                                        </td>
                                        <td>{{ $estacionamiento->total ? '$' . number_format($estacionamiento->total, 0) : '' }} <b>{{$estacionamiento->mediodepago}}</b></td>
                                        <td>
                                            @if (is_null($estacionamiento->mediodepago) or $estacionamiento->mediodepago == 'Pendiente')

                                                <button onclick="window.location.href = `{{ route('estacionamiento.facturar', $estacionamiento->id ) }}`" class="btn btn-sm btn-success">Cobrar</button>
                                            @else
                                                {{-- <span class="badge bg-secondary">Completado</span> --}}
                                            @endif
                                        </td>
                                        <td>
                                            @if (is_null($estacionamiento->mediodepago) or $estacionamiento->mediodepago == 'Pendiente')
                                                <button type="button" class="btn eliminar" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="eliminarEstacionamiento({{ $estacionamiento->id }}, '{{ $estacionamiento->patente }}')">
                                                ❌
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No hay registros disponibles</td>
                                    </tr>
                                @endforelse
                                <tr>
                                    <td colspan="8" class="text-center">
                                        {{-- No hay registros disponibles --}}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="8" class="text-center cursor" onclick="window.location.href = '{{ route('estacionamiento.caja') }}'">                                        {{-- <a href="{{ route('estacionamiento.caja') }}" class="btn btn-sm btn">   --}}
                       
                                        <b>{{$total}}</b>
                                    </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="bodymodal">
          ...
        </div>
        <div class="modal-footer" id="fotomodal">
          {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-danger">Eliminar</button> --}}

        </div>
      </div>
    </div>
  </div>

<script>
function ServiciosEstacionamiento(id, patente, servicio) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/estacionamiento/${id}`;
        form.innerHTML = `
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="servicio" value="${servicio}">
        `;
        document.body.appendChild(form);
        form.submit();

console.log(servicio)

    }

    function eliminarEstacionamiento(id, patente) {
        // const form = document.createElement('form');
        // form.method = 'GET';
        // form.action = `/estacionamiento/${id}/delete`; // Cambia esto a la ruta correcta para eliminar el registro

        document.getElementById("bodymodal").innerHTML = `
            Anular Patemte: <b>${patente}</b> ?
        `;




        
        document.getElementById("fotomodal").innerHTML = `
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      
        
          <button type="button" class="btn btn-danger" onclick="window.location.href = '/delete/${id}'">Eliminar</button>
        `;
        // document.body.appendChild(form);
        // form.submit();
    }
</script>






@endsection