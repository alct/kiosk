<?php

// Return the user defined language (/config.inc.php)
// If the related translation file does not exist, fallback to English

function get_lang() {
  $lang = $GLOBALS['language'];

  return ($lang != 'en' && !file_exists('language/' . $lang . '.inc.php')) ? $lang : 'en';
}

// Check if the url is already stored
// Protocol and "www" are removed to prevent collision

function in_log($value) {
  $log   = @file_get_contents($GLOBALS['logFile']);
  $value = str_replace(array('http://', 'https://', 'www.'), '', $value);

  return (strpos($log, $value) === false) ? false : true;
}

// Return the current status with the defined length
// If the length parameter is empty, fallback to 'short'
// If there is no user defined desc, fallback to generic scheme

function get_status($value = 'short') {
  $value       = ($value == ('short' || 'long')) ? $value . '-desc' : 'short-desc';
  $kioskStatus = $GLOBALS['kioskStatus'];

  return ($status = $GLOBALS['status']) ? (!empty($kioskStatus[$status][$value]) ? $kioskStatus[$status][$value] : 'Error #' . $status) : $kioskStatus['5000'][$value];
}

?>