<ul class="nav nav-tabs" id="myTab" role="tablist">
    @foreach ($templatesTypeInfo as $typeInfo)
        <li class="nav-item">
            <a class="nav-link tab {{ Session::get(SESSION_TEMPLATE_MAIL_TAB) == $typeInfo['type']  || $currentType == $typeInfo['type'] ? 'active' : '' }}"
               id="template-type-{{ $typeInfo['type'] }}-tab" data-toggle="tab"
               href="#template-type-{{ $typeInfo['type'] }}" role="tab"
               aria-controls="template-type-{{ $typeInfo['type'] }}" aria-selected="true"
               data-type="{{ $typeInfo['type'] }}">
                {{ $typeInfo['name'] }}
            </a>
        </li>
    @endforeach
</ul>
<div class="tab-content" id="myTabContent">
    @foreach ($templatesTypeInfo as $typeInfo)
        <div class="tab-pane fade {{ Session::get(SESSION_TEMPLATE_MAIL_TAB) == $typeInfo['type']  || $currentType == $typeInfo['type'] ? 'show active' : '' }}"
             id="template-type-{{ $typeInfo['type'] }}" role="tabpanel"
             aria-labelledby="template-type-{{ $typeInfo['type'] }}-tab">
            @include('admin.mail-templates.form', [
            'templateData' => $templates->where('type', $typeInfo['type'])->first(),
            'templateType' => $typeInfo['type'],
            'classFileInput' => 'template-' . $typeInfo['type'] . '-file',
            'name' => $typeInfo['type']
            ])
        </div>
    @endforeach
</div>
