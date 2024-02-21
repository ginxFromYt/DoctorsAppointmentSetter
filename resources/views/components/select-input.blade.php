<!-- resources/views/components/select-input.blade.php -->

@props(['options', 'selected', 'placeholder' => null])

<select {{ $attributes->merge(['class' => 'form-select']) }}>
    @if($placeholder)
        <option value="" disabled {{ !$selected ? 'selected' : '' }}>{{ $placeholder }}</option>
    @endif
    @foreach($options as $option)
        <option value="{{ $option }}" {{ $selected == $option ? 'selected' : '' }}>{{ $option }}</option>
    @endforeach
</select>
