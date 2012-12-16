<?php

$header .= '<?xml version="1.0" encoding="utf-8" ?>';
$header .= "\n" . '<rss version="2.0">';
$header .= "\n" . '<channel>';
$header .= "\n" . '  <title>' . $title . '</title>';
$header .= "\n" . '  <description>' . $description . '</description>';
$header .= "\n" . '  <language>' . get_lang() . '</language>';
$header .= "\n" . '  <link>' . $rssUrl . '</link>';

for ($i = 0; $i < $maxItems; $i++) {
  $content .= "\n" . '  <item>';
  $content .= "\n" . '    <title>' . $currentLog[$i]['url'] . '</title>';
  $content .= "\n" . '    <pubDate>' . $currentLog[$i]['date'] . '</pubDate>';
  $content .= "\n" . '    <link>' . $currentLog[$i]['url'] . '</link>';
  $content .= "\n" . '    <guid>' . $currentLog[$i]['url'] . '</guid>';
  $content .= "\n" . '  </item>';
}

$footer .= "\n" . '</channel>';
$footer .= "\n" . '</rss>';

?>