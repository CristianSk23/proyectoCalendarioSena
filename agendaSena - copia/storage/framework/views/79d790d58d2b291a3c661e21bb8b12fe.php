<nav class="bg-gray-200 w-1/4 p-4">

    <div class="container mx-1 px-1">
        <div class="border rounded-lg p-4 bg-gray-50">
            <div class="border rounded-lg p-4">
                <h1 class="text-3xl font-bold text-center "><?php echo e(\Carbon\Carbon::now()->locale('es')->monthName); ?></h1>
            </div>

            <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md table-auto">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th>Dom</th>
                        <th>Lun</th>
                        <th>Mar</th>
                        <th>Mié</th>
                        <th>Jue</th>
                        <th>Vie</th>
                        <th>Sáb</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    <?php $__currentLoopData = $calendario; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $semana): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <?php $__currentLoopData = $semana; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td class="py-4 px-4 text-center border border-gray-300 text-zinc-950">
                                    <?php echo e($dia ? $dia : ''); ?>

                                </td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>

            </table>
        </div>
    </div>
   



<!-- segmento eventos del dia actual yaque -->


   <!-- Contenedor para el listado de eventos -->
   <div class="mt-4 border rounded-lg p-4 bg-gray-50">
        <h3 class="font-bold text-lg">Eventos del <?php echo e(\Carbon\Carbon::now()->locale('es')->day); ?> de <?php echo e(\Carbon\Carbon::now()->locale('es')->monthName); ?></h3>
        <ul id="event-list" class="list-disc pl-5">
            <!-- Aquí se llenarán los eventos -->
        </ul>
        <p id="no-events" class="hidden">No hay nada agendado.</p>
    </div>
</nav>

   
    <script>
    // Simulación de eventos agendados
    const eventos = [
        { fecha: '2025-01-16', nombre: 'Reunión de Proyecto' },
        { fecha: '2025-01-17', nombre: 'Taller de Desarrollo' }
    ];

    const hoy = new Date().toISOString().split('T')[0]; // Obtener la fecha de hoy en formato YYYY-MM-DD
    const listaEventos = document.getElementById('event-list');
    const noEventos = document.getElementById('no-events');

    const eventosHoy = eventos.filter(evento => evento.fecha === hoy);

    if (eventosHoy.length > 0) {
        eventosHoy.forEach(evento => {
            const li = document.createElement('li');
            li.textContent = evento.nombre;
            listaEventos.appendChild(li);
        });
    } else {
        noEventos.classList.remove('hidden');
    }

</script>
</nav>
<?php /**PATH C:\Users\MI PC\Documents\GitHub\proyectoCalendarioSena\agendaSena\resources\views/partials/sidebarIzquierdo.blade.php ENDPATH**/ ?>