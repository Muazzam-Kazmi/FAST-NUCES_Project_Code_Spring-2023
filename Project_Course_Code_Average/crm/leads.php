<?require("./global.php");

if($logged==0)
    header("Location:index.php");

$paymentStatus="Pending";

//showing users 
$page = !empty($_GET['page']) ? (int) $_GET['page'] : 1;
$lastEntryNo=!empty($_GET['lastEntryNo']) ? (int) $_GET['lastEntryNo'] : 0;
$firstEntryNo=!empty($_GET['firstEntryNo']) ? (int) $_GET['firstEntryNo'] : 0;

$searchEnabled=0;
if(isset($_GET['search'])){
    $searchEnabled=1;
    $search=clear($_GET['search']);
}
    
//if no search then
if(!$searchEnabled)
    $totalPages=getRow($con,"select count(id) as totalPages,max(autoIncrement) as maxAutoInc from tushantMarketing_clients where paymentStatus='$paymentStatus'");
//if search then calculate total page for that search result
else if($searchEnabled){
    $query="select count(id) as totalPages,max(autoIncrement) as maxAutoInc from tushantMarketing_clients where (name like '%$search%' or contactNo like '%$search%' or email like '%$search%' or postalAddress like '%$search%' or code like '%$search%') and paymentStatus='$paymentStatus' ";
    $totalPages=getRow($con,$query);
}
 
$maxAutoInc=$totalPages['maxAutoInc']+1;//adding plus one to display correct results 
$totalPages=ceil($totalPages['totalPages']/10);

//if new page or next page is opened then reference point is last entry no
if((!isset($_GET['page'])) || (isset($_GET['lastEntryNo']))){
    $query="select * from tushantMarketing_clients where autoIncrement > $lastEntryNo and paymentStatus='$paymentStatus' order by autoIncrement asc limit 10";
    if($searchEnabled)
        $query="select * from tushantMarketing_clients where autoIncrement > $lastEntryNo and paymentStatus='$paymentStatus' and (name like '%$search%' or contactNo like '%$search%' or email like '%$search%' or postalAddress like '%$search%' or code like '%$search%') order by autoIncrement asc limit 10";
}
else{//means that previous page is opened
    $query="select * from tushantMarketing_clients where autoIncrement < $firstEntryNo and paymentStatus='$paymentStatus' order by autoIncrement desc limit 10";
    if($searchEnabled)
        $query="select * from tushantMarketing_clients where autoIncrement < $firstEntryNo and paymentStatus='$paymentStatus' and (name like '%$search%' or contactNo like '%$search%' or email like '%$search%' or postalAddress like '%$search%' or code like '%$search%') order by autoIncrement desc limit 10";
}
$displayLeads=getAll($con,$query);

//this would be passed in pagination 
$lastEntryNo=max(array_column($displayLeads, 'autoIncrement'));
$firstEntryNo=min(array_column($displayLeads, 'autoIncrement'));

?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <?require("./includes/views/head.php") ?>
    </head>
