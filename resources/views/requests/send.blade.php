<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black-800  leading-tight relative">
            <a class="btn-link text-blue-400" href="{{ route('requests.index') }}">Requerimento</a> > Enviar ao departamento
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
                                <th>#</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Departamento</th>
                                <th>Pendentes</th>
                                <th>Accao</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->role == 0)
                                        <span>Administrador</span>
                                        @elseif ($user->role == 1)
                                        <span>Secretaria</span>
                                        @elseif ($user->role == 2)
                                        <span>Departamento de Estatistica Economicas</span>
                                        @else
                                        <span>Gabinete</span> 
                                        @endif
                                    </td>
                                    <td>{{ sizeof($user->requests) }}</td>
                                    <td class="display flex-grow">
                                        <form action="{{ route('requests.store_send') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                            <input type="hidden" name="request_id" value="{{ $request_id }}">
                                            <button title="submeter" onclick="return confirm('{{'Tem certeza que pretende enviar o documento a este departamento' }}?')"
                                                class="text-secondary transition duration-150 ease-in-out hover:text-secondary-600 focus:text-secondary-600 active:text-secondary-700">
                                                <i class="fa-solid fa-plus" style="color: #24498a;"></i>
                                            </button>

                                        </form>
                                    </td>
                                </tr>
                            @empty
                            <tr><td colspan="6">{{ "Nenhum registo encontrado." }}</td></tr>
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
