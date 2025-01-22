<?php extract(collect($attributes->getAttributes())->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>
@props(['id'])
<x-tables::modal.heading :id="$id" >

{{ $slot ?? "" }}
</x-tables::modal.heading>