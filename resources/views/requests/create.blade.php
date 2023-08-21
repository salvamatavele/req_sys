<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black-800 leading-tight">
            {{ 'Dar entrada do documento' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-black-900 ">
                    @include('components.flash')
                    <form class="w-full" method="POST" action="{{ route('requests.store') }}" enctype="multipart/form-data">
                        @csrf
                        <legend class="mb-3 text-yellow-900">Preencha os campos abaixo para dar entrada do pedido.
                            Por favor tenha muito cuidado ao preencher os compos e tenha certeza que os dados estejam corretos.</legend>
                        <div>
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full px-3">
                                    <label class="block uppercase tracking-wide text-black-700 text-xs font-bold mb-2"
                                        for="grid-doc_name">
                                        Nome do documento
                                    </label>
                                    <input
                                        class="appearance-none block w-full text-black-700 border border-black-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-black-500"
                                        id="grid-doc_name" type="text" name="doc_name" value="{{ old('doc_name') }}">
                                    <x-input-error :messages="$errors->get('doc_name')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-black-700 text-xs font-bold mb-2" for="grid-contact">
                                    Contacto
                                </label>
                                <input
                                    class="appearance-none block w-full text-black-700 border border-black-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-black-500"
                                    id="grid-contact" type="number" name="phone" value="{{ old('phone') }}">
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>
                        </div>
                        <h6 class="title-lines">Documento </h6>
                        <legend class="mb-3 text-yellow-900">Para carregar o documento, primeiro scannea o depois carregue usando o botão abaixo, apenas PDF.</legend>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label
                                    class="w-full flex flex-col items-center  text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer focus:outline-none focus:bg-white focus:border-black-500">
                                    <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path
                                            d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                    </svg>
                                    <span class="mt-2 text-base leading-normal">Selecione o documento para carregar em pdf</span>
                                    <input type='file' name="doc" class="hidden"
                                        accept="image/png, image/jpeg, image/jpg, .pdf" />
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('doc')" class="mt-2" />
                        </div>      
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="flex justify-end w-full px-3">
                                <button
                                    class="shadow bg-gray-600 hover:bg-gray-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-6 uppercase rounded"
                                    type="submit">
                                    Enviar
                                </button>
                            </div>
            
                        </div>
            
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
