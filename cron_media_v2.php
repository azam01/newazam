<?php
//require_once("_inc/_config.php"); 
require_once("_inc/_functionsv2.php");

echo "shell execute v6";
//die;
//echo $host;
global $db;

$sqlQuery = "SELECT * FROM media WHERE cron_process=0 AND parent_id=0 order by id desc limit 30 ";
$result = $db->query($sqlQuery);

print_r($result);

$year = date("Y");
$month = date("m");
$thumb_path="uploads/{$year}/{$month}/";
$date = date('Y/m/d H:i:s');