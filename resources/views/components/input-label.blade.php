@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-viridian dark:text-greenLight']) }}>
    {{ $value ?? $slot }}
</label>
