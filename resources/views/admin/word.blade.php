<x-app-layout>
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
                    </div>

                </div>
            </div>
        </div>

    </div>
</x-app-layout>
