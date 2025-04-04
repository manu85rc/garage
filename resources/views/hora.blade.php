<!-- resources/views/hora.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hora en Tiempo Real</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f3f4f6;
        }
        #reloj {
            font-size: 3rem;
            color: #333;
        }
    </style>
</head>
<body>
    <div id="reloj">Cargando...</div>

    <script>
        function actualizarHora() {
            const reloj = document.getElementById('reloj');
            const ahora = new Date();

            // Formatear la hora en HH:MM:SS
            const horas = String(ahora.getHours()).padStart(2, '0');
            const minutos = String(ahora.getMinutes()).padStart(2, '0');
            const segundos = String(ahora.getSeconds()).padStart(2, '0');

            reloj.textContent = `${horas}:${minutos}:${segundos}`;
        }

        // Actualizar la hora cada segundo
        setInterval(actualizarHora, 1000);

        // Iniciar la hora inmediatamente
        actualizarHora();
    </script>
</body>
</html>