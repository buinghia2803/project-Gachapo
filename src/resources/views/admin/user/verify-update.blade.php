@extends('admin.layouts.admin')
@section('title', __('labels.AUM001_L003'))
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-3">
            <ul class="breadcrumb">
                <li><a href="/admin/user" title="">{{ __('labels.AUM001_L001') }}</a></li>
                <li><a href="/admin/user/{{ $data['user_id'] }}/edit" title="">{{ __('labels.CM001_L009') }}</a></li>
                <li><span>{{ __('labels.CM001_L016') }}</span></li>
            </ul>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('labels.AUM001_L003') }}</h3>
                        </div>
                        <!-- form start -->
                        <form action="{{ route('admin.user.update', $data['user_id']) }}" method="POST">
                            @csrf
                            @method("PUT")
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-12 col-xl-9">
                                        <div class="row d-flex align-items-baseline">
                                            <label class="col-12 col-md-4">{{ __('labels.ADM001_L002') }}</label>
                                            <div class="col-12 col-md-8">
                                                <p class="confirm_info">{{ $data['name'] }}</p>
                                                <input type="hidden" name="name"
                                                    value="{{ $data['name'] }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-12 col-xl-3 m-0">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-12 col-xl-9">
                                        <div class="row d-flex align-items-baseline">
                                            <label class="col-12 col-md-4">{{ __('labels.ADM001_L010') }}</label>
                                            <div class="col-12 col-md-8">
                                                <p class="confirm_info">{{ $data['name_furigana'] }}</p>
                                                <input type="hidden" name="name_furigana"
                                                    value="{{ $data['name_furigana'] }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-12 col-xl-3 m-0">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-12 col-xl-9">
                                        <div class="row d-flex align-items-baseline">
                                            <label class="col-12 col-md-4">{{ __('labels.CM001_L030') }}</label>
                                            <div class="col-12 col-md-8">
                                                <p class="confirm_info">{{ $data['email'] }}</p>
                                                <input type="hidden" name="email"
                                                    value="{{ $data['email'] }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-12 col-xl-3 m-0">
                                    </div>
                                </div>
                                @if(isset($data['password']) && !empty($data['password']))
                                <div class="row">
                                    <div class="form-group col-12 col-xl-9">
                                        <div class="row d-flex align-items-baseline">
                                            <label class="col-12 col-md-4">{{ __('labels.CM001_L019') }}</label>
                                            <div class="col-12 col-md-8">
                                                <p class="confirm_info">{{ $data['password'] }}</p>
                                                <input type="hidden" name="password"
                                                    value="{{ $data['password'] }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-12 col-xl-3 m-0">
                                    </div>
                                </div>
                                @endif
                                <div class="row">
                                    <div class="form-group col-12 col-xl-9">
                                        <div class="row d-flex align-items-baseline">
                                            <label class="col-12 col-md-4">{{ __('labels.NML001_L007') }}</label>
                                            <div class="col-12 col-md-8">
                                                <p class="confirm_info">{{ $listStatus[$data['status']] }}</p>
                                                <input type="hidden" name="status" value="{{ $data['status'] }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-12 col-xl-3 m-0">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-12 col-xl-9">
                                        <div class="row d-flex align-items-baseline">
                                            <div class="col-12 col-md-8 d-flex justify-content-center d-md-inline-block">
                                                <button type="submit"
                                                        class="btn btn-primary">{{ __('labels.CM001_L002') }}</button>
                                                <button type="button" id="back_to_previous"
                                                    class="btn btn-secondary ml-0 ml-3">{{ __('labels.CM001_L017') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        $("#back_to_previous").on("click", function (){
            history.back();
        });
    </script>
@endsection
