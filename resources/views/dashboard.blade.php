<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-light leading-tight">
            {{__('Podaj hasło główne')}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (!auth()->user()->master_password)
                    <div class="p-4 bg-info border-b sm:rounded-lg">
                        <span class="text-black">
                             Nie posiadasz zapisanego hasła głównego. Wprowadzone hasło będzie twoim hasłem głównym.
                        </span>
                    </div>
                    @endif
                    <form method="POST">
                        @csrf
                        <div class="mt-4">
                            <x-label for="master_password" :value="__('Hasło główne')" />

                            <x-input id="master_password" class="block mt-1 w-25"
                                     type="password" name="master_password" required  />
                        </div>
                        <div class="mt-4">
                            <x-button class="ml-3">
                                {{ __('Wyślij') }}
                            </x-button>
                        </div>
                        @if (session()->get('error'))
                            <div class="mt-4">
                                <div class="p-2 bg-danger border-b sm:rounded-lg">
                                    <span>Password is wrong!</span>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
