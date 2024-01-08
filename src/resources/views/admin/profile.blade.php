@extends('admin.layouts.admin')
@section('title', __('labels.S008_L058'))
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-3">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- jquery validation -->
                        {!! \App\Helpers\FlashMessageHelper::getMessage(request()) !!}
                        @if ($message = Session::get('success'))
                            <div
                                class="p-2 alert alert-success pt-0 pb-0 message-booking">
                                <button type="button" class="close p-1" data-dismiss="alert">&times;</button>
                                <p class="mb-1">{{$message}}</p>
                            </div>
                        @endif

                        @if ($message = Session::get('error'))
                            <div
                                class="p-2 alert alert-danger pt-0 pb-0 message-booking">
                                <button type="button" class="close p-1" data-dismiss="alert">&times;</button>
                                <p class="mb-1">{{$message}}</p>
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{__('labels.S008_L058')}}</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ route('admin.admin.update', $admin->id) }}" id="update_admin_form" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-12 col-xl-6">
                                            <div class="row d-sm-flex">
                                                <label for="nickname" class="col-12 col-sm-4">{{__('labels.S008_L002')}}<span
                                                        class="required">*</span></label>
                                                <div class="col-12 col-sm-8">
                                                    <input type="text" name="name" class="form-control"
                                                           id="name" placeholder="{{__('labels.S008_L002')}}" value="{{ old('name', $admin->name) }}">
                                                    @error('name')
                                                    <div class="error-valid">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 col-xl-6">
                                        </div>
                                        <div class="form-group col-12 col-xl-6">
                                            <div class="row d-sm-flex">
                                                <label for="exampleInputEmail1" class="col-12 col-sm-4">{{__('labels.S008_L003')}}<span
                                                        class="required">*</span></label>
                                                <div class="col-12 col-sm-8">
                                                    <input type="text" name="email" class="form-control"
                                                           id="email" placeholder="{{__('labels.S008_L003')}}" required value="{{ old('email', $admin->email) }}">
                                                    @error('email')
                                                    <div class="error-valid">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 col-xl-6">
                                        </div>
                                        <div class="form-group col-12 col-xl-6">
                                            <div class="row d-sm-flex">
                                                <label for="avatar" class="col-12 col-sm-4">{{__('labels.S008_L052')}}</label>
                                                <div class="col-12 col-sm-8">
                                                    <div class="upload_avatar">
                                                        <img class="image-preview image-avatar-admin" id="ImgPreview"
                                                             @if (!empty($userImage))
                                                             src="{{old('avatar', \App\Helpers\ImageHelper::imageSourceEncode(public_path('/').$userImage->image))}}"
                                                             @elseif(old('avatar') !== null)
                                                             src="{{old('avatar')}}"
                                                             @else
                                                             src="{{asset('/images/avatar-default.png')}}"
                                                             @endif
                                                             alt=""/>
                                                    </div>
                                                    <br>
                                                    <input name="avatar" id="avatar"
                                                           class="hidden image-preview-output" type="hidden"
                                                           value="{{ old('avatar') }}">
                                                    <input name="input_avatar" type="file"  accept="image/*" id="imag"
                                                           class="image-preview-input box-img-upload" style="display:none;"/>
                                                    <label class="label-upload-file btn-secondary" for="imag">{{__('labels.S001_L006')}}</label>
                                                    @error('avatar')
                                                    <div class="error-valid">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 col-xl-6">
                                        </div>
                                        <div class="form-group col-12 col-xl-6">
                                            <div class="row d-sm-flex">
                                                <label for="exampleInputPassword1" class="col-12 col-sm-4">{{__('labels.S008_L004')}}</label>
                                                <div class="col-12 col-sm-8">
                                                    <input type="password" name="password" class="form-control"
                                                           id="password" placeholder="{{__('messages.CU_MSG017')}}" autocomplete="new-password">
                                                    @error('password')
                                                    <div class="error-valid">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 col-xl-6">
                                        </div>
                                        <div class="form-group col-12 col-xl-6">
                                            <div class="row d-sm-flex">
                                                <label for="exampleInputPassword1" class="col-12 col-sm-4">{{__('labels.S008_L005')}}</label>
                                                <div class="col-12 col-sm-8">
                                                    <input type="password" name="password_confirmation" class="form-control"
                                                           id="password_confirmation" placeholder="{{__('labels.S008_L005')}}">
                                                    @error('password_confirmation')
                                                    <div class="error-valid">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 col-xl-6">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12 col-xl-6">
                                            <div class="row d-sm-flex">
                                                <label for="account_id" class="col-12 col-sm-4"></label>
                                                <div class="col-12 col-sm-8">
                                                    <button type="submit"
                                                            class="btn btn-primary">{{__('labels.S008_L019')}}</button>
                                                    <a type="submit" href="{{route('admin.admin')}}"
                                                       class="btn btn-secondary mr-2">{{__('labels.S008_L018')}}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                    <!-- right column -->
                    <div class="col-md-6">
                    </div>
                    <!--/.col (right) -->
                </div>
                <!-- /.row -->
            </div>
        </div>
    </div>
    <style>
        div.error-validate {
            font-size: 14px;
            color: red;
        }
        div.error-valid {
            font-size: 14px;
            color: red;
        }
        .rdo-input {
            font-weight: normal;
        }
    </style>
@endsection
@section('javascript')
    <script type="text/javascript">
        const errorMessageNameRequired = '{{ __('messages.CM_MSG001') }}';
        const errorMessageNameMaxCharacter = '{{ __('messages.CU_MSG001') }}';
        const errorMessageEmailRequired = '{{ __('messages.CM_MSG001') }}';
        const errorMessageEmailValid = '{{ __('messages.CU_MSG008') }}';
        const errorMessagePasswordMaxCharacter = '{{ __('messages.CU_MSG010') }}';
        const errorMessagePasswordMinCharacter = '{{ __('messages.CU_MSG010') }}';
        const errorMessagePasswordInvalid = '{{ __('messages.CU_MSG010') }}';
        const errorMessageConfirmPasswordNotEqual = '{{ __('messages.CU_MSG005') }}';
        const fileInvalid = '{{ __('messages.CU_MSG014') }}';
        const fileMaxSize = '{{ __('messages.CU_MSG015') }}';
        const urlAvatarDefault = '{{asset('/images/avatar-default.png')}}';
    </script>
    <script src="{{ url(mix('js/admin/user/avatar-preview.js')) }}"></script>
    <script src="{{ url(mix('js/admin/update_admin_validation.js')) }}"></script>
@endsection
