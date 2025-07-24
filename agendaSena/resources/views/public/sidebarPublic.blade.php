 <!-- Sidebar con Calendario -->
    <div class="sidebar">
        
        <h4 class="text-center mb-4">Calendario</h4>

            <!-- Contenedor del calendario -->
            <div class="calendar-nav">
                <button id="prev-month" class="btn btn-outline-primary"><i class="bi bi-arrow-left"></i></button>
                <span id="month-name" class="h5"></span>
                <button id="next-month" class="btn btn-outline-primary"><i class="bi bi-arrow-right"></i></button>
            </div>

            <div class="calendar-container">
            <!-- <did class="text-calendar"> <h1> Calendario</h1> -->
                <table class="table calendar-table">
                    <thead>
                        <tr>
                            <th>Dom</th>
                            <th>Lun</th>
                            <th>Mar</th>
                            <th>Mié</th>
                            <th>Jue</th>
                            <th>Vie</th>
                            <th>Sáb</th>
                        </tr>
                    </thead>
                    <tbody id="calendar-body">
                        <!-- Aquí se llenarán los días del calendario -->
                    </tbody>
                </table>
            </div>
                   
        <div>

                   <!-- Filtro por categoria -->    
                <div class="search-input-container">
                    <label for="categoria_id">Filtrar por categoría:</label>
                    <select class="form-select" name="categoria_id" id="categoria_id">
                        <option value="">-- Selecciona una categoría --</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->idCategoria }}">{{ $categoria->nomCategoria }}</option>
                        @endforeach
                    </select>
                </div>

                    

                <!-- Filtro por Fecha -->
               <div class="search-input-container">
                    <label>Buscar por rango de fechas:</label>
                    <div class="d-flex gap-2">
                        <input type="date" id="start-date" class="form-control">
                        <input type="date" id="end-date" class="form-control">
                    </div>
                </div>
                

              

                <!-- Filtro por Nombre del Evento -->
                <div class="search-input-container">
                    <label for="search-input">Buscar por nombre:</label>
                    <!-- <input type="text" id="search-input" class="form-control" placeholder="Buscar evento por nombre..." oninput="searchEvent()"> -->
                    <input type="text" id="search-input" class="form-control" placeholder="Buscar evento por nombre" oninput="searchEvent()">

                </div>

                <!-- Borrar filtros -->
                <div class="mt-3">
                    <button class="btn btn-outline-secondary w-100" onclick="borrarFiltros()">
                        <i class="bi bi-x-lg"></i> Borrar Filtros
                    </button>
                </div>

                <!-- boton mostar todos los eventos -->
                <div class="mt-3">
                    <button class="btn btn-outline-primary w-100" onclick="mostrarTodosEventos()">
                        Mostrar todos los eventos
                    </button>
                </div>

                <!-- boton Solicitud de eventos desde vista publica -->
                <div class="mt-3">                                   
                        <button id="abrirModalAgregar" class="btn btn-outline-primary w-100">
                            Solicitar Evento
                        </button>
                    </div>
                 </div>  
                 
                <div class="mt-3">
                    <a href="{{ route('public.index') }}" class="btn btn-outline-secondary w-100">
                        INICIO
                    </a>
                </div>

    </div>

    