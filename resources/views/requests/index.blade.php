<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black-800  leading-tight relative">
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
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-white-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-black-100">
                    @include('components.flash')
                    <div class="flex justify-end">
                        <a href="{{ route('requests.create') }}"
                            class="bg-gray-500 text-white p-2 mb-5 rounded hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-gray-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-gray-700 uppercase active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]">Dar
                            entrada do documento</a>
                    </div>
                    <table id="request_id" class="hover cell-border" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nome do documento</th>
                                <th>Contacto</th>
                                <th style="border-bottom: 1px solid #a3bffa">Departamento</th>
                                <th style="border-bottom: 1px solid #a3bffa">Estado</th>
                                <th>Estado Final</th>
                                <th>Data de entrada</th>
                                <th>Quitação</th>
                                <th>Accao</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($requests as $request)
                                <tr>
                                    <td>{{ $request->doc_name }}</td>
                                    <td>{{ $request->phone }}</td>
                                    <td style="border-bottom: 1px solid #a3bffa">
                                        @if (sizeof($request->users) > 0)
                                            @foreach ($request->users as $item)
                                                @if ($item->active)
                                                    @if ($item->user->role == 2)
                                                        <span>Departamento de Estatistica Economicas</span>
                                                    @endif
                                                    @if ($item->user->role == 3)
                                                        <span>Gabinete</span>
                                                    @endif
                                                @endif
                                            @endforeach
                                            @if ($request->status == 2 || $request->status == 3)
                                                Secretaria
                                            @endif
                                        @else
                                            Secretaria
                                        @endif
                                    </td>
                                    <td style="border-bottom: 1px solid #a3bffa">
                                        @if (sizeof($request->users) > 0)
                                            @foreach ($request->users as $item)
                                                @if ($item->active)
                                                    @if ($item->status == 0)
                                                        <div class="py-2 px-4 rounded-full text-xs font-bold"
                                                            style="background-color: #f6e05e;">
                                                            Pendente</div>
                                                    @endif
                                                    @if ($item->status == 1)
                                                        <div class="py-2 px-4 rounded-full text-xs font-bold"
                                                            style="background-color: #cbd5e0;">
                                                            Em andamento</div>
                                                    @endif
                                                    @if ($item->status == 2)
                                                        <div class="py-2 px-4 rounded-full text-xs font-bold"
                                                            style="background-color: #68d391;">
                                                            Concluido</div>
                                                    @endif
                                                    @if ($item->status == 3)
                                                        <div class="py-2 px-4 rounded-full text-xs font-bold"
                                                            style="	background-color: #fc8181;">
                                                            Rejeitado</div>
                                                    @endif
                                                @endif
                                            @endforeach
                                            @if ($item->status == 2)
                                                <div class="py-2 px-4 rounded-full text-xs font-bold"
                                                    style="background-color: #68d391;">
                                                    Concluido</div>
                                            @endif
                                            @if ($item->status == 3)
                                                <div class="py-2 px-4 rounded-full text-xs font-bold"
                                                    style="	background-color: #fc8181;">
                                                    Rejeitado</div>
                                            @endif
                                        @else
                                            <span class="py-2 px-4 rounded-full text-xs font-bold"
                                                style="background-color: gray">Por enviar</span>
                                        @endif
                                    </td>
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
                                    <td>{{ date('d M, Y H:i:s', strtotime($request->created_at)) }}</td>
                                    <td>
                                        @if ($request->status == 2)
                                        @if ($request->discharge)
                                            <span class="flex justify-start">
                                                <a class="btn-link text-blue-500 hover:underline inline mr-4"
                                                    href="{{ asset('storage/doc/' . $request->discharge->doc) }}"
                                                    target="_blank" rel="noopener noreferrer">
                                                    {{ $request->discharge->name ?? 'Quitação' }}
                                                </a>
                                                <span class="inline">
                                                    <a href="{{ asset('storage/doc/' . $request->discharge->doc) }}"
                                                        title="baixar a quicao" target="_blank"
                                                        class="text-green-400 transition duration-150 ease-in-out hover:text-primary-600 focus:text-primary-600 active:text-primary-700 dark:text-primary-400 dark:hover:text-primary-500 dark:focus:text-primary-500 dark:active:text-primary-600">
                                                        <i class="fa-solid fa-download"></i>
                                                    </a>
                                                </span>
                                            </span>
                                        @else
                                            -
                                        @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ asset('storage/doc/' . $request->doc) }}" title="ver"
                                            target="_blank"
                                            class="text-primary transition duration-150 ease-in-out hover:text-primary-600 focus:text-primary-600 active:text-primary-700 dark:text-primary-400 dark:hover:text-primary-500 dark:focus:text-primary-500 dark:active:text-primary-600">
                                            <i class="fa-regular fa-eye"></i>
                                        </a>
                                        @if ($request->status == 0)
                                            <a href="{{ route('requests.send', $request->id) }}"
                                                title="Enviar ao departamento"
                                                class="text-primary transition duration-150 ease-in-out hover:text-primary-600 focus:text-primary-600 active:text-primary-700 dark:text-primary-400 dark:hover:text-primary-500 dark:focus:text-primary-500 dark:active:text-primary-600">
                                                <i class="fa-solid fa-share-nodes text-blue-600"></i>
                                            </a>
                                        @endif
                                        &nbsp;
                                        <form class="inline" action="{{ route('requests.delete', $request->id) }}"
                                            method="post">
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
                        <tfoot>
                            <tr>
                                <th>Nome do documento</th>
                                <th>Contacto</th>
                                <th style="border-bottom: 1px solid #a3bffa">Departamento</th>
                                <th style="border-bottom: 1px solid #a3bffa">Estado</th>
                                <th>Estado Final</th>
                                <th>Data de entrada</th>
                                <th>Quitação</th>
                                <th>Accao</th>
                            </tr>
                        </tfoot>
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
