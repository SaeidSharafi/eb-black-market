@props(['label', 'address', 'isMobile' => false])

<div x-data="copyToClipboard()" class="px-4 py-3">
    <p
        class="text-xs font-semibold text-gray-300{{
            $isMobile ? '' : ' mb-1'
        }}"
    >
        {{ $label }}:
    </p>
    <div class="relative{{ $isMobile ? ' mt-1' : '' }}">
        <input
            type="text"
            readonly
            x-ref="{{ strtolower($label) }}_address{{
                $isMobile ? '_mobile' : ''
            }}"
            value="{{ $address }}"
            class="w-full bg-gray-800 border-gray-600 text-gray-200 text-xs rounded-md shadow-sm pr-8{{
                $isMobile ? '' : ' py-2 px-3'
            }}"
        />
        <button
            @click="copy('{{ strtolower($label) }}_address{{
                $isMobile ? '_mobile' : ''
            }}', '{{ strtolower($label) }}_icon{{
                $isMobile ? '_mobile' : ''
            }}')"
            class="absolute inset-y-0 right-0 flex items-center pr-2"
            aria-label="Copy {{ $label }} address"
        >
            <svg
                x-ref="{{ strtolower($label) }}_icon{{
                    $isMobile ? '_mobile' : ''
                }}"
                class="h-4 w-4 text-gray-400 hover:text-white transition"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"
                />
            </svg>
        </button>
    </div>
</div>
