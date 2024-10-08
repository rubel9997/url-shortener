<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('urls.store') }}">
                    @csrf
                    <!-- Title Input -->
                        <div>
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                    <!-- Long URL Input -->
                        <div class="mt-4">
                            <x-input-label for="long_url" :value="__('Long Url')" />
                            <x-text-input id="long_url" class="block mt-1 w-full" type="text" name="long_url" :value="old('long_url')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('long_url')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-start mt-4">
                            <x-primary-button>
                                {{ __('Save') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($urls->isNotEmpty())
                        <table class="min-w-full bg-white dark:bg-gray-800">
                            <thead>
                            <tr>
                                <th class="border px-4 py-2">{{ __('Title') }}</th>
                                <th class="border px-4 py-2">{{ __('Long URL') }}</th>
                                <th class="border px-4 py-2">{{ __('Short URL') }}</th>
                                <th class="border px-4 py-2">{{ __('Visit Count') }}</th>
                                <th class="border px-4 py-2">{{ __('Created At') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($urls as $url)
                                <tr>
                                    <td class="border px-4 py-2">{{ $url->title }}</td>
                                    <td class="border px-4 py-2">{{ $url->long_url }}</td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('short_code', $url->short_code) }}" target="_blank">{{ route('short_code', $url->short_code) }}</a>
                                    </td>
                                    <td class="border px-4 py-2">{{ $url->visits }}</td>
                                    <td class="border px-4 py-2">{{ $url->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>{{ __('No URLs generated yet.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
