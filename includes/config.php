<?php

date_default_timezone_set('Europe/Brussels');

$title         = 'Kiosk';
$description   = 'Bookmarks sharing. Anytime. Anywhere.';
$lang          = 'en';

// Raw log

$logFile       = 'log';

// Cache directory

$cacheDir      = 'cache/';

// RSS feed

$cache         = $cacheDir . 'rss';
$cacheDuration = 15 * 60; // 15min
$maxItems      = 25; // max items in the feed

$rssUrl        = 'https://path/kiosk/?rss'; // url of the feed

// Kiosk status

$kioskErrors = array(
  '0000' => 'Saved!',      // added
  '1001' => 'Error #1001', // missing argument
  '1003' => 'Error #1003', // invalid url
  '2001' => 'Error #2001', // can't write log
  '2002' => 'Too late ;)', // url already in the database
  '3001' => 'Error #3001'  // wrong API key
);

// Allowed users

$apiKeys       = array('4b83c256a7ee37fef090378006304e15', 'another-key');

?>