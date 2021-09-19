<?php
error_reporting(E_ALL);
require_once ("Database_worker.php");
$db = new Database_worker();
@$db->do_sql("SET NAMES utf8");
$file = fopen("lots.json","r");
//$file = fopen("json_solo.json","r");
$file_content = fread($file,999999999);
$json = json_decode($file_content,TRUE);
foreach($json as $key=>$row){    
    $photos = $row['photos'];
    unset($row['photos']);        
    $db->insert("common_data",$row);   
    foreach($photos as $photo){        
        $db->insert("photos",["file"=>$photo['file'],"car_id"=>$row['id']]);
    }
}
