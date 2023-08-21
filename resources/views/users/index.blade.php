<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black-800 leading-tight">
            {{ 'Usuários' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-white-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-black-900 dark:text-black-100">
                    @include('components.flash')
                    <div class="flex justify-end">
                        <a href="{{ route('users.create') }}"
                            class="bg-gray-500 text-white p-2 mb-5 rounded hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-gray-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-gray-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]">Registar
                            Usuário</a>
                    </div>
                    <table id="users_id" class="hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Departamento</th>
                                <th>Registado aos</th>
                                <th>Actualizado aos</th>
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
                                    <td>{{ $user->created_at }}</td>
                                    <td>{{ $user->updated_at }}</td>
                                    <td class="display flex-grow">
                                        <a href="{{ route('users.edit', $user->id) }}" title="Editar"
                                            class="text-primary transition duration-150 ease-in-out hover:text-primary-600 focus:text-primary-600 active:text-primary-700">
                                            <i class="fa-solid fa-pen text-blue-400"></i>
                                        </a>
                                        &nbsp;
                                        <form action="{{ route('users.destroy',$user->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button title="Apagar" onclick="return confirm('{{ __('Delete Account') }}?')"
                                                class="text-secondary transition duration-150 ease-in-out hover:text-secondary-600 focus:text-secondary-600 active:text-secondary-700">
                                                <i class="fa-solid fa-trash text-red-500"></i>
                                            </button>

                                        </form>
                                    </td>
                                </tr>
                            @empty
                            <tr><td colspan="6">{{ "Nenhum registo encontrado." }}</td></tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Departamento</th>
                                <th>Registado aos</th>
                                <th>Actualizado aos</th>
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
        var table = new DataTable('#users_id', {
            language: {
                url: "{{ asset('DataTables/pt-PT.json') }}",
            },
        });
    });
</script>
