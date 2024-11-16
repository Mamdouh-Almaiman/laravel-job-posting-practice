@if (session()->has('message'))
    {{-- I used alpine.js to be able to make the massage interactive (stays for 3 secs only) --}}
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
        class="fixed top-0 left-1/2 transform -translate-x-1/2 bg-laravel text-white px-48 py-3">
        <P>{{ session('message') }}</P>
    </div>
@endif
