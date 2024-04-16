<?php
echo "shell execute";
define('ROOT_PATH', 'https://'.$_SERVER['HTTP_HOST'].'/cims/');
define('ROOT_URL','https://buypods.com/cims/');
define('DOCUMENT_ROOT_PATH', $_SERVER["DOCUMENT_ROOT"].'/cims/');
define('COOKIE_PATH','buypods.com');
define('AUTO_LOGOUT',60*55);
define('folder',"cims");

$host = '50.28.17.237';
$username = 'framework';
$password = 'HK(Pz.$sf~xN';
$dbname = 'system';

/*
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'cimsv2';
*/

define('username',$username);
define('host',$host);
define('password',$password);

//db connection
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
//$db = new mysqli('localhost','mw786bless','lTg^Q1q{tATIKSc$@','rzV2_stage');
$db = new mysqli( $host , $username, $password, $dbname);
if ($db->connect_errno) {
    printf("Connection to database failed: %s\n", $db->connect_error);
    exit();
}

function fn_resize($image_resource_id,$target_width,$target_height) {
   //proportion size images
   // Target dimensions
    $max_width = $target_width;
    $max_height = $target_height;
    // Calculate new dimensions
    $old_width  = imagesx($image_resource_id);
    $old_height = imagesy($image_resource_id);
    $scale      = min($max_width/$old_width, $max_height/$old_height);
    $new_width  = ceil($scale*$old_width);
    $new_height = ceil($scale*$old_height);

    // Create new empty image
    $target_layer=$image=imagecreatetruecolor($new_width, $new_height);
    imagecopyresampled($target_layer, $image_resource_id, 0, 0, 0, 0, $new_width,$new_height, $old_width, $old_height);

    // Catch the image data
    ob_start();
    $data = ob_get_clean();
    // Destroy resources
   // imagedestroy($image_resource_id);

   return $target_layer;

}

function addData($tablename, $dataArr){
   global $db;
   
   foreach($dataArr as $key=>$val){
       if($val === 'null') unset($dataArr[$key]);
   }
   
   $columKeys = implode(",", array_keys($dataArr));
   $columVals = implode("','", array_values($dataArr));


   $sql = "INSERT INTO $tablename($columKeys) VALUES('$columVals')";
   $sqlRes = $db->query($sql);
   return $sqlRes;
}

function updateData($tablename, $dataArr, $where){
   global $db;
   foreach ($dataArr as $key => $value) {
       if($value === 'null'){
           //$args[] = "$key=null";
       }else{
           $args[] = "$key='$value'";
       }
   }

   $sql = "UPDATE `$tablename` SET ".implode(",", $args)." WHERE $where";
   $sqlRes = $db->query($sql);
   
   return $sqlRes;
}

$sqlQuery = "SELECT * FROM media WHERE cron_process=0 AND parent_id=0 order by id desc limit 30 ";
$result = $db->query($sqlQuery);

$year = date("Y");
$month = date("m");
$thumb_path="uploads/{$year}/{$month}/";
$date = date('Y/m/d H:i:s');

