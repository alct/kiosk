<?php

//config

set_time_limit(0);

date_default_timezone_set('Europe/Brussels');

$nick   = ''; // bot's nickname

$server = ''; // i.e. irc.freenode.org
$port   = ''; // i.e. 6666
$chan   = ''; // i.e. #troll

$cmd    = '!pr'; // the bot looks for "<cmd> <url>" (i.e. "!pr <url>")

$kiosk  = ''; // i.e. https://path/kiosk/
$apiKey = ''; // i.e. 4b83c256a7ee37fef090378006304e15

// functions

function app_log($string) {
  echo date('D d F Y, H:i:s', time()) . ' ' . $string . "\n";
}

function irc($cmd) {
  fputs($GLOBALS['socket'], $cmd . "\r\n");
}

// bot

app_log('Script loaded');
app_log('Connexion...');

if ($socket = fsockopen($server, $port)) {
  app_log('Connected');
  app_log('Authentication');

  irc('USER ' . $nick . ' kioskbot kioskbot kioskbot');
  irc('NICK ' . $nick);

  app_log('Awaiting PING...');

  $ping  = 0;

  while (1) {
    if ($data = fgets($socket, 1024)) {
      echo $data;

      $parts = explode(' ', $data);
      $msg   = explode(':', $data);

      // ping
      if ($parts[0] == 'PING') {
        app_log('PONG ' . $parts[1]);
        irc('PONG ' . $parts[1]);

        $ping++;
      }

      // if first PING or kicked, connect to chan
      if ($ping == 1 || ($parts[1] == 'KICK' && $parts[3] == $nick)) {
        app_log('Connecting to chan...');
        irc('JOIN ' . $chan);

        $ping++;
      }

      // command interception
      if ($parts[1] == 'PRIVMSG' && substr($msg[2], 0, 4) == $cmd . ' ') {
        $url = explode($cmd . ' ', $data, 2);
        $url = base64_encode(trim($url[1]));

        $status = ($status = @file_get_contents($kiosk . '?gateway=irc&key=' . $apiKey . '&url='. $url)) ? $status : 'Error: can not reach kiosk service, please try again';

        app_log('Kiosk - ' . $status);
        irc('PRIVMSG ' . $chan . ' :' . $status);
      }
    }
    usleep(100);
  }
} else {
  app_log('Connexion failed');
  exit;
}

?>