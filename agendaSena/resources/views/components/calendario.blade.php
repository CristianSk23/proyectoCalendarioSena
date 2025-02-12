<nav class="bg-gray-200 w-1/4 p-4">

    <div class="container mx-1 px-1">
        <div class="border rounded-lg p-4 bg-gray-50">
            <div class="border rounded-lg p-4">
                <h1 class="text-3xl font-bold text-center ">{{ \Carbon\Carbon::now()->locale('es')->monthName }}</h1>
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
                    @foreach ($calendario as $semana)
                        <tr>
                            @foreach ($semana as $dia)
                                <td class="py-4 px-4 text-center border border-gray-300 text-zinc-950">
                                    {{ $dia ? $dia : '' }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</nav>
