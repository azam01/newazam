<?php
//require_once("_inc/_config.php"); 
ob_start();
error_reporting(E_ALL);
//require_once("_inc/_config.php"); 
//require_once("_inc/_functions.php"); // header

/*******  separate function file for all the developers  ******/
require_once("_inc/_functions-hasan.php");
require_once("_inc/_functions-anwar.php");
require_once("_inc/_functions-joydip.php");
/*******  separate function file for all the developers  ******/
$scriptPath = $_SERVER['DOCUMENT_ROOT'].'/cims/cron_media_v2.php';
$phpExecutable = '/usr/local/bin/php'; 

$command = "$phpExecutable $scriptPath 2>&1";
$result = shell_exec($command);

if ($result !== null) {
   echo "<pre>$result</pre>";
} else {
   echo "Error executing PHP script: $scriptPath";
}

?>
