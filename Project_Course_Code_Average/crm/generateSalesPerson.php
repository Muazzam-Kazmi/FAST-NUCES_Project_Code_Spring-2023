<?require("./global.php");

for($i=0;$i<100;$i++){
    $id=random();
    $codeId=random();
    $query = "insert into tushantMarketing_salesPerson set id='$id',name='random', firstName='random', lastName='random', codeId='$codeId', email='random', phone='random', instagram='random', facebook='random', tiktok='random'";
    runQuery($query);
}
?>