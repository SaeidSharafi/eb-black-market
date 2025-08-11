<x-filament-widgets::widget>
    <x-filament::section>
        @if($connectUrl)
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div>
                        <svg class="h-6 w-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                    </div>
                    <div class="text-sm">
                        <p class="font-medium">{{__('resources.filament-widgets.connect-telegram-banner.title')}}</p>
                        <p class="text-gray-500">
                            {{__('resources.filament-widgets.connect-telegram-banner.description')}}
                        </p>
                    </div>
                </div>

                <a href="{{ $connectUrl }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    {{__('resources.filament-widgets.connect-telegram-banner.connect')}}
                    <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 6.75l6 6m0 0l-6 6m6-6H3" />
                    </svg>
                </a>
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