<body class="<? echo $g_body_class ?>">
	<? require("./includes/views/header.php") ?>
	<div class="kt-grid kt-grid--hor kt-grid--root">
		<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
				<? require("./includes/views/topmenu.php") ?>
				<? require("./includes/views/leftmenu.php") ?>
				<div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
					<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
						<div class="kt-container  kt-grid__item kt-grid__item--fluid w-100">
    
							<? if (isset($_GET['m'])) { ?>
								<div class="alert alert-info"><? echo $_GET['m'] ?></div>
							<? } ?>
                            
                            <div class="kt-portlet kt-portlet--mobile">
            						<div class="kt-portlet__head kt-portlet__head--lg">
            							<div class="kt-portlet__head-label">
            								<span class="kt-portlet__head-icon">
            								</span>
            								<h3 class="kt-portlet__head-title">
            								    Sales Persons
            								</h3>
            							</div>
            							<form method="get" action="" enctype="multipart/form-data" style="margin-top: 10px;">
            							<div class="kt-portlet__head-toolbar">
            								<div class="kt-portlet__head-wrapper">
            									<div class="kt-portlet__head-actions">
        										    <div class="d-flex align-items-center">
            										    <input type="text" name="search" class="form-control" placeholder="Input Search" value="<?echo $search?>">
            										    <input type="submit" class="btn btn-primary" value="Search">
                									</div>
                								</div>
            								</div>
            							</div>
            							</form>
            							
            						</div>
            						<div class="kt-portlet__body">
            							<form action="" method="post">
            							    <table class="table table-striped- table-bordered table-hover table-checkable " >
                                                <thead>
                                                    <tr>
                                                        <th>FirstName</th>
                                                        <th>LastName</th>
                                                        <th>Contact Number</th>
                                                        <th>Postal Address</th>
                                                        <th>Email</th>
                                                        <th>Code</th>
                                                        <th>Time Signed Up</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?foreach($displayLeads as $row){?>
                                                        <tr>
                                                            <td><?echo $row['firstName']?></td>
                                                            <td><?echo $row['lastName']?></td>
                                                            <td><?echo $row['contactNo']?></td>
                                                            <td><?echo $row['postalAddress']?></td>
                                                            <td><?echo $row['email']?></td>
                                                            <td><?echo $row['code']?></td>
                                                            <td><?echo date("d M Y",$row['timeAdded'])?></td>
                                                        </tr>
                                                    <?}?>
                                                </tbody>
                                            </table>
                                            
                                            <!--pagination section-->
                                            
    									<div class="row">
    										<? if ($page != 1) { ?>
    											<a href="?page=<? echo $page - 1 ?>&firstEntryNo=<?echo $firstEntryNo?><?if($searchEnabled){echo "&search=$search";}?>" class="page-item disabled page-item-grey" style="left: 10px; margin-left: 0px;">
    												<div href="?page=<? echo $page - 1 ?>&firstEntryNo=<?echo $firstEntryNo?>" class="page-link" tabindex="-1" style="border-radius: 0.35rem !important;color:rgba(129,129,165,1)">
    													<i aria-hidden="true" style="color: #97979b;/*! padding: 10px; */background: #c5c5d5;padding: 8px;border-radius: 100px;font-size: 8px;" class="fa fa-chevron-left"></i>
    													<span class="ml-2"> Back</span>
    												</div>
    											</a>
    										<? } ?>
    
    										<nav aria-label="Page navigation example mt-3" style="margin: 1px auto;">
    											<ul class="pagination justify-content-center">
    
    												<style>
    													.selected-page-item {
    														border-bottom-color: #591df1;
    														border-bottom-width: 5px;
    														border-bottom-style: solid;
    													}
    
    													.selected-page-link {
    														border: 1px solid #591df1;
    														background: white;
    														color: #591df1;
    														margin-bottom: 25px;
    														border-width: 2px;
    													}
    												</style>
                                                    <?
                                                    if($page >= 3){
                                                        ?>
                                                        <!--first page block-->
                                                        <li class="page-item">
														    <a class="page-link" href="?page=1&lastEntryNo=0">1</a>
														</li>
														<b style="font-weight: bold;font-size: x-large;margin-left: 10px;margin-right: 10px;">....</b>
                                                        <?
                                                    }
                                                    
                                                    ?>
    												<? for ($i = ($page - 1); $i < ($page + 2); $i++) {
    													if ($i > 0 && $i <= $totalPages) {
    													    $lastRenderedPage=$i;
    													?>
    														<li class="page-item <? if ($page == $i) {echo "selected-page-item";} ?>">
															    <a class="page-link 
    															    <?
    															    $doNothing=0;
    															    if ($page == $i) {echo "selected-page-link";}
    															    //the pages ahead of the selected page will send their last entry no and the pages before the selected page will send their first entry no
    															    if($page > $i)
    															        $href="?page=$i&firstEntryNo=$firstEntryNo";
    															    else if($page < $i)
    															        $href="?page=$i&lastEntryNo=$lastEntryNo";
    															    else
    															        $doNothing=1;//hides the link if the on current page
    															    ?>" 
        															<?if(!$doNothing){?>href="<?echo $href?><?if($searchEnabled){echo "&search=$search";}?>"<?}?>>
															        <? echo $i ?>
    															</a>
															</li>
    												<? }}
    												if($totalPages-$lastRenderedPage >= 1){
    												    ?>
    												    <!--last page block-->
    												    <b style="font-weight: bold;font-size: x-large;margin-left: 10px;margin-right: 10px;">....</b>
                                                        <li class="page-item">
														    <a class="page-link" href="?page=<?echo $totalPages?>&firstEntryNo=<?echo $maxAutoInc?><?if($searchEnabled){echo "&search=$search";}?>"><?echo $totalPages?></a>
														</li>
    												    <?}?>
												</ul>
    										</nav>
    
    
    										<? if (($page + 1) <= $totalPages) { ?>
    											<a href="?page=<? echo $page + 1 ?>&lastEntryNo=<?echo $lastEntryNo?><?if($searchEnabled){echo "&search=$search";}?>"
    											class="page-item page-item-grey" style="right: 10px; margin-right: 0px;">
    												<div class="page-link" style="border-radius: 0.35rem !important;color:rgba(129,129,165,1)"><span class="mr-2">Next </span>
    													<i aria-hidden="true" style="color: #97979b;background: #c5c5d5;padding: 8px;border-radius: 100px;font-size: 8px;" class="fa fa-chevron-right"></i>
    												</div>
    											</a>
    										<?}?>
                                        </div>
                                        </form>
            						</div>
            					</div>
        				</div>
                    </div>
                </div>
			</div>
		</div>
		<? require("./includes/views/footer.php") ?>
	</div>
    <? require("./includes/views/footerjs.php") ?>
</body>
</html>