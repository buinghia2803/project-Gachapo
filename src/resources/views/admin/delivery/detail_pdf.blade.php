<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="<?php echo public_path('/css/bootstrap.min.css'); ?>">
 <style>
    @font-face {
        font-family: cid0jp;
        font-style: normal;
        font-weight: normal;
        src: url('{{base_path()."/public/fonts/cid0jp.ttf"}}');
    }

    @font-face {
        font-family: aozoraminchomedium;
        font-style: normal;
        font-weight: medium;
        src: url('{{base_path()."/public/fonts/aozoraminchomedium.ttf"}}');
    }

    body {
        font-family: cid0jp, aozoraminchomedium;
    }
</style>
</head>
<body>
    <div>
        <div class="text-center mb-3" style="font-family: aozoraminchomedium">発送伝票</div>
        <div>
            <p><span>{{ __('labels.ADEL001_L002') }}: </span>{{ $data['order_id'] }}</p>
            <p><span>{{ __('labels.ADEL001_L003') }}: </span>{{ $statusList[$data['status_deliver']] }}</p>
            <p><span>{{ __('labels.ADEL001_L004') }}: </span>{{ \Carbon\Carbon::parse($data['created_at'])->format('Y年m月d日') }}</p>
            <p><span>{{ __('labels.ADEL001_L005') }}: </span>{{ \Carbon\Carbon::parse($data['date_of_shipment'])->format('Y年m月d日') }}</p>
            <div class="mb-3 mt-5">
                <span style="font-family: aozoraminchomedium">{{ __('labels.ADEL001_L008') }}</span>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <p><span>{{ __('labels.ADM001_L009') }}: </span>{{ $data['user']->name }}</p>
                    <p><span>{{ __('labels.CM001_L025') }}: </span>{{ $data['user']->phone }}</p>
                    <p><span>{{ __('labels.CM001_L021') }}: </span>{{ $data['address_delivery'] }}</p>
                </div>
            </div>
            <div class="mt-3">
                <span style="font-family: aozoraminchomedium">{{ __('labels.ADEL001_L009') }}</span>
            </div>
            <div class="row mt-3">
                <div class="col-lg-12">
                        <table id="example1"
                            class="table table-bordered table-striped dataTable dtr-inline tb-user-list"
                            role="grid" aria-describedby="example1_info">
                        <thead>
                            <tr>
                                <td style="font-family: aozoraminchomedium">No</td>
                                <td style="font-family: aozoraminchomedium">画像</td>
                                <td style="font-family: aozoraminchomedium">商品名</td>
                                <td style="font-family: aozoraminchomedium">商品数</td>
                            </tr>
                        </thead>
                        <tbody>
                        @if (count($delivery) > 0)
                            @foreach($delivery as $key => $orderDetail)
                                <tr>
                                    <td><div>{{ $key + 1 }}</div></td>
                                    <td><div><img src="{{ $orderDetail->product->attachment }}" alt="" width="100"></div></td>
                                    <td><div style="max-width: 300px;overflow-wrap: break-word;">{{ $orderDetail->product->name }}</div></td>
                                    <td><div>{{$orderDetail->totalProduct }}</div></td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
