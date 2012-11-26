<?php

include('includes/config.php');
include('includes/functions.php');

// rss

if (isset($_GET['rss'])) {
  if (file_exists($cache) && time() < ((@filemtime($cache)) + $cacheDuration)) {
    if ($handle  = @fopen($cache, 'r')) {
      $rss = fread($handle, filesize($cache));
      fclose($handle);

      header('Content-type: application/rss+xml; charset=utf-8');
      echo $rss;
    } else { echo 'Error: can not read cache file'; }
  } else {
    if ($handle = @fopen($logFile, 'r')) {
      $header     = '';
      $content    = '';
      $footer     = '';

      $currentLog = array();
      $i          = 0;

      while (($buffer = fgets($handle)) !== false) {
        $item = explode(' ', $buffer);

        $currentLog[$i]['date'] = date('r', $item[0]);
        $currentLog[$i]['url']  = trim($item[1]);

        $i++;
      }

      fclose($handle);

      $currentLog = array_reverse($currentLog);

      $maxItems   = ($maxItems > $i) ? $i : $maxItems;

      for ($i = 0; $i < $maxItems; $i++) {
        $content .= "\n" . '  <item>';
        $content .= "\n" . '    <title>' . $currentLog[$i]['url'] . '</title>';
        $content .= "\n" . '    <pubDate>' . $currentLog[$i]['date'] . '</pubDate>';
        $content .= "\n" . '    <link>' . $currentLog[$i]['url'] . '</link>';
        $content .= "\n" . '    <guid>' . $currentLog[$i]['url'] . '</guid>';
        $content .= "\n" . '  </item>';
      }

      $header .= '<?xml version="1.0" encoding="utf-8" ?>';
      $header .= "\n" . '<rss version="2.0">';
      $header .= "\n" . '<channel>';
      $header .= "\n" . '  <title>' . $title . '</title>';
      $header .= "\n" . '  <description>' . $description . '</description>';
      $header .= "\n" . '  <language>' . $lang . '</language>';
      $header .= "\n" . '  <link>' . $rssUrl . '</link>';

      $footer .= "\n" . '</channel>';
      $footer .= "\n" . '</rss>';

      $rss = $header . $content . $footer;

      if ($handle = @fopen($cache, 'w+')) {
        fputs($handle, $rss);
        fclose($handle);
      } else { echo 'Error: can not write cache file'; }

      header('Content-type: application/rss+xml; charset=utf-8');
      echo $rss;
    } else { echo 'Error: can not read log file'; }
  }
}

// save url

if (isset($_GET['url']) && !empty($_GET['url'])
 && isset($_GET['key']) && !empty($_GET['key'])
 && $decodedUrl = base64_decode($_GET['url'], true)) {
  $url = htmlspecialchars($decodedUrl);
  $key = htmlspecialchars($_GET['key']);

  if (in_array($key, $apiKeys)) {
    if (valid_url($url)) {
      $url = cleanup_url($url);

      if (!in_log($url)) {
        if ($file = @fopen($logFile, 'a+')) {
          fputs($file, time() . ' ' . $url . "\n");
          fclose($file);
        } else { $error = '2001'; }
      } else { $error = '2002'; }
    } else { $error = '1003'; }
  } else { $error = '3001'; }

  header('Cache-Control: no-cache, no-store');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />

  <title>Kiosk</title>

  <style>
    body {margin:0; font-family:Georgia, Times, serif; font-size:26px; text-align:center; color:#555; background-color:#fff}
    h1 {width:80%; margin:0 auto 15px auto; padding-bottom:1px; font-size:13px; text-align:center; font-weight:normal; color:#333; border-bottom:1px solid #ccc}
  </style>
</head>

<body>
  <h1>Kiosk</h1>
  <p><?= isset($error) ? $kioskErrors[$error] : $kioskErrors['0000']; ?></p>
</body>
</html>

<?php

}

?>