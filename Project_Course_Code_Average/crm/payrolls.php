<?require("./global.php");

require_once('vendor/autoload.php');
\Stripe\Stripe::setApiKey($g_stripeCred['private_test_key']); 

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

if(isset($_POST['addPayroll'])){
    $forMonth=strtotime(clear($_POST['forMonth']));
    $month=strtotime(clear($_POST['forMonth']));
    $payRollId=random();
    $monthName=date('F',$month);
    
    $start_of_month_timestamp = strtotime('first day of this month', $month);
    $end_of_month_timestamp = strtotime('last day of this month', $month) + 86399; 

    $query="select * from tushantMarketing_payrolls where forMonthTimeStamp between $start_of_month_timestamp and $end_of_month_timestamp";
    $result=runQueryResult($query);
    if(mysqli_num_rows($result)>=1){//which means that the payroll has already been created for this month
        header("Location:?m=Payroll cannot be created for this month as another payroll has already been created");
        exit();
    }
    
    //if someone cancelled by call (who is already an active payment client) then we will check for every client whose subscription is valid that whether he cancelled by call or not 
    $activeClients=getAll($con,"select * from tushantMarketing_clients where paymentStatus='Paid'");
    foreach($activeClients as $row){
        $subscription = \Stripe\Subscription::retrieve($row['subscriptionId']);
        $codeId=$row['code'];
        $clientId=$row['id'];
        if ($subscription->status != 'active') {
            //decreasing the sales of the salesperson whose code was used by this client
            $query="update tushantMarketing_salesPerson set totalSales=totalSales-1 where codeId='$codeId'";
            runQuery($query);
            
            $timeCancelled=time();
            $query="update tushantMarketing_clients set paymentStatus='Cancelled',timeCancelled='$timeCancelled' where id='$clientId'";
            runQuery($query);
        }
    }

    $salesPersons=getAll($con,"select * from tushantMarketing_salesPerson");
    foreach($salesPersons as $row){
        $salesPersonId=$row['id'];
        $codeId=$row['codeId'];
        $salesCommission=$tierToCommission[$row['salesTier']];
        $monthlySales=getRow($con,"select count(id) as monthlySales from tushantMarketing_clients where code='$codeId' && timeAdded between $start_of_month_timestamp and $end_of_month_timestamp && paymentStatus='Paid'")['monthlySales'];
        
        $totalAmount=$monthlySales*$salesCommission;
        //checking if this sales person was awarded a bonus
        $checkBonus=getRow($con,"select * from tushantMarketing_bonus where salesPersonId='$salesPersonId' && timeAdded between $start_of_month_timestamp and $end_of_month_timestamp");
        $bonus=0;$whyBonus="No Bonus";
        if(count($checkBonus)>2){//bonus was awarded
            $totalAmount+=$checkBonus['bonusAwarded'];
            $bonus=$checkBonus['bonusAwarded'];
            $whyBonus="Upgraded To ".$checkBonus['upgradedTo'];
        }
        
        $id=random();
        $timeAdded=time();
        $query="insert into tushantMarketing_sales_person_payroll set id='$id',forMonth='$forMonth',payRollId='$payRollId',salesPersonId='$salesPersonId',month='$monthName',sales='$monthlySales',commission='$salesCommission',
        totalAmount='$totalAmount',whyBonus='$whyBonus',bonus='$bonus',timeAdded='$timeAdded'";
        runQuery($query);
    }
    $query="insert into tushantMarketing_payrolls set id='$payRollId',forMonth='$monthName',forMonthTimeStamp='$forMonth',timeAdded='$timeAdded'";
    runQuery($query);
    header("Location:?m=Payrolls Have Been Generated Successfully");
}

if(isset($_GET['delete-payroll'])){
    $payrollId=clear($_GET['delete-payroll']);
    $query="delete from tushantMarketing_payrolls where id='$payrollId'";
    runQuery($query);
    
    $query="delete from tushantMarketing_sales_person_payroll where payRollId='$payrollId'";
    runQuery($query);
    
    header("Location:?m=Payrolls Have Been Deleted Successfully");
}
?>
<!DOCTYPE html>


