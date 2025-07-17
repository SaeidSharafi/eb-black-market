<div class="flex rounded-md relative">
    <div class="flex items-center">
        <div class="px-2">
            <div class="h-8 w-8">
                <img src="{{ url('/storage/'.$image.'') }}" alt="{{ $name }}" role="img" class="h-full w-full rounded-full overflow-hidden shadow object-cover" />
            </div>
        </div>

        <div class="flex flex-col justify-center pl-3 py-2">
            <p class="text-sm font-bold pb-1">{{ $name }}</p>
        </div>
    </div>
</div>
