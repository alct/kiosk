<?php

include_once('config.inc.php');
include_once('functions/kiosk.inc.php');
include_once('functions/url-tools.inc.php');
include_once('language/' . get_lang() . '.inc.php');

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

      include_once('templates/rss.inc.php');

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
 && isset($_GET['gateway']) && !empty($_GET['gateway'])
 && $decodedUrl = base64_decode($_GET['url'], true)) {
  $key = htmlspecialchars($_GET['key']);

  if (in_array($key, $apiKeys)) {
    if (valid_url($decodedUrl)) {
      $url = htmlspecialchars(cleanup_url($decodedUrl));

      if (!in_log($url)) {
        if ($file = @fopen($logFile, 'a+')) {
          fputs($file, time() . ' ' . $url . "\n");
          fclose($file);

          $status = '0000';
        } else { $status = '2001'; }
      } else { $status = '2002'; }
    } else { $status = '1003'; }
  } else { $status = '3001'; }

  header('Cache-Control: no-cache, no-store');

  if ($_GET['gateway'] == 'irc') {
    include_once('templates/irc.inc.php');
  } else { include_once('templates/bookmarklet.inc.php'); }
}

?>