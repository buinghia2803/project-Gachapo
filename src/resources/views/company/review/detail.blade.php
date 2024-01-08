@extends('company.layouts.company')
@section('title', '登録内容変更')
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid pt-3">
            <ul class="breadcrumb">
                <li><a href="#" title=""> {{ __('labels.CM001_L066') }}</a></li>
            </ul>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"> {{ __('labels.CM001_L067') }}</h3>
                        </div>
                        <!-- body start -->
                        <div class="card-body">
                            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="m-profile__content">
                                    <!-- table start -->
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 60%;"><span>
                                                        {{ __('labels.ATM001_L003') }}</span></th>
                                                <th scope="col"> {{ __('labels.CM001_L068') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="loadReview">
                                            {{-- @foreach ($reviews as $review) --}}
                                            <tr>
                                                <td>
                                                    <span class="text-overflow-ellipsis">
                                                        {{ $reviews->content }}</span>
                                                </td>
                                                <td>{{ $reviews->order->user->name }}</td>
                                            </tr>
                                            {{-- @endforeach --}}
                                        </tbody>
                                    </table>
                                    <!-- table end -->
                                    <form action="{{ route('company.review.update', $reviews->id) }}" method="post"
                                        enctype="multipart/form-data" id="create_company_form">
                                        @csrf
                                        @method('PUT')
                                        <label for="">{{ __('labels.CM001_L070') }}</label>
                                        <textarea name="content_reply" id="" cols="30" rows="20" style="width: 100%">{{ $reviews->content_reply }}</textarea>
                                        <input type="text" name="status" hidden id="">
                                        <div for="" class="d-flex justify-content-end">{{ __('labels.CM001_L069') }}</div>
                                        <div class="d-flex justify-content-center">
                                            <button type="submit"
                                                class="btn btn-primary">{{ __('labels.CM001_L034') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- body end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{ url('js/admin/validation.js') }}"></script>
    <script type="text/javascript">
        const errorMessageMaxCharacter = '{{ __('messages.CM001_L002', ['attr' => '300']) }}';

        validation('#create_company_form', {
            'content_reply': {
                maxlength: 100
            },
        }, {
            'content_reply': {
                maxlength: errorMessageMaxCharacter
            },
        });
    </script>
@endsection
