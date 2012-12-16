<?php

// Kiosk status

$kioskStatus = array(
  '0000' => array( // added
    'short-desc' => 'Saved!',
    'long-desc'  => 'Kudos!'
  ),
  '1001' => array( // missing arguments
    'short-desc' => '',
    'long-desc'  => 'Missing arguments, name and shame the operators'
  ),
  '1003' => array( // invalid url
    'short-desc' => '',
    'long-desc'  => 'This url does not seem valid, are you sure?'
  ),
  '2001' => array( // can't write log
    'short-desc' => '',
    'long-desc'  => 'I can not access the log file, name and shame the operators'
  ),
  '2002' => array( // url already in the database
    'short-desc' => 'Too late ;)',
    'long-desc'  => 'Caramba, you were too slow grasshopper, this url is already stored!'
  ),
  '3001' => array( // wrong API key
    'short-desc' => '',
    'long-desc'  => 'Wrong API key, name and shame the operators'
  ),
  '5000' => array( // default
    'short-desc' => '',
    'long-desc'  => 'Something went wrong'
  )
);

?>