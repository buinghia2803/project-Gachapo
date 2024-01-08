@extends('admin.layouts.admin')
@section('title', __('labels.GAC001_L002'))
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-3">
            <ul class="breadcrumb">
                <li><a href="{{ route('admin.gachas.index') }}" title="">{{__('labels.GAC001_L001')}}</a></li>
                <li><a href="{{ route('admin.gachas.show', $gacha->id) }}" title="">{{__('labels.GAC001_L012')}}</a></li>
            </ul>
            {!! \App\Helpers\FlashMessageHelper::getMessage(request()) !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center pb-3">
                            <h3 class="card-title pb-0 mr-2">{{__('labels.GAC001_L013')}}</h3>
                            <a href="{{ route('admin.gachas.confirm', $gacha->id) }}" class="btn btn-sm btn-danger ml-auto w-200px">{{__('labels.GAC001_L014')}}</a>
                        </div>
                        <div class="card-body">
                            <h6 class="font-weight-normal">{{__('labels.GAC001_L005')}}: {{ $gacha->company->company }}</h6>
                            <div id="" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="tb-scroll mb-3">
                                            <table id="example1" class="table table-bordered table-striped dataTable dtr-inline tb-user-list">
                                                <thead>
                                                    <tr>
                                                        <th class="tb-no">{{ __('ID') }}</th>
                                                        <th class="w-200px">{{ __('labels.GAC001_L015') }}</th>
                                                        <th class="mw-200px">{{ __('labels.GAC001_L016') }}</th>
                                                        <th class="w-70px mw-70px">{{ __('labels.GAC001_L017') }}</th>
                                                        <th class="w-70px mw-70px">{{ __('labels.GAC001_L018') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($products as $item)
                                                        <tr>
                                                            <td>{{ $item->id }}</td>
                                                            <td>
                                                                <img src="{{ $item->getImage() }}" height="100" alt="">
                                                            </td>
                                                            <td><a href="{{ route('admin.products.confirm', $item->id) }}" class="line line-2">{{ $item->getName() }}</a></td>
                                                            <td>{{ __($rewardStatus[$item->reward_status] ?? '') }}</td>
                                                            <td>{{ $item->quantity }}</td>
                                                        </tr>
                                                    @endforeach
                                                    @if (count($products) == 0)
                                                        <tr role="row" class="odd">
                                                            <th colspan="100%" class="text-center">{{__('messages.H_MSG004')}}</th>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-block">
                                <form action="" method="POST" id="reject_form">
                                    <div class="form-group col-12">
                                        <textarea name="reject_reason" class="form-control w-100 mw-100 h-auto p-2" rows="5" placeholder="{{ __('labels.GAC001_L022') }}">{{ $gacha->reject_reason }}</textarea>
                                        @error('disapproval_reason') <div class="error-valid">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-12 d-flex justify-content-center">
                                        <button
                                            type="button"
                                            class="btn btn-danger mb-3 mr-4 col-sm-4 col-md-3 col-lg-2"
                                            data-toggle="modal"
                                            data-target="#modal-approve"
                                        >{{__('labels.ACA001_L004')}}</button>
                                        <button
                                            type="button"
                                            class="btn btn-primary mb-3 col-sm-4 col-md-3 col-lg-2 modal-disapprove-button"
                                        >{{__('labels.ACA001_L008')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-approve">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">{{__('labels.GAC001_L013')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6 class="font-weight-normal">{{__('labels.GAC001_L005')}}: {{ $gacha->company->company }}</h6>
                    <div class="tb-scroll mb-3">
                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline tb-user-list">
                            <thead>
                            <tr>
                                <th class="w-200px">{{ __('labels.GAC001_L015') }}</th>
                                <th class="mw-200px">{{ __('labels.GAC001_L016') }}</th>
                                <th class="w-70px mw-70px">{{ __('labels.GAC001_L017') }}</th>
                                <th class="w-70px mw-70px">{{ __('labels.GAC001_L018') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($products as $item)
                                <tr>
                                    <td>
                                        <img src="{{ $item->getImage() }}" height="100" alt="">
                                    </td>
                                    <td><a href="{{ route('admin.products.confirm', $item->id) }}" class="line line-2">{{ $item->getName() }}</a></td>
                                    <td>{{ __($rewardStatus[$item->reward_status] ?? '') }}</td>
                                    <td>{{ $item->quantity }}</td>
                                </tr>
                            @endforeach
                            @if (count($products) == 0)
                                <tr role="row" class="odd">
                                    <th colspan="100%" class="text-center">{{__('messages.H_MSG004')}}</th>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <form action="{{ route('admin.gachas.approve', $gacha->id) }}" method="post" class="mt-3 mb-3">
                        @csrf
                        <div class="text-center">
                            <button type="submit" class="btn btn-danger w-200px">{{__('labels.ACA001_L004')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-disapprove">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">{{__('labels.GAC001_L013')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6 class="font-weight-normal">{{__('labels.GAC001_L005')}}: {{ $gacha->company->company }}</h6>
                    <div class="tb-scroll mb-3">
                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline tb-user-list">
                            <thead>
                            <tr>
                                <th class="w-200px">{{ __('labels.GAC001_L015') }}</th>
                                <th class="mw-200px">{{ __('labels.GAC001_L016') }}</th>
                                <th class="w-70px mw-70px">{{ __('labels.GAC001_L017') }}</th>
                                <th class="w-70px mw-70px">{{ __('labels.GAC001_L018') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($products as $item)
                                <tr>
                                    <td>
                                        <img src="{{ $item->getImage() }}" height="100" alt="">
                                    </td>
                                    <td><a href="{{ route('admin.products.confirm', $item->id) }}" class="line line-2">{{ $item->getName() }}</a></td>
                                    <td>{{ __($rewardStatus[$item->reward_status] ?? '') }}</td>
                                    <td>{{ $item->quantity }}</td>
                                </tr>
                            @endforeach
                            @if (count($products) == 0)
                                <tr role="row" class="odd">
                                    <th colspan="100%" class="text-center">{{__('messages.H_MSG004')}}</th>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <form action="{{ route('admin.gachas.disapprove', $gacha->id) }}" method="post" class="mt-3 mb-3">
                        @csrf
                        <div class="row">
                            <div class="form-group col-12">
                                <textarea name="reject_reason" class="form-control w-100 mw-100 h-auto p-2" rows="5" placeholder="{{ __('labels.GAC001_L022') }}" readonly></textarea>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary w-200px">{{__('labels.ACA001_L008')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
    <script src="{{ url('js/admin/validation.js') }}"></script>
    <script type="text/javascript">
        const errorMessageRequired = '{{ __('messages.CM001_L001') }}';
        const errorMessageMaxLength500 = '{{ __('messages.CM001_L031', ['attr' => 500]) }}';
        validation('#reject_form', {
            'reject_reason': {
                required: true,
                maxlength: 500,
            },
        }, {
            'reject_reason': {
                required: errorMessageRequired,
                maxlength: errorMessageMaxLength500,
            },
        });
        $('body').on('click', '.modal-disapprove-button', function (e) {
            e.preventDefault();
            if ($('#reject_form').valid() == true) {
                value = $('#reject_form textarea[name=reject_reason]').val();
                $('#modal-disapprove textarea[name=reject_reason]').val(value);
                $('#modal-disapprove').modal('show');
            }
        });
    </script>
@endsection
