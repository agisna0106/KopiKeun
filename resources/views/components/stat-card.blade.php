@props([
    'title',
    'value' => '0',
    'description' => null,
])

<div class="rounded-2xl border border-stone-200 bg-white p-4 shadow-sm">

    <div class="text-sm font-medium text-stone-500">
        {{ $title }}
    </div>

    <div class="mt-2 text-2xl font-bold text-stone-900">
        {{ $value }}
    </div>

    @if($description)
        <div class="mt-1 text-xs text-stone-500">
            {{ $description }}
        </div>
    @endif

</div>