@props(["type" => "button", "color" => "primary"])
@php
    $colors = [
        'primary' => 'bg-blue-600 hover:bg-blue-700 text-white',
        'secondary' => 'bg-gray-600 hover:bg-gray-700 text-white',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white',
        'success' => 'bg-green-600 hover:bg-green-700 text-white',
    ];
    $class = $colors[$color] ?? $colors['primary'];
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => "px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 $class"]) }}>
    {{ $slot }}
</button>