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

                <div class="image-group">
                    <input name="{{ $name }}_base64" type="hidden" class="image-preview-base64" value=""/>
                    <input name="{{ $name }}_input" type="hidden" class="image-preview-input" value="{{ $value ?? '' }}"/>
                    <input name="{{ $name }}" type="file"  accept="image/*" id="{{ $slug ?? \Str::slug($name ?? '') }}" class="image-preview-file" hidden value="{{ $value ?? '' }}"/>
                    <div class="image-preview">
                        <img src="{{ (!empty($value)) ? $value : asset('/images/image-default.png') }}" class="image-group-img" id="image-preview-src" alt=""/>
                        <div class="image-group-remove"><i class="fa fa-times"></i></div>
                    </div>
                    <div class="image-button">
                        <p class="mb-0">{!! $note ?? '' !!}</p>
                        <label class="btn btn-primary text-white" for="{{ $slug ?? \Str::slug($name ?? '') }}">{{__($button_text ?? '')}}</label>
                    </div>
                </div>

                @error($name) <div class="error-valid">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>
    <div class="form-group col-12 col-xl-3 m-0">
    </div>
</div>