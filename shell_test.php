<?php
require_once("_inc/_config.php"); 
echo "test";

$sqlQuery = "SELECT * FROM media WHERE cron_process=0 AND parent_id=0 order by id desc limit 30 ";
$result = $db->query($sqlQuery);

print_r($result);

?>