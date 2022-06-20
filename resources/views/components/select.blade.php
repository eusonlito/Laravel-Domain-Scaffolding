@if ($label)
<label for="{{ $id }}" class="form-label">{{ $label }}</label>
@endif

<select {{ $attributes->merge(['id' => $id, 'name' => $name]) }} class="form-select form-control">
    @foreach ($options as $each)
    <option value="{{ $each['value'] }}" {{ $each['selected'] ? 'selected' : '' }} {!! $each['attributes'] ?? '' !!}>{{ $each['text'] }}</option>
    @endforeach
</select>
