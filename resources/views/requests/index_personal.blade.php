<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight relative">
            {{ 'Requerimentos' }} 
            <div class="">
                <span class=" bg-yellow-600 px-2 py-1 text-xs font-bold rounded-full  ">{{ $pending }}
                    Pendetes</span>
                <span class=" bg-gray-600 px-2 py-1 text-xs font-bold rounded-full  ">{{ $in_progress }} Em
                    andamento</span>
                <span class=" bg-green-600 px-2 py-1 text-xs font-bold rounded-full  ">{{ $done }}
                    Atendidos</span>
                <span class=" bg-red-600 px-2 py-1 text-xs font-bold rounded-full  ">{{ $rejected }}
                    Rejeitados</span>
            </div>
            
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-white-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-black-100">
                    @include('components.flash')
                    <table id="request_id" class="hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nome do documento</th>
                                <th>Estado</th>
                                <th>Enviado aos</th>
                                <th>Accao</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data->requests as $request)
                                <tr>
                                    <td>{{ $request->request->doc_name }}</td>
                                    <td>
                                        @if ($request->status == 0)
                                            <div class="py-2 px-4 rounded-full text-xs font-bold"
                                                style="background-color: #f6e05e;">
                                                Pendente</div>
                                        @endif
                                        @if ($request->status == 1)
                                            <div class="py-2 px-4 rounded-full text-xs font-bold"
                                                style="background-color: #cbd5e0;">
                                                Em andamento</div>
                                        @endif
                                        @if ($request->status == 2)
                                            <div class="py-2 px-4 rounded-full text-xs font-bold"
                                                style="background-color: #68d391;">
                                                Concluido</div>
                                        @endif
                                        @if ($request->status == 3)
                                            <div class="py-2 px-4 rounded-full text-xs font-bold"
                                                style="	background-color: #fc8181;">
                                                Rejeitado</div>
                                        @endif
                                    </td>
                                    <td>{{ $request->created_at }}</td>
                                    <td>
                                        <a href="{{ asset('storage/doc/' . $request->request->doc) }}" title="ver"
                                            target="_blank"
                                            class="text-primary transition duration-150 ease-in-out hover:text-primary-600 focus:text-primary-600 active:text-primary-700 dark:text-primary-400 dark:hover:text-primary-500 dark:focus:text-primary-500 dark:active:text-primary-600">
                                            <i class="fa-regular fa-eye"></i>
                                        </a>
                                        @if ($request->status == 2 && Auth::user()->role == 2)
                                            <a href="{{ route('requests.send_to', $request->id) }}"
                                                title="Enviar ao gabinete"
                                                class="text-primary transition duration-150 ease-in-out hover:text-primary-600 focus:text-primary-600 active:text-primary-700 dark:text-primary-400 dark:hover:text-primary-500 dark:focus:text-primary-500 dark:active:text-primary-600">
                                                <i class="fa-solid fa-share-nodes text-blue-600"></i>
                                            </a>
                                        @endif
                                        <div class="dropdown">
                                            <button class="dropbtn btn-link" for="btnControl"><i class="fa-solid fa-circle-chevron-down" style="color: #0c1bed;"></i></button>
                                            <div class="dropdown-content">
                                              <a href="{{ route('requests.in_progress', $request->id) }}"><i class="fa-solid fa-spinner fa-lg"></i> Em Andamento</a>
                                              <a href="{{ route('requests.done', $request->id) }}"><i class="fa-solid fa-check-double fa-lg" style="color: #5fc926;"></i> Concluida</a>
                                              <a href="{{ route('requests.reject', $request->id) }}"><i class="fa-solid fa-delete-left fa-lg" style="color: #bc3324;"></i> Rejeitada</a>
                                              <a href="{{ route('requests.reset', $request->id) }}"><i class="fa-solid fa-eject fa-lg" style="color: #b8ba2c;"></i> Anular Progresso</a>
                                            </div>
                                          </div>
                                        &nbsp;
                                        <form action="{{ route('user_requests.delete', $request->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button title="Apagar" onclick="return confirm('Eliminar o requerimento?')"
                                                class="text-secondary transition duration-150 ease-in-out hover:text-secondary-600 focus:text-secondary-600 active:text-secondary-700">
                                                <i class="fa-solid fa-trash text-red-500"></i>
                                            </button>

                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">{{ 'Nenhum registo encontrado.' }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function() {
        var table = new DataTable('#request_id', {
            language: {
                url: "{{ asset('DataTables/pt-PT.json') }}",
            },
        });
    });
</script>
