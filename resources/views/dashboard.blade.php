<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
                <div class="p-6 text-gray-900">
                    {{ __("Welcome") }} {{ auth()->user()->name }}  {{ __("You're logged in!") }}
                    @admin
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Visit admin dashboard</a>
                    @endadmin

                    <a href="{{ route('semantic-network.index') }}" class=" ml-72 inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-md text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">   {{ __('شروع') }}</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
