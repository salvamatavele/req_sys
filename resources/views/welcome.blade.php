@extends('layouts.main')
@section('main')
    <div class="hero-bg flex items-center justify-center text-center">
        <div
            class="bg-yellow-600 bg-opacity-60 w-50 text-white rounded-md w-100 m-5 p-5 sm:m-10 sm:p-10 md:max-w-xl lg:rounded-lg">
            <h1 class="font-bold text-xl mb-2 md:mb-4 md:text-3xl">Sistema de Pedido de Declarações e Certificados</h1>
            <p>Seja bem vindo/a, requisite a sua declaração ou certificado sem precisar se deslocar para sua escola, a qualquer lugar em
                qualquer momento.</p>
            <a href="{{ route('request.create') }}"
                class="bg-gray-800 text-white uppercase py-2 px-7 mt-5 rounded-full inline-block sm:mt-8 text-sm tracking-wider">Fazer
                Pedido</a>
        </div>

    </div>

    <!--Container-->
    <section id="contact">
        <div class="max-w-screen-md mx-auto p-5">
            <div class="text-center mb-16">
                <p class="mt-4 text-sm leading-7 text-gray-500 font-regular uppercase">
                    Contacte-nos
                </p>
                @include('components.message')
            </div>

            <form class="w-full" method="POST" action="{{ route('send_message') }}">
                @csrf
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            for="grid-first-name">
                            Primeiro Nome
                        </label>
                        <input
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                            id="grid-first-name" type="text" placeholder="Nome" name="name"
                            value="{{ old('name') }}">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            for="grid-last-name">
                            Apelido
                        </label>
                        <input
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="grid-last-name" type="text" placeholder="Apelido" name="last_name"
                            value="{{ old('last_name') }}">
                        <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
                            Selecione o mecanismo que pretende usar para receber os nossos feedbacks.
                        </label>

                        <div class="flex items-center mb-4">
                            <input id="checkbox" type="checkbox" name="reply_email" checked
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox"
                                class="ml-2 text-sm font-medium text-gray-400 dark:text-gray-500">Atraves do email</label>
                        </div>
                        <div class="flex items-center">
                            <input  id="checked-checkbox" type="checkbox" name="reply_sms"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checked-checkbox"
                                class="ml-2 text-sm font-medium text-gray-400 dark:text-gray-500">Atraves do SMS</label>
                        </div>

                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            for="grid-password">
                            Email
                        </label>
                        <input
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="grid-email" type="email" placeholder="********@*****.**" name="email"
                            value="{{ old('email') }}">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            for="grid-contact">
                            Contacto
                        </label>
                        <input
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="grid-contact" type="number" placeholder="Contacto" name="contacto"
                            value="{{ old('contacto') }}">
                        <x-input-error :messages="$errors->get('contacto')" class="mt-2" />
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            for="grid-password">
                            Sua Mensagem
                        </label>
                        <textarea rows="10" name="message" placeholder="Detalhe a sua mensagem aqui, e se precisar de ser contactado inclua os seus contactos."
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"></textarea>
                        <x-input-error :messages="$errors->get('message')" class="mt-2" />
                    </div>
                    <div class="flex justify-end w-full px-3">
                        <button
                            class="shadow bg-indigo-600 hover:bg-indigo-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-6 rounded"
                            type="submit">
                            Enviar
                        </button>
                    </div>

                </div>

            </form>
        </div>
    </section>
@endsection
