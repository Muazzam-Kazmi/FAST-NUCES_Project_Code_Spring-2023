<?require("./global.php");
//current week starting and ending timestamp
$current_timestamp = time();
$day_of_week = date('w', $current_timestamp);
$start_of_week_timestamp = strtotime("-$day_of_week day", $current_timestamp);
$end_of_week_timestamp = strtotime("+".(6-$day_of_week)." day", $current_timestamp);

$start_of_week = date('d-M', $start_of_week_timestamp);
$end_of_week = date('d-M', $end_of_week_timestamp);

$start_of_today_timestamp = strtotime('today', $current_timestamp);
$end_of_today_timestamp = strtotime('tomorrow', $start_of_today_timestamp) - 1;

$start_of_month_timestamp = strtotime('first day of this month', $current_timestamp);
$end_of_month_timestamp = strtotime('last day of this month', $current_timestamp) + 86399; 

$start_of_year_timestamp = strtotime('first day of january', $current_timestamp);
$end_of_year_timestamp = strtotime('last day of december', $current_timestamp) + 86399; 

function getCurrentGetParams($paramToRemove = "") {
  $params = $_GET;
  if (count($params) === 0) {
    return "";
  }
  if (!empty($paramToRemove) && isset($params[$paramToRemove])) {
    unset($params[$paramToRemove]);
  }
  $paramStrings = array();
  foreach ($params as $key => $value) {
    $paramStrings[] = "$key=$value";
  }
  return "?" . implode("&", $paramStrings);
}
$currentParams=getCurrentGetParams();

$tierToCommission=array(
    "Tier 0"=>2,
    "Tier 1"=>2,
    "Tier 2"=>2,
    "Tier 3"=>3,
    "Tier 4"=>3.5,
    "Tier 5"=>4,
    "Tier 6"=>4,
    "Tier 7"=>4.5,
    "Tier 8"=>5,
    "Tier 9"=>7,
    "Tier 10"=>10,
);

function aasort (&$array, $key) {
    $sorter = array();
    $ret = array();
    reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii] = $va[$key];
    }
    asort($sorter);
    foreach ($sorter as $ii => $va) {
        $ret[$ii] = $array[$ii];
    }
    $array = $ret;
}

if($logged==0)
    header("Location:index.php");
    
//adding user
if(isset($_POST['create_package'])){
    $actionId = clear(($_POST['actionId']));
    $firstName = clear($_POST['firstName']);    
    $lastName = clear($_POST['lastName']);    
    $name=$firstName." ".$lastName;
    $codeId = clear($_POST['codeId']);    
    $email = clear($_POST['email']);    
    $phone = clear($_POST['phone']);    
    $instagram = clear($_POST['instagram']);    
    $facebook = clear($_POST['facebook']);    
    $tiktok = clear($_POST['tiktok']);
    $id=random();
    if($actionId=="")
        $query = "insert into tushantMarketing_salesPerson set id='$id' , name='$name', firstName='$firstName', lastName='$lastName', codeId='$codeId', email='$email', phone='$phone', instagram='$instagram', facebook='$facebook', tiktok='$tiktok'";
    else
        $query = "update tushantMarketing_salesPerson set name='$name', firstName='$firstName', lastName='$lastName', codeId='$codeId', email='$email', phone='$phone', instagram='$instagram', facebook='$facebook', tiktok='$tiktok' where id='$actionId'";
    runQuery($query);
    $string = ($actionId=="") ? "added" : "edited";
    header("Location:?search=$codeId&m=Sales Person data has been $string successfully");
}
    
if(isset($_GET['delete-user'])){
    $id = clear($_GET['delete-user']);
    $query="delete from tushantMarketing_salesPerson where id='$id'";
    runQuery($query);
    
    $currentParams=getCurrentGetParams('delete-user');
    $currentParams = ($currentParams=="") ? "?":"$currentParams&";
    header("Location:$currentParams m=Sales Person has been deleted successfully");
}

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
    $totalPages=getRow($con,"select count(id) as totalPages,max(autoIncrement) as maxAutoInc from tushantMarketing_salesPerson");
