<div class="row">
    <div class="form-group col-12 col-xl-9">
        <div class="row d-flex align-items-baseline">
            <label for="{{ $slug ?? \Str::slug($name ?? '') }}" class="col-12 col-md-4">
                {{__( $labels ?? '' )}}
                @if (!empty($required))
                    <span class="required">*</span>
                @endif
            </label>
            <div class="col-12 col-md-8 form-percent">
                <div class="d-flex align-items-center">
                    <input
                        type="number"
                        name="{{ $name ?? '' }}"
                        class="col-md-2 form-control"
                        id="{{ $slug ?? \Str::slug($name ?? '') }}"
                        placeholder="{{__($placeholder ?? $labels ?? '')}}"
                        value="{{ old($name, $value ?? '') }}"
                    >
                    <span class="fz-16px ml-2">%</span>
                </div>
                @error($name) <div class="error-valid">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>
    <div class="form-group col-12 col-xl-3 m-0">
    </div>
</div>
