<!DOCTYPE html>
<html lang="<?= get_lang(); ?>">
<head>
  <meta charset="utf-8" />

  <title><?= $title; ?></title>

  <style>
    body {margin:0; font-family:Georgia, Times, serif; font-size:26px; text-align:center; color:#555; background-color:#fff}
    h1 {width:80%; margin:0 auto 15px auto; padding-bottom:1px; font-size:13px; text-align:center; font-weight:normal; color:#333; border-bottom:1px solid #ccc}
  </style>
</head>

<body>
  <h1>Kiosk</h1>
  <p><?= get_status(); ?></p>
</body>
</html>