//if search then calculate total page for that search result
else if($searchEnabled){
    $query="select count(id) as totalPages,max(autoIncrement) as maxAutoInc from tushantMarketing_salesPerson where name like '%$search%' or salesTier like '%$search%' or email like '%$search%' or phone like '%$search%' or codeId like '%$search%' ";
    $totalPages=getRow($con,$query);
}
 
$maxAutoInc=$totalPages['maxAutoInc']+1;//adding plus one to display correct results 
$totalPages=ceil($totalPages['totalPages']/10);

//if new page or next page is opened then reference point is last entry no
if((!isset($_GET['page'])) || (isset($_GET['lastEntryNo']))){
    $query="select * from tushantMarketing_salesPerson where autoIncrement > $lastEntryNo order by autoIncrement asc limit 10";
    if($searchEnabled)
        $query="select * from tushantMarketing_salesPerson where autoIncrement > $lastEntryNo and (name like '%$search%' or email like '%$search%' or salesTier like '%$search%' or phone like '%$search%' or codeId like '%$search%') order by autoIncrement asc limit 10";
}
else{//means that previous page is opened
    $query="select * from tushantMarketing_salesPerson where autoIncrement < $firstEntryNo order by autoIncrement desc limit 10";
    if($searchEnabled)
        $query="select * from tushantMarketing_salesPerson where autoIncrement < $firstEntryNo and (name like '%$search%' or email like '%$search%' or salesTier like '%$search%' or phone like '%$search%' or codeId like '%$search%') order by autoIncrement desc limit 10";
}
$displayLeads=getAll($con,$query);

//sorting in ascending order because result was fetched in descending order
if(isset($_GET['firstEntryNo']))
    aasort($displayLeads, "autoIncrement");


//this would be passed in pagination 
$lastEntryNo=max(array_column($displayLeads, 'autoIncrement'));
$firstEntryNo=min(array_column($displayLeads, 'autoIncrement'));



//payroll for prevMonth
$salesPersonIdToPayroll=[];
$timestamp = time(); 
$prev_month = strtotime("-1 month", $timestamp);
$prevMonthName = date("F", $prev_month);
foreach($displayLeads as $row){
    $salesPersonId=$row['id'];
    $payRoll=getRow($con,"select * from tushantMarketing_sales_person_payroll where salesPersonId='$salesPersonId' && month='$prevMonthName'");
    if(count($payRoll)>2){
        $salesPersonIdToPayroll[$salesPersonId]['amount']="$".$payRoll['totalAmount'];
        $salesPersonIdToPayroll[$salesPersonId]['paymentStatus']=$payRoll['paymentStatus'];
        $salesPersonIdToPayroll[$salesPersonId]['payrollId']=$payRoll['id'];
    }
    else{
        $salesPersonIdToPayroll[$salesPersonId]['amount']="Payroll Not Created";
        $salesPersonIdToPayroll[$salesPersonId]['paymentStatus']="Payroll Not Created";
        $salesPersonIdToPayroll[$salesPersonId]['payrollId']="Payroll Not Created";
    }
}


