<?php

// url validation

function valid_url($value) {
  $tldsRegex     = '';
  $tldsUrl       = 'https://data.iana.org/TLD/tlds-alpha-by-domain.txt';
  $cache         = $GLOBALS['cacheDir'] . 'tlds-regex';
  $cacheDuration = 3 * 24 * 60 * 60; // 3 days

  if (file_exists($cache) && time() < ((@filemtime($cache)) + $cacheDuration)) {
    if ($handle = @fopen($cache, 'r')) {
      $tldsRegex = fread($handle, filesize($cache));
      fclose($handle);
    }
  } else {
    if ($handle = @fopen($tldsUrl, 'r')) {
      while (($buffer = fgets($handle)) !== false) {
        $tlds[] = $buffer;
      }

      $tldsLength = count($tlds);

      for ($i = 1; $i < $tldsLength; $i++) {
        $tldsRegex .= '\.' . strtolower(trim($tlds[$i]));

        if ($i != $tldsLength - 1) {
          $tldsRegex .= '|';
        }
      }

      $tldsRegex = $tldsRegex . '|\.p2p|\.42';

      if ($handle = @fopen($cache, 'w+')) {
        fputs($handle, $tldsRegex);
        fclose($handle);
      }
    }
  }

  if (!isset($tldsRegex) || empty($tldsRegex)) {
    $tldsRegex = '\.[a-z]{2,4}';
  }

  if (preg_match('!^(https?://|www\d*\.)(\[?((?:\d+\.){3}\d+|(?:[a-f\d]*:?){3,})\]?|[a-z\d\.-]+(?:' . $tldsRegex . '))(?::\d+)?(/[\w#%@\$&/\?\!\.:;\'\*\+-=~\(\)\[\]{}]*)*$!i', $value, $matches)) {
    return (empty($matches[3]) || (!empty($matches[3]) && @inet_pton($matches[3]))) ? true : false;
  } else { return false; }
}

// url sanitization

function cleanup_url($value) {
  $value = str_replace('/#!/', '/', $value);

  $value = preg_replace(
    array(
      '/(\?|&)(?:utm|awesm)(?:[-_][a-z\d]+)?=[\w\.-]+&/i',
      '/(\?|&)(?:utm|awesm)(?:[-_][a-z\d]+)?=[\w\.-]+/i',
      '/\/&/'
    ),
    array(
      '&',
      '',
      '/?'
    ),
    $value
  );

  return $value;
}

?>