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
                    <table id="request_id" class="hover cell-border" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nome do documento</th>
                                <th>Estado</th>
                                <th>Enviado aos</th>
                                <th>Quitação</th>
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
                                    <td>{{ date("d M, Y H:i:s", strtotime($request->created_at)) }}</td>
                                    <td>
                                        @if ($request->request->discharge)
                                            <span class="flex justify-between">
                                                <a class="btn-link text-blue-500 hover:underline inline"
                                                    href="{{ asset('storage/doc/' . $request->request->discharge->doc) }}"
                                                    target="_blank" rel="noopener noreferrer">
                                                    {{ $request->request->discharge->name ?? 'Quitação' }}
                                                </a>
                                                <span class="inline">
                                                    <a href="{{ asset('storage/doc/' . $request->request->discharge->doc) }}"
                                                        title="ver a quicao" target="_blank"
                                                        class="text-primary transition duration-150 ease-in-out hover:text-primary-600 focus:text-primary-600 active:text-primary-700 dark:text-primary-400 dark:hover:text-primary-500 dark:focus:text-primary-500 dark:active:text-primary-600">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </a>
                                                    @if (Auth::user()->role == 2)
                                                        &nbsp;
                                                        <form class="inline"
                                                            action="{{ route('discharge.delete', $request->request->discharge->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button title="Apagar quitacao"
                                                                onclick="return confirm('Eliminar a quitacao?')"
                                                                class=" inline text-secondary transition duration-150 ease-in-out hover:text-secondary-600 focus:text-secondary-600 active:text-secondary-700">
                                                                <i class="fa-solid fa-trash text-red-500"></i>
                                                            </button>

                                                        </form>
                                                    @endif
                                                </span>
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($request->status == 2 && Auth::user()->role == 2)
                                            @if (!$request->request->discharge)
                                                <a href="#" onclick="toggleModal({{ $request->request->id }})"
                                                    title="Carregar quitação"
                                                    class="text-primary transition duration-150 ease-in-out hover:text-green-600 focus:text-green-600 active:text-green-700">
                                                    <i class="fa-solid fa-upload text-green-500"></i>
                                                </a>
                                            @endif
                                            @if ($request->request->discharge)
                                                <a href="{{ route('requests.send_to', $request->id) }}"
                                                    title="Enviar ao gabinete"
                                                    class="text-primary transition duration-150 ease-in-out hover:text-primary-600 focus:text-primary-600 active:text-primary-700 dark:text-primary-400 dark:hover:text-primary-500 dark:focus:text-primary-500 dark:active:text-primary-600">
                                                    <i class="fa-solid fa-share-nodes text-blue-600"></i>
                                                </a>
                                            @endif
                                        @endif
                                        <a href="{{ asset('storage/doc/' . $request->request->doc) }}" title="ver"
                                            target="_blank"
                                            class="text-primary transition duration-150 ease-in-out hover:text-primary-600 focus:text-primary-600 active:text-primary-700 dark:text-primary-400 dark:hover:text-primary-500 dark:focus:text-primary-500 dark:active:text-primary-600">
                                            <i class="fa-regular fa-eye"></i>
                                        </a>
                                        <div class="dropdown">
                                            <button class="dropbtn btn-link" for="btnControl"><i
                                                    class="fa-solid fa-circle-chevron-down"
                                                    style="color: #0c1bed;"></i></button>
                                            <div class="dropdown-content">
                                                <a href="{{ route('requests.in_progress', $request->id) }}"><i
                                                        class="fa-solid fa-spinner fa-lg"></i> Em Andamento</a>
                                                <a href="{{ route('requests.done', $request->id) }}"><i
                                                        class="fa-solid fa-check-double fa-lg"
                                                        style="color: #5fc926;"></i> Concluida</a>
                                                <a href="{{ route('requests.reject', $request->id) }}"><i
                                                        class="fa-solid fa-delete-left fa-lg"
                                                        style="color: #bc3324;"></i> Rejeitada</a>
                                                <a href="{{ route('requests.reset', $request->id) }}"><i
                                                        class="fa-solid fa-eject fa-lg" style="color: #b8ba2c;"></i>
                                                    Anular Progresso</a>
                                            </div>
                                        </div>
                                        &nbsp;
                                        <form class="inline" action="{{ route('user_requests.delete', $request->id) }}"
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
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="fixed z-10 overflow-y-auto top-0 w-full left-0 hidden" id="modal">
        <div class="flex items-center justify-center min-height-100vh pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-900 opacity-75" />
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-center bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-base font-semibold leading-4 mb-4 border-b-2 border-neutral-100 py-2 text-gray-900"
                        id="modal-title">Carregar a quitação</h3>
                    <form id="dischargeForm" action="{{ route('discharge.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="request_id" id="request_id_in">
                        <label class="font-medium text-gray-800">Nome do documento</label>
                        <input name="name" type="text"
                            class="w-full outline-none rounded bg-gray-100 p-2 mt-2 mb-3" />
                        <label class="font-medium text-gray-800">Documento</label>
                        <legend class="mb-3 text-yellow-900">Para carregar o documento, primeiro scannea o depois
                            carregue usando o botão abaixo, apenas PDF.</legend>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label
                                    class="w-full flex flex-col items-center  text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer focus:outline-none focus:bg-white focus:border-black-500">
                                    <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                    </svg>
                                    <span class="mt-2 text-base leading-normal">Selecione o documento para carregar em
                                        pdf</span>
                                    <input type='file' name="doc" class="hidden"
                                        accept="image/png, image/jpeg, image/jpg, .pdf" />
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('doc')" class="mt-2" />
                        </div>
                    </form>
                </div>
                <div class="bg-gray-200 px-4 py-3 text-right">
                    <button type="button" class="py-2 px-4 bg-gray-500 text-white rounded hover:bg-gray-700 mr-2"
                        onclick="toggleModal()"><i class="fas fa-times"></i> Fechar</button>
                    <button type="button" onclick="onSubmit()"
                        class="py-2 px-4 bg-blue-500 text-white rounded font-medium hover:bg-blue-700 mr-2 transition duration-500"><i
                            class="fas fa-plus"></i> Carregar</button>
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

    function toggleModal(id) {
        document.getElementById('modal').classList.toggle('hidden');
        document.getElementById('request_id_in').value = id;
    }

    function onSubmit() {
        document.getElementById('dischargeForm').submit();
    }
</script>
