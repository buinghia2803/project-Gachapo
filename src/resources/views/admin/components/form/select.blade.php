<div class="row">
    <div class="form-group col-12 col-xl-9">
        <div class="row d-flex align-items-baseline">
            <label for="name" class="col-12 col-md-4">
                {{__( $labels ?? '' )}}
                @if (!empty($required))
                    <span class="required">*</span>
                @endif
            </label>
            <div class="col-12 col-md-8">
                <select
                    name="{{ $name ?? '' }}"
                    class="form-control"
                    id="{{ $slug ?? \Str::slug($name ?? '') }}"
                >
                    @foreach ($options as $key => $option)
                        <option value="{{ $key ?? 0 }}" {{ ($key == old($name, $value)) ? 'selected="selected"' : '' }} >{{ __($option) }}</option>
                    @endforeach
                </select>
                @error($name) <div class="error-valid">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>
    <div class="form-group col-12 col-xl-3 m-0">
    </div>
</div>