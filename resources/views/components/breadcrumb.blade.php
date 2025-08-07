@props(['items' => []])
@if(!empty($items))
<nav aria-label="Breadcrumb" class="bg-gray-800/50 py-2">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <ol
            class="flex items-center space-x-2 text-sm"
            itemscope
            itemtype="https://schema.org/BreadcrumbList"
        >
            @foreach($items as $index => $item)
            <li
                itemprop="itemListElement"
                itemscope
                itemtype="https://schema.org/ListItem"
            >
                @if($loop->last)
                <span
                    class="text-gray-400"
                    aria-current="page"
                    itemprop="name"
                    >{{ $item["name"] }}</span
                >
                <meta itemprop="position" content="{{ $index + 1 }}" />
                @else
                <a
                    href="{{ $item['url'] }}"
                    class="text-yellow-400 hover:text-yellow-300 transition"
                    itemprop="item"
                >
                    <span itemprop="name">{{ $item["name"] }}</span>
                </a>
                <meta itemprop="position" content="{{ $index + 1 }}" />
                <svg
                    class="w-4 h-4 text-gray-500 mx-2"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    aria-hidden="true"
                >
                    <path
                        fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd"
                    />
                </svg>
                @endif
            </li>
            @endforeach
        </ol>
    </div>
</nav>
@endif
