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
        .serv{
            color: #000;
            background-color: #f8f9fa;
            border-color: #f8f9fa;
            padding: 0.375rem 0.75rem;
            border-radius: 0.25rem;
            text-decoration: none;
            display: contents;
        }
        .mediodepago{
            display: flex;
            justify-content: center;
            align-items: center;
            max-width: 170px;
            margin: auto
        }
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