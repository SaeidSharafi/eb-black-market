<div>
    @includeIf(data_get($setUp, 'header.includeViewOnTop'))

    <!-- Desktop Header Layout -->
    <div class="mb-3 hidden md:flex md:flex-row w-full justify-between items-center">
        <div class="md:flex md:flex-row w-full gap-1">
            <div x-data="pgRenderActions">
                <span class="pg-actions" x-html="toHtml"></span>
            </div>
            <div class="flex flex-row items-center text-sm flex-wrap">
                @if (data_get($setUp, 'exportable'))
                    <div
                        class="mr-2 mt-2 sm:mt-0"
                        id="pg-header-export"
                    >
                        @include(data_get($theme, 'root') . '.header.export')
                    </div>
                @endif
                @includeIf(data_get($theme, 'root') . '.header.toggle-columns')
                @includeIf(data_get($theme, 'root') . '.header.soft-deletes')
                @if (config('livewire-powergrid.filter') == 'outside' && count($this->filters()) > 0)
                    @includeIf(data_get($theme, 'root') . '.header.filters')
                @endif
            </div>
            @includeWhen(boolval(data_get($setUp, 'header.wireLoading')),
                data_get($theme, 'root') . '.header.loading')
        </div>
        @include(data_get($theme, 'root') . '.header.search')
    </div>

    <!-- Mobile FAB (Floating Action Button) -->
    <div
        x-data="{
            fabOpen: false,
            searchOpen: false,
            columnsOpen: false,
            filtersOpen: false,
            sortOpen: false
        }"
        class="md:hidden"
    >
        <!-- FAB Button -->
        <div class="fixed bottom-6 right-6 z-50 fab-menu-scroll">
            <button
                @click="fabOpen = !fabOpen"
                class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white rounded-full w-14 h-14 flex items-center justify-center shadow-lg transition-all duration-200 transform hover:scale-105"
                :class="{ 'rotate-45': fabOpen }"
            >
                <div x-show="!fabOpen">
                    <x-livewire-powergrid::icons.filter class="w-6 h-6" />
                </div>
                <div x-show="fabOpen">
                    <x-livewire-powergrid::icons.x class="w-6 h-6" />
                </div>
            </button>

            <!-- FAB Menu -->
            <div
                x-show="fabOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                class="absolute bottom-16 right-0 bg-white dark:bg-gray-900 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 p-4 w-80 max-w-[90vw] max-h-[80vh] overflow-y-auto"
                @click.outside="fabOpen = false"
            >
                <!-- Quick Actions Row -->
                <div class="flex flex-wrap gap-2 mb-4">
                    <!-- Move to Top -->
                    <button
                        onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
                        class="flex items-center gap-2 px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors"
                    >
                        <x-livewire-powergrid::icons.up class="w-4 h-4" />
                        <span>Top</span>
                    </button>

                    <!-- Reset All -->
                    <button
                        @if(count($enabledFilters ?? []) > 0)
                            wire:click="clearAllFilters"
                        @else
                            wire:click="$set('search', '')"
                        @endif
                        class="flex items-center gap-2 px-3 py-2 bg-red-100 dark:bg-red-900 rounded-lg text-sm text-red-700 dark:text-red-300 hover:bg-red-200 dark:hover:bg-red-800 transition-colors"
                    >
                        <x-livewire-powergrid::icons.x class="w-4 h-4" />
                        <span>Reset</span>
                    </button>
                </div>

                <!-- Search Section -->
                @if (data_get($setUp, 'header.searchInput'))
                    <div class="mb-4">

                        <div>
                            <div class="group relative mt-2">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 z-10">
                                    <x-livewire-powergrid::icons.search class="w-4 h-4 text-gray-400" />
                                </span>
                                <input
                                    wire:model.live.debounce.700ms="search"
                                    type="text"
                                    class="w-full pl-10 pr-10 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                    placeholder="{{ trans('livewire-powergrid::datatable.placeholders.search') }}"
                                >
                                @if ($search)
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 z-10">
                                        <button wire:click.prevent="$set('search','')" class="text-gray-400 hover:text-gray-600 transition-colors">
                                            <x-livewire-powergrid::icons.x class="w-4 h-4" />
                                        </button>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Column Sorting Section -->
                <div class="mb-4">
                    <button
                        @click="sortOpen = !sortOpen"
                        class="w-full text-left flex items-center justify-between py-2 text-sm font-semibold text-gray-700 dark:text-gray-300"
                    >
                        <div class="flex items-center gap-2">
                            <x-livewire-powergrid::icons.arrow class="w-4 h-4" />
                            Sort Columns
                        </div>
                        <x-livewire-powergrid::icons.chevron-down class="w-4 h-4 transition-transform" x-bind:class="sortOpen ? 'rotate-180' : ''" />
                    </button>
                    <div x-show="sortOpen" x-collapse>
                        <div class="mt-2 space-y-2 max-h-40 overflow-y-auto">
                            @foreach ($this->columns as $column)
                                @php
                                    $field = data_get($column, 'dataField', data_get($column, 'field'));
                                    $title = data_get($column, 'title');
                                    $sortable = data_get($column, 'sortable', false);
                                @endphp
                                @if ($field && !data_get($column, 'isAction') && $sortable)
                                    <button
                                        wire:click="sortBy('{{ $field }}')"
                                        class="w-full flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors"
                                    >
                                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $title }}</span>
                                        <div class="flex items-center">
                                            @if(isset($this->sortDirection[$field]))
                                                @if($this->sortDirection[$field] === 'asc')
                                                    <x-livewire-powergrid::icons.chevron-up class="w-4 h-4 text-blue-500" />
                                                @else
                                                    <x-livewire-powergrid::icons.chevron-down class="w-4 h-4 text-blue-500" />
                                                @endif
                                            @else
                                                <x-livewire-powergrid::icons.chevron-up-down class="w-4 h-4 text-gray-400" />
                                            @endif
                                        </div>
                                    </button>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Inline Filters Section -->
                @if (config('livewire-powergrid.filter') === 'inline' && count($this->filters()) > 0)
                    <div class="mb-4">
                        <button
                            @click="filtersOpen = !filtersOpen"
                            class="w-full text-left flex items-center justify-between py-2 text-sm font-semibold text-gray-700 dark:text-gray-300"
                        >
                            <div class="flex items-center gap-2">
                                <x-livewire-powergrid::icons.filter class="w-4 h-4" />
                                Filters
                            </div>
                            <x-livewire-powergrid::icons.chevron-down class="w-4 h-4 transition-transform" x-bind:class="filtersOpen ? 'rotate-180' : ''" />
                        </button>
                        <div x-show="filtersOpen" x-collapse>
                            <div class="mt-2 space-y-3 max-h-60 overflow-y-auto">
                                @foreach ($this->columns as $column)
                                    @php
                                        $filterClass = str(data_get($column, 'filters.className'));
                                        $field = data_get($column, 'dataField', data_get($column, 'field'));
                                        $title = data_get($column, 'title');
                                    @endphp
                                    @if ($filterClass->isNotEmpty() && $field && !data_get($column, 'isAction'))
                                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-2">{{ $title }}</label>
                                            @if ($filterClass->contains('FilterMultiSelect'))
                                                <x-livewire-powergrid::inputs.select
                                                    :table-name="$tableName"
                                                    :theme="$theme"
                                                    :title="data_get($column, 'title')"
                                                    :filter="(array) data_get($column, 'filters')"
                                                    :initial-values="data_get($filters, 'multi_select.' . data_get($column, 'dataField'))"
                                                />
                                            @elseif ($filterClass->contains(['FilterSelect', 'FilterEnumSelect']))
                                                @includeIf(theme_style($theme, 'filterSelect.view'), [
                                                    'inline' => true,
                                                    'filter' => (array) data_get($column, 'filters'),
                                                ])
                                            @elseif ($filterClass->contains('FilterInputText'))
                                                @includeIf(theme_style($theme, 'filterInputText.view'), [
                                                    'inline' => true,
                                                    'filter' => (array) data_get($column, 'filters'),
                                                ])
                                            @elseif ($filterClass->contains('FilterNumber'))
                                                @includeIf(theme_style($theme, 'filterNumber.view'), [
                                                    'inline' => true,
                                                    'filter' => (array) data_get($column, 'filters'),
                                                ])
                                            @elseif ($filterClass->contains('FilterDateTimePicker'))
                                                @includeIf(theme_style($theme, 'filterDatePicker.view'), [
                                                    'inline' => true,
                                                    'filter' => (array) data_get($column, 'filters'),
                                                    'type' => 'datetime',
                                                    'tableName' => $tableName,
                                                    'classAttr' => 'w-full',
                                                ])
                                            @elseif ($filterClass->contains('FilterDatePicker'))
                                                @includeIf(theme_style($theme, 'filterDatePicker.view'), [
                                                    'inline' => true,
                                                    'filter' => (array) data_get($column, 'filters'),
                                                    'type' => 'date',
                                                    'classAttr' => 'w-full',
                                                ])
                                            @elseif ($filterClass->contains('FilterBoolean'))
                                                @includeIf(theme_style($theme, 'filterBoolean.view'), [
                                                    'inline' => true,
                                                    'filter' => (array) data_get($column, 'filters'),
                                                ])
                                            @elseif ($filterClass->contains('FilterDynamic'))
                                                <x-dynamic-component
                                                    :component="data_get($column, 'filters.component')"
                                                    :attributes="new \Illuminate\View\ComponentAttributeBag(
                                                        data_get($column, 'filters.attributes', []),
                                                    )"
                                                />
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Outside Filters Section -->
                @if (config('livewire-powergrid.filter') == 'outside' && count($this->filters()) > 0)
                    <div class="mb-4">
                        <button
                            wire:click="toggleFilters"
                            class="flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors w-full justify-center"
                        >
                            <x-livewire-powergrid::icons.filter class="w-4 h-4" />
                            <span>Toggle Filters</span>
                        </button>
                    </div>
                @endif

                <!-- Active Filters Display -->
                @if (count($enabledFilters ?? []) > 0)
                    <div class="mb-4">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Active Filters</h4>
                        <div class="space-y-2">
                            @foreach ($enabledFilters as $filter)
                                @isset($filter['label'])
                                    <div class="flex items-center justify-between p-2 bg-blue-50 dark:bg-blue-900 rounded-lg">
                                        <span class="text-sm text-blue-700 dark:text-blue-300">{{ $filter['label'] }}</span>
                                        <button
                                            wire:click.prevent="clearFilter('{{ $filter['field'] }}')"
                                            class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-200"
                                        >
                                            <x-livewire-powergrid::icons.x class="w-4 h-4" />
                                        </button>
                                    </div>
                                @endisset
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Column Toggle Section -->
                @if (data_get($setUp, 'header.toggleColumns'))
                    <div class="mb-4">
                        <button
                            @click="columnsOpen = !columnsOpen"
                            class="w-full text-left flex items-center justify-between py-2 text-sm font-semibold text-gray-700 dark:text-gray-300"
                        >
                            <div class="flex items-center gap-2">
                                <x-livewire-powergrid::icons.eye-off class="w-4 h-4" />
                                Toggle Columns
                            </div>
                            <x-livewire-powergrid::icons.chevron-down class="w-4 h-4 transition-transform" x-bind:class="columnsOpen ? 'rotate-180' : ''" />
                        </button>
                        <div x-show="columnsOpen" x-collapse>
                            <div class="mt-2 space-y-2 max-h-48 overflow-y-auto">
                                @foreach ($this->columns as $column)
                                    @php
                                        $field = data_get($column, 'dataField', data_get($column, 'field'));
                                        $title = data_get($column, 'title');
                                    @endphp
                                    @if ($field && !data_get($column, 'isAction'))
                                        <label class="flex items-center p-2 hover:bg-gray-100 dark:hover:bg-gray-600 rounded cursor-pointer transition-colors">
                                            <input
                                                type="checkbox"
                                                wire:click="toggleColumn('{{ $field }}')"
                                                @if(!data_get($column, 'hidden')) checked @endif
                                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                            >
                                            <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">{{ $title }}</span>
                                        </label>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Export Section -->
                @if (data_get($setUp, 'exportable'))
                    <div class="pt-3 border-t border-gray-200 dark:border-gray-600">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center gap-2">
                            <x-livewire-powergrid::icons.download class="w-4 h-4" />
                            Export
                        </h4>
                        <div class="w-full">
                            @include(data_get($theme, 'root') . '.header.export')
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @includeIf(data_get($theme, 'root') . '.header.enabled-filters')

    @includeWhen(data_get($setUp, 'exportable.batchExport.queues', 0), data_get($theme, 'root') . '.header.batch-exporting')
    @includeWhen($multiSort, data_get($theme, 'root') . '.header.multi-sort')
    @includeIf(data_get($setUp, 'header.includeViewOnBottom'))
    @includeIf(data_get($theme, 'root') . '.header.message-soft-deletes')
</div>
