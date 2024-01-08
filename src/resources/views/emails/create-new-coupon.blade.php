<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>[Gachapo] 最新のクーポンコード</title>
</head>
<body>
  <div style="margin-left: 30px; margin-top: 30px">
     <div>クーポン名: {{ $coupon['name'] ?? '' }}</div>
     <div>クーポンコード: {{ $coupon['code'] }}</div>
     <div>割引率: {{ $coupon['type_discount'] == COUPON_TYPE_PERCENT ? $coupon['discount_rate'] . '%' : $coupon['discount_amount'] . '円オフ' }}</div>
     <div>クーポン内容の説明: {{ $coupon['description'] ?? '' }}</div>
     <div>有効な時間:
         <span>{{ $coupon['period_start'] ? \Carbon\Carbon::parse($coupon['period_start'])->format('Y/m/d H:m') : '' }}</span>
        ～
        <span>{{ $coupon['period_end'] ? \Carbon\Carbon::parse( $coupon['period_end'])->format('Y/m/d H:m') : ''}}</span>
    </div>
  </div>
</body>
</html>
