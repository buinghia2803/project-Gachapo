<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>[Gachapo] お問い合わせ</title>
</head>
<body>
  <div style="margin-left: 30px; margin-top: 30px">
     <div>お名前: {{ $contact['name'] ?? '' }}</div>
     <div>ご連絡について: {{ $contact['contact_type'] == CONTACT_TYPE_PHONE ?  $contact['email'] : $contact['phone'] }}</div>
     <div>お問い合わせ種類: {{ OPTIONS_INQUIRY_TYPE[$contact['inquiry_type']] ?? '' }}</div>
     <div>お問い合わせ内容詳細: {{ $contact['content'] ?? '' }}</div>
  </div>
</body>
</html>