<html lang="en">

	<!-- begin::Head -->
	<head>
	    <?require("./includes/views/head.php")?>
	</head>
    
    <body class="<?echo $g_body_class?>" onload="">
        <?require("./includes/views/header.php")?>
        <div class="kt-grid kt-grid--hor kt-grid--root">
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
                    <?require("./includes/views/topmenu.php")?>
					<?require("./includes/views/leftmenu.php")?>
                    <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
						<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
                            <div class="kt-container  kt-grid__item kt-grid__item--fluid">
                                            
    							<? if (isset($_GET['m'])) { ?>
    								<div class="alert alert-info"><? echo clear($_GET['m']) ?></div>
    							<? } ?>
                        
    			                <div class="kt-portlet kt-portlet--mobile">
                						<div class="kt-portlet__head kt-portlet__head--lg">
                							<div class="kt-portlet__head-label">
                								<span class="kt-portlet__head-icon">
                								</span>
                								<h3 class="kt-portlet__head-title">
                								    Payroll
                								</h3>
                							</div>
                							<div class="kt-portlet__head-toolbar">
                								<div class="kt-portlet__head-wrapper">
                									<div class="kt-portlet__head-actions">
                									    <a href="#" data-toggle="modal" data-target="#add_payroll" class="btn btn-brand btn-elevate btn-icon-sm ml-2">
                											<i class="la la-plus"></i>
                											New Record
                										</a>
        										    </div>
                								</div>
                							</div>
                							
                						</div>
                						<div class="kt-portlet__body">
                						    <table class="table table-striped- table-bordered table-hover table-checkable add-search" >
                                                <thead>
                                                    <tr>
                                                       <th>Payroll For Month</th>
                                                       <th>Date Created</th>
                                                       <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?$payrolls=getAll($con,"select * from tushantMarketing_payrolls order by timeAdded desc");
                                                    foreach($payrolls as $row){?>
                                                        <tr>
                                                            <td><?echo $row['forMonth'];?></td>
                                                            <td><?echo date("d M Y",$row['timeAdded'])?></td>
                                                            <td>
                                                                <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#delete_record" data-url="?delete-payroll=<?echo $row['id']?>">Delete</a>
                                                            </td>
                                                        </tr>
                                                    <?}?>
                                                </tbody>
                                            </table>
                                        </div>
                					</div>
    			            
    				
							</div>
                        </div>
					</div>
					<?require("./includes/views/footer.php")?>
                </div>
			</div>
		</div>
        <?require("./includes/views/footerjs.php")?>
	</body>
	
	
	
<div class="modal fade" id="add_payroll" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    	<div class="modal-dialog" role="document" style="max-width: 40%;">
    		<div class="modal-content">
    			<div class="modal-header">
    				<h5 class="modal-title" id="modelTitle">Add Payroll For A Particular Month</h5>
    				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    				</button>
    			</div>
    			<div class="modal-body">
    				<form class="kt-form" action="" method="Post" enctype="multipart/form-data">
    					<div class="kt-portlet__body">
    					    <div style="padding:10px;">
                                <div class="form-group">
                                    <label>Select Date</label>
                                    <?
                                    $timestamp = strtotime("-1 month");
                                    $timestamp_of_previous_month = strtotime(date("Y-m-d", $timestamp));
                                    ?>
                                    <input type="date" name="forMonth" class="form-control"  value="<?echo date("Y-m-d",$timestamp_of_previous_month);?>" >
                                </div>
                            </div>
        				</div>
    					<div class="kt-portlet__foot text-center">
    						<div class="kt-form__actions">
    							<input type="submit" name="addPayroll" value="Submit" class="btn btn-primary">
    							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    						</div>
    					</div>
    				</form>
    			</div>
    		</div>
    	</div>
    </div>
</html>