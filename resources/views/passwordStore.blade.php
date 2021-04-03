<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-light leading-tight">
            @isset($passModel)
                {{ __('Edytuj istniejące hasło') }}
            @else
                {{ __('Dodaj nowe hasło') }}
            @endisset
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{route('password.store')}}" >
                        @csrf

                        @isset($passModel)
                            <x-input type="hidden" name="id" id="id" value="{{$passModel->id}}" />
                        @endisset

                        <div class="grid grid-cols-2 gap-2">
                            <div class="mt-8">
                                <x-label for="login" :value="__('Login')"/>

                                <x-input id="login" class="block mt-1 w-full"
                                         type="text" name="login"
                                         value="{{$passModel->login ?? ''}}" />
                            </div>
                            <div class="mt-8">
                                <x-label for="password" :value="__('Hasło')"/>

                                <x-input id="password" class="block mt-1 w-full"
                                         type="password" name="password" required
                                         value="{{$passModel->password ?? ''}}" />
                            </div>
                        </div>
                        <div class="mt-8">
                            <x-label for="web_address" :value="__('Adres witryny')"/>

                            <x-input id="web_address" class="block mt-1 w-full"
                                     type="text" name="web_address" required
                                     value="{{$passModel->web_address ?? ''}}" />
                        </div>
                        <div class="mt-8">
                            <x-label for="description" :value="__('Opis')"/>

                            <x-input id="description" class="block mt-1 w-full"
                                     type="text" name="description"
                                     value="{{$passModel->description ?? ''}}" />
                        </div>
                        <div class="mt-8">
                            <x-button class="ml-3">
                                {{ __('Zapisz') }}
                            </x-button>
                        </div>

                        @if(session('error'))
                            <div class="mt-8">
                               <div class="p4">
                                   Przepraszamy coś poszło nie tak
                               </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
