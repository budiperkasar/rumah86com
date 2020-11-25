<?php
 return array (
  'components' => 
  array (
    'db' => 
    array (
      'class' => 'CDbConnection',
      'connectionString' => 'mysql:host=192.168.100.4;dbname=local_revamp_pembantu;port=3306',
      'username' => 'root',
      'password' => 'bogorbasah88',
      'emulatePrepare' => true,
      'charset' => 'utf8',
      'enableParamLogging' => false,
      'enableProfiling' => false,
      'schemaCachingDuration' => 7200,
      'tablePrefix' => 'maid_',
    ),
  ),
  'language' => 'en',
) ;
?>