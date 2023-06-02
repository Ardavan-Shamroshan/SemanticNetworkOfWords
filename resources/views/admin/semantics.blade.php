<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $word->word }}  {{ __('Semantics') }}
        </h2>
    </x-slot>


   <div class="pt-2 pb-0 gap-4 px-4">
       <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
           بازگشت
       </a>
   </div>

    <div class="py-6 gap-4 px-4" dir="rtl">

        <div class="w-full">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-gray-500 text-right">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    #
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    کلمه
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    تکرار
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            {{--                            @forelse($semantics as $word)--}}
                            {{--                                <tr class="bg-white border-b ">--}}
                            {{--                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">--}}
                            {{--                                        {{ $loop->iteration }}--}}
                            {{--                                    </th>--}}

                            {{--                                    <td class="px-6 py-4 flex flex-row gap-4">--}}
                            {{--                                        {{ $word->semantic ?? '-' }}--}}
                            {{--                                    </td>--}}
                            {{--                                </tr>--}}
                            {{--                            @empty--}}
                            {{--                            @endforelse --}}
                            @forelse($duplicates as $word => $count)
                                <tr class="bg-white border-b ">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $loop->iteration }}
                                    </th>
                                    <td class="px-6 py-4 gap-4">
                                        {{ $word ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 gap-4">
                                        {{ $count ?? '-' }}  بار
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>
</x-app-layout>
