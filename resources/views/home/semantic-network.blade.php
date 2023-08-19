<x-app-layout>
    @push('head-tag')
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>

        <style>
            [x-cloak] {
                display: none;
            }

            [type="checkbox"] {
                box-sizing: border-box;
                padding: 0;
            }

            .form-checkbox,
            .form-radio {
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
                display: inline-block;
                vertical-align: middle;
                background-origin: border-box;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                flex-shrink: 0;
                color: currentColor;
                background-color: #fff;
                border-color: #e2e8f0;
                border-width: 1px;
                height: 1.4em;
                width: 1.4em;
            }

            .form-checkbox {
                border-radius: 0.25rem;
            }

            .form-radio {
                border-radius: 50%;
            }

            .form-checkbox:checked {
                background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M5.707 7.293a1 1 0 0 0-1.414 1.414l2 2a1 1 0 0 0 1.414 0l4-4a1 1 0 0 0-1.414-1.414L7 8.586 5.707 7.293z'/%3e%3c/svg%3e");
                border-color: transparent;
                background-color: currentColor;
                background-size: 100% 100%;
                background-position: center;
                background-repeat: no-repeat;
            }

            .form-radio:checked {
                background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3ccircle cx='8' cy='8' r='3'/%3e%3c/svg%3e");
                border-color: transparent;
                background-color: currentColor;
                background-size: 100% 100%;
                background-position: center;
                background-repeat: no-repeat;
            }
        </style>
    @endpush
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Welcome") }} {{ auth()->user()->name }}  {{ __("You're logged in!") }}
                    @admin
                    <a href="{{ route('admin.dashboard') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Visit
                        admin dashboard</a>
                    @endadmin
                </div>
            </div>
        </div>
    </div>

    <div class="w-3/4 mx-auto sm:px-6 lg:px-8 pb-8 text-center">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="text-gray-900">
                <div class="container flex flex-col flex-wrap px-5 mx-auto">
                    <div x-data="app()" x-cloak>
                        <div class="max-w-3xl mx-auto px-4 py-8">

                            {{-- success alert --}}

                            <div x-show.transition="step == 'complete'">
                                <div class="bg-white rounded-lg p-10 flex items-center shadow justify-between">
                                    <div>
                                        <svg class="mb-4 h-20 w-20 text-green-500 mx-auto" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>

                                        @if($words->isNotEmpty())
                                            <h2 class="text-2xl mb-4 text-gray-800 text-center font-bold">ثبت کلمات با موفقیت انجام شد</h2>

                                            <div class="text-gray-600 mb-8">
                                                از شما ممنونیم که مارا انتخاب کردید
                                            </div>

                                            <a
                                                    href="{{ route('semantic-network.index') }}"
                                                    class="w-40 block mx-auto focus:outline-none py-2 px-5 rounded-lg shadow-sm text-center text-gray-600 bg-white hover:bg-gray-100 font-medium border"
                                            >شروع دوباره
                                            </a>

                                        @else
                                            <h2 class="text-2xl mb-4 text-gray-800 text-center font-bold">کلمه ای برای نمایش وجود ندارد</h2>
                                            <div class="text-gray-600 mb-8">
                                                از اینکه این بازی را به اتمام رساندید به شما تبریک میگوییم
                                            </div>
                                            <a
                                                    href="{{ route('detach-all') }}"
                                                    class="w-40 block mx-auto focus:outline-none py-2 px-5 rounded-lg shadow-sm text-center text-gray-600 bg-white hover:bg-gray-100 font-medium border"
                                            >شروع دوباره
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div x-show.transition="step != 'complete'">
                                <!-- Top Navigation -->
                                <div class="border-b-2 py-4">
                                    <div class="uppercase tracking-wide text-xs font-bold text-gray-500 mb-1 leading-tight" x-text="`کلمه: ${step} از 5`"></div>
                                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                        <div class="flex-1">
                                            @forelse($words as $word)
                                                <div x-show="step === {{ $loop->iteration }}">
                                                    <div class="text-3xl font-bold text-gray-700 leading-tight">{{ $word->word }} </div>
                                                    {{--                                                    <small>دفعات نمایش [{{ $word->showed }}]</small>--}}
                                                </div>
                                            @empty
                                                <div x-show="step = 'complete'"></div>
                                            @endforelse
                                        </div>

                                        <div class="flex items-center md:w-64">
                                            <div class="w-full bg-white rounded-full mr-2">
                                                <div class="rounded-full bg-green-500 text-xs leading-none h-2 text-center text-white" :style="'width: '+ parseInt(step / 5 * 100) +'%'"></div>
                                            </div>
                                            <div class="text-xs w-10 text-gray-600" x-text="parseInt(step / 5 * 100) +'%'"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Top Navigation -->

                                <!-- Step Content -->
                                <div class="py-10">
                                    <form action="{{ route('semantic-network.store') }}" method="post">
                                        @foreach($words as $word)
                                            <div x-show.transition.in="step === {{ $loop->iteration }}">
                                                @csrf
                                                <div class="flex flex-wrap gap-4 mb-6">
                                                    @for($i = 0; $i <= 5; $i++)
                                                        <input type="text" name="{{$word->word}}[]" id="semantic" class="block py-2.5 px-7 text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600"/>
                                                    @endfor
                                                </div>
                                            </div>
                                        @endforeach


                                        <div class="flex justify-between">
                                            <div class="w-1/2">
                                                <button
                                                        type="button"
                                                        x-show="step > 1"
                                                        @click="step--"
                                                        class="w-32 focus:outline-none py-2 px-5 rounded-lg shadow-sm text-center text-gray-600 bg-white hover:bg-gray-100 font-medium border"
                                                >قبل
                                                </button>
                                            </div>

                                            <div class="w-1/2 text-right">
                                                <button
                                                        type="button"
                                                        x-show="step < 5"
                                                        @click="step++"
                                                        class="w-32 focus:outline-none border border-transparent py-2 px-5 rounded-lg shadow-sm text-center text-white bg-blue-500 hover:bg-blue-600 font-medium"
                                                >بعدی
                                                </button>
                                            </div>
                                        </div>

                                        <x-primary-button>
                                            {{ __('ذخیره') }}
                                        </x-primary-button>
                                    </form>
                                    @foreach($errors->all() as $error)
                                        {{ $error }}
                                    @endforeach
                                </div>
                                <!-- / Step Content -->
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        function app() {
            @if(Session::has('step') && Session::get('step') == 'complete')
                return {step: 'complete'}
            @else
                return {step: 1}
            @endif
        }
    </script>
</x-app-layout>
