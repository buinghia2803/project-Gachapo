<form action="{{ route('admin.mail-templates.store') }}" method="POST" enctype="multipart/form-data" id="mail-template-{{$name}}" class="form-mail-template">
    @csrf
    <div class="col-12 mt-4">
        <div class="row form-group mb-4">
            <div class="col-lg-2 mail-template-label">{{ __('labels.ATM001_L002') }}<span class="text-danger">*</span></div>
            <div class="col-lg-10">
                <input name="subject" class="form-control custom-input-mail"
                       value="{{ old('subject', $templateData ? $templateData->subject : '') }}">
                @if ($errors->has('subject') && (Session::get(SESSION_TEMPLATE_MAIL_TAB) == $templateType || !Session::get(SESSION_TEMPLATE_MAIL_TAB)))
                    <p class='text-danger'>{{ $errors->first('subject') }}</p>
                @endif
                <br>
                <span id="error-subject-{{$name}}"></span>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-lg-2 mail-template-label">CC</div>
            <div class="col-lg-10">
                <select
                    class="form-control cc custom-input-mail"
                    name="cc[]"
                    multiple="multiple">
                    @foreach (old('cc', ($templateData && $templateData->cc) ? $templateData->cc : []) as $ccEmail)
                        <option value="{{ $ccEmail }}" selected>{{ $ccEmail }}</option>
                    @endforeach
                </select>
                @if ($errors->has('cc') && (Session::get(SESSION_TEMPLATE_MAIL_TAB) == $templateType || !Session::get(SESSION_TEMPLATE_MAIL_TAB)))
                    <p class='text-danger'>{{ $errors->first('cc') }}</p>
                @endif
                <br>
                <span id="error-cc-{{$name}}" class="text-danger"></span>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-lg-2 mail-template-label">BCC</div>
            <div class="col-lg-10">
                <select
                    class="form-control bcc custom-input-mail"
                    name="bcc[]"
                    multiple="multiple">
                    @foreach (old('bcc', ($templateData && $templateData->bcc) ? $templateData->bcc : []) as $bccEmail)
                        <option value="{{ $bccEmail }}" selected>{{ $bccEmail }}</option>
                    @endforeach
                </select>
                @if ($errors->has('bcc') && (Session::get(SESSION_TEMPLATE_MAIL_TAB) == $templateType || !Session::get(SESSION_TEMPLATE_MAIL_TAB)))
                    <p class='text-danger'>{{ $errors->first('bcc') }}</p>
                @endif
                <br>
                <span id="error-bcc-{{$name}}" class="text-danger"></span>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-lg-2 mail-template-label">{{ __('labels.ATM001_L003') }}<span class="text-danger">*</span></div>
            <div class="col-lg-10">
                <textarea id="editor-{{ $templateType }}" name="content" class="form-control textarea-editor" data-input='editor'
                          cols="15">
                    {!! old('content', $templateData ? $templateData->content : '') !!}
                 </textarea>
                @if ($errors->has('content') && (Session::get(SESSION_TEMPLATE_MAIL_TAB) == $templateType || !Session::get(SESSION_TEMPLATE_MAIL_TAB)))
                    <p class='text-danger'>{{ $errors->first('content') }}</p>
                @endif
                <p id="error-content-{{$name}}" style="margin:0"></p>
            </div>
        </div>
        <div class="row form-group mb-3 file-upload">
            <div class="col-lg-2 col-md-12 col-sm-12 col-12 mail-template-label">{{ __('labels.ATM001_L004') }}</div>
            <div class="col-lg-10 row">
                <div class="file-upload col-lg-5 col-md-6 col-sm-6 col-6">
                    <div class="file-select">
                        <input type="file" class="custom-file-input {{ $classFileInput }} attachment-{{$name}}"
                               id="customFile-{{ $templateType }}" name="attachment"
                               data-value="{{ $templateData ? $templateData->attachment : '' }}"
                               value="{{ $templateData ? $templateData->attachment : '' }}">
                        <label class="custom-file-label file-upload-input" for="customFile-{{ $templateType }}" id="custom-file-label-{{$name}}">{{ __('labels.ATM001_L004') }}</label>
                    </div>
                    <div id="attach-mail-template-{{$name}}"></div>
                </div>
                @if ($errors->has('attachment') && (Session::get(SESSION_TEMPLATE_MAIL_TAB) == $templateType || !Session::get(SESSION_TEMPLATE_MAIL_TAB)))
                    <p class='text-danger'>{{ $errors->first('attachment') }}</p>
                @endif
                <button type="button" class="btn btn-danger col-lg-2 col-md-6 col-sm-6 col-6" id="resetFile-{{$name}}" style="min-width: 150px; max-width: 150px">{{ __('labels.CM001_L037') }}</button>
            </div>
        </div>
        <input type="hidden" name="type" value="{{ $templateType }}">
        <input type="hidden" name="id" value="{{ $templateData ? $templateData->id : '' }}">
        <input type="hidden" id="old_attachment-{{$name}}" name="old_attachment" value="{{ $templateData ? $templateData->attachment : null }}">
        <div class="form-group">
            <div class="text-center">
                <button type="submit" class="btn btn-primary mt-4">{{ __('labels.ACC01_SB001') }}</button>
            </div>
        </div>
    </div>
</form>
