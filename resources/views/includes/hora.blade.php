    <spam id="reloj" class="navbar-brand" style="float:right;font-size:4rem;">Cargando...</spam>

    <script>
        function actualizarHora() {
            const reloj = document.getElementById('reloj');
            const ahora = new Date();

            // Formatear la hora en HH:MM:SS
            const horas = String(ahora.getHours()).padStart(2, '0');
            const minutos = String(ahora.getMinutes()).padStart(2, '0');
            // const segundos = String(ahora.getSeconds()).padStart(2, '0');

            reloj.textContent = `${horas}:${minutos}`;//:${segundos}`;
        }

        // Actualizar la hora cada segundo
        setInterval(actualizarHora, 1000);

        // Iniciar la hora inmediatamente
        actualizarHora();
    </script>