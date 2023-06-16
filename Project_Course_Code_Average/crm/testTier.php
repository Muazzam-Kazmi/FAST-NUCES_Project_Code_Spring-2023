<?
require("global.php");
$timeAdded=time();
for($i=0;$i<99;$i++){
    //insert clients with a particular code
    $random=random();
    $query="insert into tushantMarketing_clients set id='$random',email='$random',firstName='$random',code='BZ8PVR',timeAdded='$timeAdded',paymentStatus='Paid'";
    runQuery($query);
}

?>