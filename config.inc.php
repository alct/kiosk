<?php

error_reporting(0);

date_default_timezone_set('Europe/Brussels');

$language      = 'en';

// Raw log

$logFile       = 'log';

// Cache directory

$cacheDir      = 'cache/';

// RSS feed

$title         = 'Kiosk';
$description   = 'Bookmarks sharing. Anytime. Anywhere.';

$maxItems      = 25; // max items in the feed

$cache         = $cacheDir . 'rss';
$cacheDuration = 15 * 60; // 15min

$rssUrl        = 'https://path/kiosk/?rss'; // url of the feed

// Allowed users

$apiKeys       = array(
  '4b83c256a7ee37fef090378006304e15',
  'another-key'
);

?>