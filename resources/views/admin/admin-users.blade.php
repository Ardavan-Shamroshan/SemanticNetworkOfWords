<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ثبت کاربر ادمین') }}
        </h2>
    </x-slot>

    <div class="py-12 flex flex-row gap-4 px-4" dir="rtl">
        <div class="w-3/4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" dir="rtl">
                <div class="p-6 text-gray-900">
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-gray-500 text-right">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    نام
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    ایمیل
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    ایجاد شده
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    عملیات
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            @forelse($adminUsers as $admin)
                                <tr class="bg-white border-b ">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $admin->name ?? '-' }}</th>
                                    <td class="px-6 py-4">{{ $admin->email ?? '' }}</td>
                                    <td class="px-6 py-4">{{ $admin->created_at->diffForHumans() ?? '' }}</td>
                                    <td class="px-6 py-4 flex flex-row gap-4 text-start">
{{--                                        <a href="{{ route('admin.register-admin-user.edit', $admin) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">ویرایش</a>--}}
                                        <form action="{{ route('admin.register-admin-user.destroy', $admin) }}" method="post" onsubmit="return confirm('آیا از پاک کردن ادمین مورد نظر اطمینان دارید؟')">
                                            @csrf @method('delete')
                                            <x-danger-button>پاک کردن</x-danger-button>

                                        </form>
                                    </td>
                                </tr>
                                @if (session('status') === "admin-destroyed")
                                    <span
                                            x-data="{ show: true }"
                                            x-show="show"
                                            x-transition
                                            x-init="setTimeout(() => show = false, 2000)"
                                            class="text-sm text-gray-600"
                                    >{{ __("پاک شد.")}}</span>
                                @elseif(session('status') === "admin-created")
                                    <span
                                            x-data="{ show: true }"
                                            x-show="show"
                                            x-transition
                                            x-init="setTimeout(() => show = false, 2000)"
                                            class="text-sm text-gray-600"
                                    >{{ __("ثبت شد.")}}</span>
                                @endif

                            @empty
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-5 py-3">
            <section>
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('ثبت کاربر ادمین جدید') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __("میتوانید کاربر ادمین جدیدی از این قسمت ایجاد کنید.") }}
                    </p>
                </header>

                <form method="post" action="{{ route('admin.register-admin-user.store') }}" class="mt-6 space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('نام')"/>
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus/>
                        <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('ایمیل')"/>
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required/>
                        <x-input-error class="mt-2" :messages="$errors->get('email')"/>
                    </div>

                    <div>
                        <x-input-label for="password" :value="__(' کلمه عبور')"/>
                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full"/>
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2"/>
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" :value="__('تکرار کلمه عبور')"/>
                        <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full"/>
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2"/>
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('ثبت') }}</x-primary-button>
                    </div>
                </form>
            </section>


        </div>

    </div>
</x-app-layout>