if(isset($_GET['payroll'])){
    $payroll=clear($_GET['payroll']);
    $query="update tushantMarketing_sales_person_payroll set paymentStatus='Paid' where id='$payroll'";
    runQuery($query);
    
    $currentParams=getCurrentGetParams('payroll');
    $currentParams = ($currentParams=="") ? "?":"$currentParams&";
    header("Location:$currentParams m=Payroll has been marked as completed successfully");
}

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
								<div class="alert alert-info"><? echo clear($_GET['m']) ?></div>
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
            										    <input type="text" name="search" class="form-control" placeholder="Input Search" value="<?echo clear($_GET['search'])?>">
            										    <input type="submit" class="btn btn-primary" value="Search">
                										<a href="#" data-toggle="modal" data-target="#add_sales_person" class="btn btn-brand btn-elevate btn-icon-sm ml-2" style="white-space: nowrap;">
                											<i class="la la-plus"></i>
                											New Record
                										</a>
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
                                                        <th>CodeId</th>
                                                        <th>Email</th>
                                                        <th>Phone</th>
                                                        <th>Instagram</th>
                                                        <th>Facebook</th>
                                                        <th>Tiktok</th>
                                                        <th>Sales Tier (Commission)</th>
                                                        <th>Sales (<?echo date("D",time());?>)</th>
                                                        <th>Sales <br>(<?echo $start_of_week." Till ".$end_of_week?>)</th>
                                                        <th>Sales (<?echo date("M",time());?>)</th>
                                                        <th>Sales (<?echo date("Y",time());?>)</th>
                                                        <th>PayRoll(<?echo $prevMonthName?>)</th>
                                                        <th>Total Sales</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?
                                                $currentParams=getCurrentGetParams('m');
                                                $currentParams = ($currentParams=="") ? "?":"$currentParams&";
                                                foreach($displayLeads as $row){
                                                    $codeId=$row['codeId'];
                                                    $weeklySales=getRow($con,"select count(id) as weeklySales from tushantMarketing_clients where paymentStatus='Paid' && code='$codeId' && timeAdded between $start_of_week_timestamp and $end_of_week_timestamp")['weeklySales'];
                                                    $todaySales=getRow($con,"select count(id) as todaySales from tushantMarketing_clients where paymentStatus='Paid' && code='$codeId' && timeAdded between $start_of_today_timestamp and $end_of_today_timestamp")['todaySales'];
                                                    $monthlySales=getRow($con,"select count(id) as monthlySales from tushantMarketing_clients where paymentStatus='Paid' && code='$codeId' && timeAdded between $start_of_month_timestamp and $end_of_month_timestamp")['monthlySales'];
                                                    $yearlySales=getRow($con,"select count(id) as yearlySales from tushantMarketing_clients where paymentStatus='Paid' && code='$codeId' && timeAdded between $start_of_year_timestamp and $end_of_year_timestamp")['yearlySales'];
                                                    $commission=$tierToCommission[$row['salesTier']];
                                                    ?>
                                                        <tr>
                                                            <td><?echo $row['firstName']?></td>
                                                            <td><?echo $row['lastName']?></td>
                                                            <td><?echo $row['codeId']?></td>
                                                            <td><?echo $row['email']?></td>
                                                            <td><?echo $row['phone']?></td>
                                                            <td><?echo $row['instagram']?></td>
                                                            <td><?echo $row['facebook']?></td>
                                                            <td><?echo $row['tiktok']?></td>
                                                            <td><?echo $row['salesTier']."  ( $".$commission." )"?></td>
                                                            <td><?echo $todaySales." ( $".$commission*$todaySales." )";?></td>
                                                            <td><?echo $weeklySales." ( $".$commission*$weeklySales." )";?></td>
                                                            <td><?echo $monthlySales." ( $".$commission*$monthlySales." )";?></td>
                                                            <td><?echo $yearlySales." ( $".$commission*$yearlySales." )";?></td>
                                                            <td>
                                                                <?if($salesPersonIdToPayroll[$row['id']]['amount']!="Payroll Not Created"){
                                                                    $amount=$salesPersonIdToPayroll[$row['id']]['amount'];
                                                                    $color=($salesPersonIdToPayroll[$row['id']]['paymentStatus']=="Paid") ? "primary":"danger";
                                                                    $btn="<a class='btn btn-$color btn-sm text-white'>$amount</a>";
                                                                    echo $btn;
                                                                }
                                                                else{
                                                                    echo $salesPersonIdToPayroll[$row['id']]['amount'];
                                                                }?>
                                                            </td>
                                                            <td><?echo $row['totalSales'];?></td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <?
                                                                    if($salesPersonIdToPayroll[$row['id']]['paymentStatus']=="Not Paid"){?>
                                                                    <a href="<?echo $currentParams?>payroll=<?echo $salesPersonIdToPayroll[$row['id']]['payrollId']?>" class="btn btn-warning text-white">Pay</a>
                                                                    <?}?>
                                                                    
                                                                    <a href="viewSalesPerson.php?userId=<?echo $row['id'];?>" class="btn btn-primary">View</a>
                                                                    <a href="#" class="btn btn-warning text-white" data-toggle="modal" data-target="#add_sales_person" data-mydata='<?echo  htmlspecialchars(json_encode($row, true));?>' >Edit</a>
                                                                    <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#delete_record" data-url="<?echo $currentParams?>delete-user=<?echo $row['id']?>">Delete</a>
                                                                </div>
                                                            </td>
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
            							<!--end: Datatable -->
            						</div>
            					</div>
        				</div>
                    </div>
                </div>
			</div>
		</div>
		<!-- begin:: Footer -->
		<? require("./includes/views/footer.php") ?>
		<!-- end:: Footer -->
	</div>

	<? require("./includes/views/footerjs.php") ?>
</body>
<!-- end::Body -->
    <!--adding users modal-->
    <div class="modal fade" id="add_sales_person" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    	<div class="modal-dialog" role="document" style="max-width: 40%;">
    		<div class="modal-content">
    			<div class="modal-header">
    				<h5 class="modal-title" id="modelTitle">Insert</h5>
    				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    				</button>
    			</div>
    			<div class="modal-body">
    				<form class="kt-form" action="" method="Post" enctype="multipart/form-data">
    					<div class="kt-portlet__body">
    						
    						<!-- modal -->

                        <div style="padding: 10px;">
                        
                        <div class="form-group">
                            <label>FirstName</label>
                            <input type="text" name="firstName" class="form-control" required   >
                        </div>
                        	
                        <div class="form-group">
                            <label>LastName</label>
                            <input type="text" name="lastName" class="form-control" required   >
                        </div>
                        	
                        <div class="form-group">
                            <label>CodeId</label>
                            <input type="text" name="codeId" class="form-control" required   >
                        </div>
                        	
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required   >
                        </div>
                        	
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" required   >
                        </div>
                        	
                        <div class="form-group">
                            <label>Instagram</label>
                            <input type="text" name="instagram" class="form-control" required   >
                        </div>
                        	
                        <div class="form-group">
                            <label>Facebook</label>
                            <input type="text" name="facebook" class="form-control" required   >
                        </div>
                        	
                        <div class="form-group">
                            <label>Tiktok</label>
                            <input type="text" name="tiktok" class="form-control" required   >
                        </div>
                        	
                        <input type="text" name="actionId" value="" hidden>
                        
                        </div>
						<input type="text" name="actionId" value="" hidden>
    					</div>
    					<div class="kt-portlet__foot text-center">
    						<div class="kt-form__actions">
    							<input type="submit" name="create_package" value="Submit" class="btn btn-primary">
    							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    						</div>
    					</div>
    				</form>
    			</div>
    		</div>
    	</div>
    </div>
    <script>
        $(document).ready(function(){
	        $("#add_sales_person").on('show.bs.modal', function (e) {
            var mydata = $(e.relatedTarget).data('mydata');
            console.log("mydata->",mydata);
            if(mydata!= null){
            	$("#modelTitle").html("Update Sales Person Details");            	
                $("input[name='firstName']").val(mydata['firstName'])                
                $("input[name='lastName']").val(mydata['lastName'])                
                $("input[name='codeId']").val(mydata['codeId'])                
                $("input[name='codeId']").prop('readonly', true);
                
                $("input[name='email']").val(mydata['email'])                
                $("input[name='phone']").val(mydata['phone'])                
                $("input[name='instagram']").val(mydata['instagram'])                
                $("input[name='facebook']").val(mydata['facebook'])                
                $("input[name='tiktok']").val(mydata['tiktok'])                                
                $("input[name='actionId']").val(mydata['id'])
            }else{
                $("#modelTitle").html("Add Sales Person Details");
                $("input[name='codeId']").prop('readonly', false);
                
                $("input[name='firstName']").val("")
                $("input[name='lastName']").val("")
                $("input[name='codeId']").val("<?$random=random(6);echo $random;?>")
                $("input[name='email']").val("")
                $("input[name='phone']").val("")
                $("input[name='instagram']").val("")
                $("input[name='facebook']").val("")
                $("input[name='tiktok']").val("")
            
                $("input[name='actionId']").val("")
            }
        });
    })
</script>

</html>