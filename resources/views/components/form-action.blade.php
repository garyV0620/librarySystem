@props(['action', 'label', 'method' => 'POST', 'otherMethod' => ''])

@php

$classes = ($label == 'Enable' || $label == 'Update' || $label == 'Borrow')
            ? 'px-4 py-1 text-sm text-blue-600 bg-blue-300 rounded '
            : 'px-4 py-1 text-sm text-red-600 bg-red-300 rounded';
// if($label == 'Update'){
//     $classes = 'px-4 py-1 text-sm text-blue-600 bg-blue-300 rounded ';
// }
@endphp

<form class="form-action" method="{{ $method }}" action="{{ $action }}"  data-label="{{ $label }}" >
    @csrf
    @method($otherMethod)
    
    <button type="submit"  {{ $attributes->merge(['class' => $classes]) }}>{{ $label }}</button>
</form>