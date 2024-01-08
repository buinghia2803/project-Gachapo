<div class="row">
    <div class="form-group col-12 col-xl-9">
        <div class="row d-flex align-items-baseline">
            <label class="col-12 col-md-4">
                {{__( $labels ?? '' )}}
                @if (!empty($required))
                    <span class="required">*</span>
                @endif
            </label>
            <div class="col-12 col-md-8">
                @php
                    $value = old($name, ($value != '') ? $value : array_key_first($options));
                @endphp
                @foreach ($options as $key => $option)
                    <div class="form-check d-flex align-items-center mb-2">
                        <input type="radio" name="{{ $name }}" id="{{ $name }}_{{ $key }}" value="{{ $key }}" class="form-check-input" {{ ($value == $key) ? 'checked' : '' }}>
                        <label class="mb-0" for="{{ $name }}_{{ $key }}">{{ __($option) }}</label>
                    </div>
                @endforeach
                @error($name) <div class="error-valid">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>
    <div class="form-group col-12 col-xl-3 m-0">
    </div>
</div>
