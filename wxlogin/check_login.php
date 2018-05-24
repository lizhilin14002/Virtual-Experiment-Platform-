<?php 

include_once 'config.php';
$scene_id = isset($_POST['scene_id']) ? intval($_POST['scene_id']) : "";
if ($scene_id > 0) {
    $dtime = time()-3600;
    $dsql = "DELETE FROM `user` WHERE `addtime` < '" . $dtime . "' and `username` is null";
    mysql_query($dsql);
    $sql = "SELECT * FROM `user` WHERE `id` =" . $scene_id . "";
    $query = mysql_query($sql);
    $arr = mysql_fetch_array($query);
    $sqlchachong = "SELECT * FROM `user` where `openid` = '" . $arr['openid'] . "' and `openid` !='' and `id` !='" . $scene_id . "'";
    $chongfuresult=mysql_query($sqlchachong);
    $chongfuarr = @mysql_fetch_array($chongfuresult);
    $n = @mysql_num_rows($chongfuresult);
    if($n!=0){
    	$fuxie = "UPDATE `user` SET nickname='" . $arr['nickname'] . "'" . " WHERE `id` ='" . $chongfuarr['id'] . "'";
    	$fuxiequery = mysql_query($fuxie);
    	$shanchu = "DELETE FROM `user` WHERE `id` ='" . $scene_id . "'";
    	$shanchuquery = mysql_query($shanchu);
    	$sql2 = "SELECT * FROM `user` WHERE `id` =" . $chongfuarr['id'] . "";
    	$query2 = mysql_query($sql2);
    	$arr2 = mysql_fetch_array($query2);
    	echo json_encode($arr2);
    }else if($n==0){
    echo json_encode($arr);
    }
    
}