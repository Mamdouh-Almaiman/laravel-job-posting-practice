<div {{ $attributes->merge(['class' => 'bg-gray-50 border border-gray-200 rounded p-6']) }}>
    {{ $slot }} {{-- slot is used if you want to srround things with the component tag --}}
</div>


