<x-app-layout>
    <x-slot name="header">
        <div class="w-25 float-right">
            <x-button name="changeMode" id="changeMode" data-mode="read">Read Mode</x-button>
        </div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight bg-dark text-light w-75">
            {{ __('Zapisane hasła') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{ $table }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
