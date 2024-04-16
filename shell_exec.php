<?php
//require_once("_inc/_config.php"); 

$scriptPath = $_SERVER['DOCUMENT_ROOT'].'/cims/shell_test.php';
$phpExecutable = '/usr/local/bin/php'; 

$command = "$phpExecutable $scriptPath";
$result = shell_exec($command);

if ($result !== null) {
   echo "<pre>$result</pre>";
} else {
   echo "Error executing PHP script: $scriptPath";
}

?>
