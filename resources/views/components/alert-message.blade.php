@props(['message' => ''])

<div x-data="{ showMessage: true }" x-show="showMessage" x-init="setTimeout(() => showMessage = false, 3000)">
	@if ($message != '')
	<div class="p-3 text-center max-w-7xl mx-auto my-2 text-green-700 bg-green-200 rounded">
		{{ $message }}
	</div>
	@endif

	@if (session()->has('error'))
		<div class="p-3 text-center max-w-7xl mx-auto my-2 text-red-700 bg-red-200 rounded">
			{{ session()->get('error') }}
		</div>
	@endif
</div>