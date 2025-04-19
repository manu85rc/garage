<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Estacionamiento </title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .inputpatente{
            display: flex;
            justify-content: center;
            align-items: center;
            max-width: 400px;
            margin: auto
        }

        .inputpatente   input,.inputpatente   button{
            height: 50px;
        }

        .inputpatente   input{
            font-size: 48px
        }

        .table{
            vertical-align: middle;
            text-align: center
        }
        .table td{
            vertical-align: middle;
            text-align: center
        }








        .servicio{
            color: #000;
            text-align: center;
            /* background-color: #f8f9fa; */
            /* border-color: #000; */
            /* padding: none!important; */
            /* border-radius: 0.5rem; */
            /* font-size: 28px; */
            text-decoration: none;
            font-weight: bold!important;
            /* display: contents; */

            width: 175px!important;
        }
        .servicio select{
            font-weight: bold!important;    
            border-color: transparent!important;
            background-color: transparent!important;
            cursor: pointer;
            text-align: center
        }

        .servicio select:hover{
            border-color: gray!important;
        }

        .servicio select:disabled{
            border-color: transparent!important;
            cursor: auto!important;
            appearance: none!important;
            -webkit-appearance: none!important;
            -moz-appearance: none!important;
            background-image: url('data:image/svg+xml;utf8,<svg fill="%23333" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>'); /* Flecha SVG básica */
            background-repeat: no-repeat;
        }
        /* .serv{
            color: #000;
            background-color: #f8f9fa;
            border-color: #f8f9fa;
            padding: 0.375rem 0.75rem;
            border-radius: 0.25rem;
            text-decoration: none;
            display: contents;
        } */
        .mediodepago{
            display: flex;
            justify-content: center;
            align-items: center;
            max-width: 200px;
            margin: auto
        }
        .eliminar{
            display: block;
            margin: auto;
            padding: 0;

        }
        .anular{
            text-decoration:line-through!important;
        }
        .cursor{
            cursor: pointer!important;
        }

        /* #main {
            width: 220px;
            height: 300px;
            border: 1px solid black; 
            display: flex;
            align-items: center;
        }
        #main div {
            flex: 1;
            border: 1px solid black;
            display: flex;
            align-items: center;
            } */
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" style="float:left;font-size:4rem;" href="{{ route('estacionamiento.index') }}">
                🚗
                {{-- 🅿️🏎️🛻🚗🚙🚚 --}}
            </a>
               @include('includes.hora')
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="mt-5 py-3 text-center">
        <div class="container">
            <p class="text-muted">Sistema de Estacionamiento &copy; {{ date('Y') }}</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>