while ($media = mysqli_fetch_assoc($result)) {
   if ($media['file_type'] =="image/jpeg") {
      if (file_exists($media['file_url']) && is_readable($media['file_url'])) {
         $image_resource_id = imagecreatefromjpeg($media['file_url']);
         $file_name=explode(".",$media['title']);
         $source_properties = getimagesize($media['file_url']);

         //resize 250X250
         $target_layer = fn_resize($image_resource_id,250,250);
         $thumb_path_full_250=ROOT_URL."uploads/{$year}/{$month}/".$file_name[0]."250x250_thumb.jpg";
         imagejpeg($target_layer,$thumb_path.$file_name[0]."250x250_thumb.jpg");
         

          //250x250 db
          $dataArr = array(
            'parent_id' =>$media['id'],
            'title' =>$media['title'],
            'file_type' =>$media['file_type'],
            'file_size' =>$media['file_size'],
            'file_url' =>$thumb_path_full_250,
            'file_dimensions'=>'250x250',
                       'uploaded_date'=>$date
         );
         addData('media', $dataArr);

         //resize 600X600
         $target_layer = fn_resize($image_resource_id,600,600);
         $thumb_path_full_600=ROOT_URL."uploads/{$year}/{$month}/".$file_name[0]."600x600_thumb.jpg";
         imagejpeg($target_layer,$thumb_path.$file_name[0]."600x600_thumb.jpg");
         

         //600x600 db
         $dataArr = array(
            'parent_id' =>$media['id'],
            'title' =>$media['title'],
            'file_type' =>$media['file_type'],
            'file_size' =>$media['file_size'],
            'file_url' =>$thumb_path_full_600,
            'file_dimensions'=>'600x600',
                       'uploaded_date'=>$date
         );
         addData('media', $dataArr);

         //resize 1000X1000
         $target_layer = fn_resize($image_resource_id,1000,1000);
         $thumb_path_full_1000=ROOT_URL."uploads/{$year}/{$month}/".$file_name[0]."1000x1000_thumb.jpg";
         imagejpeg($target_layer,$thumb_path.$file_name[0]."1000x1000_thumb.jpg");
         

          //1000x1000 db
          $dataArr = array(
            'parent_id' =>$media['id'],
            'title' =>$media['title'],
            'file_type' =>$media['file_type'],
            'file_size' =>$media['file_size'],
            'file_url' =>$thumb_path_full_1000,
            'file_dimensions'=>'1000x1000',
            'uploaded_date'=>$date
         );
         addData('media', $dataArr);

         //Webp using gd library
         $thumb_path_webp="uploads/{$year}/{$month}/".$file_name[0].".webp";
         $thumb_path_webp_full_path=ROOT_URL."uploads/{$year}/{$month}/".$file_name[0].".webp";
         imagewebp($image_resource_id,$thumb_path_webp,25);  

         //webp db
         $dataArr = array(
            'parent_id' =>$media['id'],
            'title' =>$media['title'],
            'file_type' =>$media['file_type'],
            'file_size' =>$media['file_size'],
            'file_url' =>$thumb_path_webp_full_path,
            'file_dimensions'=>$media['file_dimensions'],
                       'uploaded_date'=>$date
         );
         addData('media', $dataArr);

         //update image crone process
            $dataArr = array(
               'cron_process' =>1
         );
         $where = "id = '".$media['id']."'";
         updateData("media", $dataArr, $where);
      }
   } elseif ($media['file_type'] =="image/gif")  {
      if (file_exists($media['file_url']) && is_readable($media['file_url'])) {
         $image_resource_id = imagecreatefromgif($media['file_url']);
         $file_name=explode(".",$media['title']);
         $source_properties = getimagesize($media['file_url']);

         //resize 250X250
         $target_layer = fn_resize($image_resource_id,250,250);
         $thumb_path_full_250=ROOT_URL."uploads/{$year}/{$month}/".$file_name[0]."250x250_thumb.gif";
         imagegif($target_layer,$thumb_path.$file_name[0]."250x250_thumb.gif");
         


         //250x250 db
         $dataArr = array(
            'parent_id' =>$media['id'],
            'title' =>$media['title'],
            'file_type' =>$media['file_type'],
            'file_size' =>$media['file_size'],
            'file_url' =>$thumb_path_full_250,
            'file_dimensions'=>'250x250',
                       'uploaded_date'=>$date
         );
         addData('media', $dataArr);


          //resize 600X600
          $target_layer = fn_resize($image_resource_id,600,600);
          $thumb_path_full_600=ROOT_URL."uploads/{$year}/{$month}/".$file_name[0]."600x600_thumb.gif";
          imagegif($target_layer,$thumb_path.$file_name[0]."600x600_thumb.gif");
          

          //600x600 db
         $dataArr = array(
            'parent_id' =>$media['id'],
            'title' =>$media['title'],
            'file_type' =>$media['file_type'],
            'file_size' =>$media['file_size'],
            'file_url' =>$thumb_path_full_600,
            'file_dimensions'=>'600x600',
                       'uploaded_date'=>$date
         );
         addData('media', $dataArr);

          //resize 1000X1000
          $target_layer = fn_resize($image_resource_id,1000,1000);
          $thumb_path_full_1000=ROOT_URL."uploads/{$year}/{$month}/".$file_name[0]."1000x1000_thumb.gif";
          imagegif($target_layer,$thumb_path.$file_name[0]."1000x1000_thumb.gif");
          

          //1000x1000 db
          $dataArr = array(
            'parent_id' =>$media['id'],
            'title' =>$media['title'],
            'file_type' =>$media['file_type'],
            'file_size' =>$media['file_size'],
            'file_url' =>$thumb_path_full_1000,
            'file_dimensions'=>'1000x1000',
                       'uploaded_date'=>$date
         );
         addData('media', $dataArr);

           
         //WebP 
         $sourceImage = $image_resource_id;
         $trueColorImage = imagecreatetruecolor(imagesx($sourceImage), imagesy($sourceImage));
         imagecopy($trueColorImage, $sourceImage, 0, 0, 0, 0, imagesx($sourceImage), imagesy($sourceImage));

         $localFilePath = "uploads/{$year}/{$month}/".$file_name[0].".webp";
         $thumb_path_webp_full_path=ROOT_URL."uploads/{$year}/{$month}/".$file_name[0].".webp";
         imagewebp($trueColorImage, $localFilePath,25);  

         
         //webp db
         $dataArr = array(
            'parent_id' =>$media['id'],
            'title' =>$media['title'],
            'file_type' =>$media['file_type'],
            'file_size' =>$media['file_size'],
            'file_url' =>$thumb_path_webp_full_path,
            'file_dimensions'=>$media['file_dimensions'],
                       'uploaded_date'=>$date
         );
         addData('media', $dataArr);

         //update image crone process
            $dataArr = array(
               'cron_process' =>1
         );
         $where = "id = '".$media['id']."'";
         updateData("media", $dataArr, $where);
      }
      
   } elseif ($media['file_type'] =="image/png")  {
      if (file_exists($media['file_url']) && is_readable($media['file_url'])) {

         $image_resource_id = imagecreatefrompng($media['file_url']);
         $file_name=explode(".",$media['title']);
         $source_properties = getimagesize($media['file_url']);

         //resize 250X250
         $target_layer = fn_resize($image_resource_id,250,250);
         $thumb_path_full_250=ROOT_URL."uploads/{$year}/{$month}/".$file_name[0]."250x250_thumb.png";
         imagepng($target_layer,$thumb_path.$file_name[0]."250x250_thumb.png");
         

         //250x250 db
         $dataArr = array(
            'parent_id' =>$media['id'],
            'title' =>$media['title'],
            'file_type' =>$media['file_type'],
            'file_size' =>$media['file_size'],
            'file_url' =>$thumb_path_full_250,
            'file_dimensions'=>'250x250',
                       'uploaded_date'=>$date
         );
         addData('media', $dataArr);

         //resize 600X600
         $target_layer = fn_resize($image_resource_id,600,600);
         $thumb_path_full_600=ROOT_URL."uploads/{$year}/{$month}/".$file_name[0]."600x600_thumb.png";
         imagepng($target_layer,$thumb_path.$file_name[0]."600x600_thumb.png");
         

         //600x600 db
         $dataArr = array(
            'parent_id' =>$media['id'],
            'title' =>$media['title'],
            'file_type' =>$media['file_type'],
            'file_size' =>$media['file_size'],
            'file_url' =>$thumb_path_full_600,
            'file_dimensions'=>'600x600',
                       'uploaded_date'=>$date
         );
         addData('media', $dataArr);

         //resize 1000X1000
         $target_layer = fn_resize($image_resource_id,1000,1000);
         $thumb_path_full_1000=ROOT_URL."uploads/{$year}/{$month}/".$file_name[0]."1000x1000_thumb.png";
         imagepng($target_layer,$thumb_path.$file_name[0]."1000x1000_thumb.png");
         

         //1000x1000 db
         $dataArr = array(
            'parent_id' =>$media['id'],
            'title' =>$media['title'],
            'file_type' =>$media['file_type'],
            'file_size' =>$media['file_size'],
            'file_url' =>$thumb_path_full_1000,
            'file_dimensions'=>'1000x1000',
                       'uploaded_date'=>$date
         );
         addData('media', $dataArr);

         //WebP using gd library
         $thumb_path_webp="uploads/{$year}/{$month}/".$file_name[0].".webp";
         $thumb_path_webp_full_path=ROOT_URL."uploads/{$year}/{$month}/".$file_name[0].".webp";
         imagewebp($image_resource_id,$thumb_path_webp,25);  

         //webp db
         $dataArr = array(
            'parent_id' =>$media['id'],
            'title' =>$media['title'],
            'file_type' =>$media['file_type'],
            'file_size' =>$media['file_size'],
            'file_url' =>$thumb_path_webp_full_path,
            'file_dimensions'=>$media['file_dimensions'],
                       'uploaded_date'=>$date
         );
         addData('media', $dataArr);

         //update image crone process
            $dataArr = array(
               'cron_process' =>1
         );
         $where = "id = '".$media['id']."'";
         updateData("media", $dataArr, $where);

      }
   } 
}



?>