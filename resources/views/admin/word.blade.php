<x-app-layout xmlns="http://www.w3.org/1999/html">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Word') }}
        </h2>
    </x-slot>

    <div class="py-12 flex flex-row gap-4 px-4" dir="rtl">
        <div class="w-ful">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="relative overflow-x-auto">
                        <div class="flex items-center justify-end mb-4">
                            <x-nav-link href="{{ route('admin.export') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                                </svg>
                                    {{ __('بارگیری') }}
                            </x-nav-link>
                        </div>
                        <table class="w-full text-sm text-gray-500 text-right">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    کلمه
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    تعداد شبکه های معنایی
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    بیشترین تکرار تناسب
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    عملیات
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            @forelse($words as $word)
                                @php
                                    $semantics = $word->semantics;

                                    $duplicates = [];
                                    foreach ($semantics as $semantic) {
                                        $duplicates[] = $semantic->semantic;
                                    }
                                    $duplicates = array_count_values($duplicates);
                                    $max = 0;
                                    if(!empty($duplicates))
                                        $max = max($duplicates);
                                        $key = array_search($max, $duplicates);
                                @endphp

                                <tr class="bg-white border-b ">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $word->word ?? '-' }}
                                    </th>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('admin.word.semantic.index', $word) }}">{{ $word->semantics()->count() }}</a>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $key ? $key : '-' }}
                                    </td>
                                    <td class="px-6 py-4 flex flex-row gap-4">
                                        <a href="{{ route('admin.word.semantic.index', $word) }}"
                                           class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">تناسب
                                            ها</a>
                                        <form action="{{ route('admin.word.destroy', $word) }}" method="post">
                                            @csrf @method('delete')
                                            <x-danger-button>پاک کردن</x-danger-button>
                                        </form>
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
        <div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="relative overflow-x-auto">
                        <form method="POST" action="{{ route('admin.word.store') }}">
                            @csrf
                            <!-- Email Address -->
                            <div>
                                <x-input-label for="word" :value="__('کلمه')"/>
                                <x-text-input id="word" class="block mt-1 w-full" type="text" name="word" :value="old('word')" required autofocus/>
                                <x-input-error :messages="$errors->get('word')" class="mt-2"/>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <x-primary-button>
                                    {{ __('ساخت') }}
                                </x-primary-button>
                            </div>
                        </form>


                        <form method="POST" action="{{ route('admin.word.store-file') }}" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <label class="text-sm font-medium text-gray-900 block mb-2" for="user_avatar">{{ __('بارگزاری فایل excel') }}</label>
                                <input class="block w-full cursor-pointer bg-gray-50 border border-gray-300 text-gray-900 focus:outline-none focus:border-transparent text-sm rounded-lg" aria-describedby="user_avatar_help" id="user_avatar" type="file" name="file" required>
                                <div class="mt-1 text-sm text-gray-500" id="user_avatar_help">میتوانید کلمات خود را از طریق یک فایل اکسل بصورت یکجا بارگزاری کنید</div>
                            </div>

                            <div class="flex items-center justify-end mt-4">

                                <x-secondary-button type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 7.5h-.75A2.25 2.25 0 004.5 9.75v7.5a2.25 2.25 0 002.25 2.25h7.5a2.25 2.25 0 002.25-2.25v-7.5a2.25 2.25 0 00-2.25-2.25h-.75m0-3l-3-3m0 0l-3 3m3-3v11.25m6-2.25h.75a2.25 2.25 0 012.25 2.25v7.5a2.25 2.25 0 01-2.25 2.25h-7.5a2.25 2.25 0 01-2.25-2.25v-.75" />
                                    </svg>

                                    {{ __('بارگزاری') }}
                                </x-secondary-button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>

    </div>
</x-app-layout>
