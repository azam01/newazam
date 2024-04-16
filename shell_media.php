<?php
//$scriptPath = $_SERVER['DOCUMENT_ROOT'].'/cims/cron_test.php';
//$scriptPath = $_SERVER['DOCUMENT_ROOT'].'/cims/cron_media.php';
$scriptPath ='/home/buypods/public_html/cims/cron_media.php';

$phpExecutable = '/usr/local/bin/php'; 

$command = "$phpExecutable $scriptPath";
$result = shell_exec($command);

if ($result !== null) {
   echo "<pre>$result</pre>";
} else {
   echo "Error executing PHP script: $scriptPath";
}

?>
