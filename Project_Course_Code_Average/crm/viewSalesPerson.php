<?require("./global.php");

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
$userId = clear($_GET['userId']);
$userDeets = getRow($con, "select * from tushantMarketing_salesPerson where id='$userId'");

$timeStamp=strtotime(clear($_GET['timeStamp']));
if(!isset($_GET['timeStamp']))
    $timeStamp=time();

$current_timestamp = $timeStamp;
$day_of_week = date('w', $current_timestamp);

$start_of_week_timestamp = strtotime("-$day_of_week day", $current_timestamp);
$end_of_week_timestamp = strtotime("+".(6-$day_of_week)." day", $current_timestamp);

$start_of_week = date('d M Y', $start_of_week_timestamp);
$end_of_week = date('d M Y', $end_of_week_timestamp);

$start_of_month_timestamp = strtotime('first day of this month', $current_timestamp);
$end_of_month_timestamp = strtotime('last day of this month', $current_timestamp) + 86399; 

$start_of_year_timestamp = strtotime('first day of january', $current_timestamp);
$end_of_year_timestamp = strtotime('last day of december', $current_timestamp) + 86399; 

$commission=$tierToCommission[$userDeets['salesTier']];
$codeId=$userDeets['codeId'];
$weeklySales=getRow($con,"select count(id) as weeklySales from tushantMarketing_clients where paymentStatus='Paid' && code='$codeId' && timeAdded between $start_of_week_timestamp and $end_of_week_timestamp")['weeklySales'];;
$monthlySales=getRow($con,"select count(id) as monthlySales from tushantMarketing_clients where paymentStatus='Paid' && code='$codeId' && timeAdded between $start_of_month_timestamp and $end_of_month_timestamp")['monthlySales'];
$yearlySales=getRow($con,"select count(id) as yearlySales from tushantMarketing_clients where paymentStatus='Paid' && code='$codeId' && timeAdded between $start_of_year_timestamp and $end_of_year_timestamp")['yearlySales'];;


//getting weekly sales distribution
$month = date('m',$timeStamp);
$year = date('Y',$timeStamp);
$num_days = date('t', strtotime("$year-$month-01"));
$monthlyColors=["primary","warning","success","danger","primary","warning","success","danger","primary","warning","success","danger"];
$i=0;
for ($day = 1; $day <= $num_days; $day++) {
    $weekday = date('w', strtotime("$year-$month-$day"));
    if ($weekday == 0) {
        $start_timestamp = strtotime("$year-$month-$day");
        $end_timestamp = strtotime("$year-$month-" . ($day + 6 > $num_days ? $num_days : $day + 6))+86040;
        $sales=getRow($con,"select count(id) as sales from tushantMarketing_clients where paymentStatus='Paid' && code='$codeId' && timeAdded between $start_timestamp and $end_timestamp")['sales'];
        $weeklySalesDistribution[] = array(
            'noSales' => $sales,
            'startDate' => date("d M",$start_timestamp),
            'endDate' => date("d M",$end_timestamp),
            'weekColor' => $monthlyColors[$i],
        );
        $i++;
    }
}

//monthly sales distribution for the input year
for ($month = 1; $month <= 12; $month++) {
    $start_timestamp = mktime(0, 0, 0, $month, 1, $year);
    $end_timestamp = mktime(23, 59, 59, $month + 1, 0, $year);
    $sales=getRow($con,"select count(id) as sales from tushantMarketing_clients where paymentStatus='Paid' && code='$codeId' && timeAdded between $start_timestamp and $end_timestamp")['sales'];
    $monthlyDistribution[] = array(
        'monthName' => date("F",$start_timestamp),
        'monthColor' => $monthlyColors[$month-1],
        'noSales' => $sales,
        
    );
}


if(isset($_GET['payroll'])){
    $payroll=clear($_GET['payroll']);
    $query="update tushantMarketing_sales_person_payroll set paymentStatus='Paid' where id='$payroll'";
    runQuery($query);
    
    header("Location:?userId=$userId&m=Payroll has been marked as paid");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?require("./includes/views/head.php")?>
        <style>
    	    .format {
              display: flex;
              flex-direction: column;
              align-items: flex-start;
              margin-bottom: 20px;
            }
            
            .format label {
              margin-bottom: 5px;
              font-weight: bold;
            }
            
            .customWidth{
                height:300px;
                width:300px;
            }
            @media only screen and (max-width: 400px) {
                .customWidth{
                    height:200px;
                    width:200px;
                }
            }
    	</style>
    </head>
    <body class="<?echo $g_body_class?>">
        <?require("./includes/views/header.php")?>
        <div class="kt-grid kt-grid--hor kt-grid--root">
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
                    <?require("./includes/views/topmenu.php")?>
					<div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
						<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
                            <div class="kt-container  kt-grid__item kt-grid__item--fluid">
							    
							    <?if(isset($_GET['m'])){?>
							        <div class="alert alert-info"><?echo clear($_GET['m'])?></div>
							    <?}?>
						        <div class="row">
						            
						            <div class="col-12 ">
                                      <form method="get" action="" enctype="multipart/form-data">
                                        <div class="row">
                                          <div class="col-12 d-flex justify-content-center " style="margin-bottom:20px;">
                                            <h3 style="margin-top: 5px;">Input Date : </h3>
                                            <input type="date" name="timeStamp" class="form-control" value="<?echo date("Y-m-d",$timeStamp);?>" style="margin-left: 10px;width:20%">
                                            <input type="text" name="userId" value="<?echo $userId?>" hidden>
                                          </div>
                                        </div>
                                      </form>
                                    </div>
						            <div class="col-xs-12 col-md-6">
					                    <!--user information-->
					                        <div class="kt-portlet ">
            									<div class="kt-portlet__body">
            										<div class="kt-widget kt-widget--user-profile-3">
            											<div class="kt-widget__top">
            												<div class="kt-widget__pic kt-widget__pic--danger kt-font-danger kt-font-boldest kt-font-light" style="margin-top: 30px;">
            													<?echo strtoupper(substr($userDeets['name'], 0, 2));?>
            												</div>
            												<div class="kt-widget__content">
            													<div class="kt-widget__head">
            													    <a class="kt-widget__username ">User Information</a>
            													</div>
            													<div class="kt-widget__subhead" style="font-size: initial;">
            													    <div class="format">
                                                                        <label>Name:</label>
                                                                        <p><?echo $userDeets['name'];?></p>
                                                                        <label>Email:</label>
                                                                        <p><?echo $userDeets['email']?></p>
                                                                        <label>Phone:</label>
                                                                        <p><?echo $userDeets['phone']?></p>
                                                                        <label>Instagram:</label>
                                                                        <p><?echo $userDeets['instagram']?></p>
                                                                        <label>Facebook:</label>
                                                                        <p><?echo $userDeets['facebook']?></p>
                                                                        <label>Tiktok:</label>
                                                                        <p><?echo $userDeets['tiktok']?></p>
                                                                        <label>Time Added:</label>
                                                                        <p><?echo date("d M Y",$userDeets['timeAdded'])?></p>
                                                                    </div>
                											    </div>
            												</div>
            											</div>
            										</div>
            									</div>
            								</div>
						            </div>
						            <div class="col-xs-12 col-md-6">
						                <!--sales information-->
						                <div class="kt-portlet ">
        									<div class="kt-portlet__body">
        										<div class="kt-widget kt-widget--user-profile-3">
        											<div class="kt-widget__top">
        												<div class="kt-widget__content">
        													<div class="kt-widget__head">
        													    <a class="kt-widget__username ">Sales Information</a>
        													</div>
        													<div class="kt-widget__subhead" style="font-size: initial;">
        													    <div class="format">
                                                                    <label>Code ID:</label>
                                                                    <p><?echo $userDeets['codeId']?></p>
                                                                    <label>Current Tier:</label>
                                                                    <p><?echo $userDeets['salesTier']?></p>
                                                                    <label>Commission :</label>
                                                                    <p><?echo "$".$commission?></p>
                                                                    <label>Weekly Sales (<?echo $start_of_week." - ".$end_of_week?>) :</label>
                                                                    <p><?echo $weeklySales." x ".$commission." = $".$weeklySales*$commission?></p>
                                                                    <label>Monthly Sales (<?echo date("M Y",$timeStamp)?>) :</label>
                                                                    <p><?echo $monthlySales." x ".$commission." = $".$monthlySales*$commission?></p>
                                                                    <label>Yearly Sales (<?echo date("Y",$timeStamp)?>) :</label>
                                                                    <p><?echo $yearlySales." x ".$commission." = $".$yearlySales*$commission?></p>
                                                                    <label>Total Sales :</label>
                                                                    <p><?echo $userDeets['totalSales']." x ".$commission." = $".$userDeets['totalSales']*$commission?></p>
                                                                </div>
                                                            </div>
        												</div>
        											</div>
        										</div>
        									</div>
        								</div>
						            </div>
						            
						            
						            <!--payroll history-->
						            <div class="col-xs-12 col-md-7">
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
                        									    <?$totalPay=getRow($con,"select sum(totalAmount) as totalPay from tushantMarketing_sales_person_payroll where salesPersonId='$userId'")['totalPay'];?>
                        									    <a class="btn btn-primary btn-sm text-white">Total : <?echo "$".$totalPay;?></a>
                										    </div>
                        								</div>
                        							</div>
                        							
                        						</div>
                        						<div class="kt-portlet__body">
                        						    <table class="table table-striped- table-bordered table-hover table-checkable add-search" >
                                                        <thead>
                                                            <tr>
                                                               <th>Month</th>
                                                               <th>Sales</th>
                                                               <th>Per Sale Commission</th>
                                                               <th>Bonus</th>
                                                               <th>Total</th>
                                                               <th>Time Created</th>
                                                               <th>Payment Status</th>
                                                               <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?$payrolls=getAll($con,"select * from tushantMarketing_sales_person_payroll where salesPersonId='$userId'");
                                                            foreach($payrolls as $row){?>
                                                            <tr>
                                                                <td><?echo $row['month']?></td>
                                                                <td><?echo $row['sales']?></td>
                                                                <td><?echo $row['commission']?></td>
                                                                <td><?echo $row['whyBonus']." = $".$row['bonus']?></td>
                                                                <td><?echo $row['totalAmount']?></td>
                                                                <td><?echo date("d M Y",$row['timeAdded'])?></td>
                                                                <td>
                                                                    <?$color = ($row['paymentStatus']=="Not Paid") ? "danger":"primary";?>
                                                                    <a class="btn btn-<?echo $color?> btn-sm text-white"><?echo $row['paymentStatus']?></a>
                                                                </td>
                                                                <td>
                                                                    <?if($row['paymentStatus']=="Not Paid"){?>
                                                                    <a href="?userId=<?echo $userId?>&payroll=<?echo $row['id']?>" 
                                                                    onclick="return confirm('Are you sure you want to pay this payroll ? This action is irreversible')"
                                                                    class="btn btn-primary btn-sm">Pay</a>
                                                                    <?}?>
                                                                </td>
                                                            </tr>
                                                            <?}?>
                                                        </tbody>
                                                    </table>
                                                </div>
                        					</div>
						            </div>
						            
						            
						            <!--bonus history-->
						            <div class="col-xs-12 col-md-5">
						                <div class="kt-portlet kt-portlet--mobile">
                        						<div class="kt-portlet__head kt-portlet__head--lg">
                        							<div class="kt-portlet__head-label">
                        								<span class="kt-portlet__head-icon">
                        								</span>
                        								<h3 class="kt-portlet__head-title">
                        								    Bonus History
                        								</h3>
                        							</div>
                        							<div class="kt-portlet__head-toolbar">
                        								<div class="kt-portlet__head-wrapper">
                        									<div class="kt-portlet__head-actions">
                										    </div>
                        								</div>
                        							</div>
                        							
                        						</div>
                        						<div class="kt-portlet__body">
                        						    <table class="table table-striped- table-bordered table-hover table-checkable add-search" >
                                                        <thead>
                                                            <tr>
                                                               <th>Upgraded To</th>
                                                               <th>Bonus</th>
                                                               <th>Achievment Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?$bonus=getAll($con,"select * from tushantMarketing_bonus where salesPersonId='$userId'");
                                                            foreach($bonus as $row){?>
                                                                <tr>
                                                                    <td><?echo $row['upgradedTo']?></td>
                                                                    <td><?echo $row['bonusAwarded']?></td>
                                                                    <td><?echo date("d M Y",$row['timeAdded'])?></td>
                                                                </tr>
                                                            <?}?>
                                                        </tbody>
                                                    </table>
                                                </div>
                        					</div>
						            </div>
						            
						            
						            
						            
						            
						            
						            <!-- analytics weekly sales distribution-->
						            <div class="col-xs-12 col-md-6">
						                <div class="kt-portlet kt-portlet--height-fluid">
    								            <div class="kt-widget14">
    												<div class="kt-widget14__header">
    													<h3 class="kt-widget14__title">
    														Weekly Sales Distribution
    													</h3>
    												</div>
    												<div class="kt-widget14__content">
    													<div class="kt-widget14__chart">
    														<div id="kt_chart_weeklyDistribution" class="customWidth"></div>
    													</div>
    													<div class="kt-widget14__legends">
    														<?foreach($weeklySalesDistribution as $i=>$row){?>
    														<div class="kt-widget14__legend">
    															<span class="kt-widget14__bullet kt-bg-<?echo $row['weekColor']?>" <?if($row['monthColor']=="success"){echo "style='background-color: #34bfa3 !important;'";}?>></span>
    															<span class="kt-widget14__stats"><?echo "Week ".($i+1)." : ".$row['noSales']." X ".$commission." = $".$row['noSales']*$commission?></span>
    														</div>
    														<?}?>
    													</div>
    												</div>
    											</div>
											</div>
						            </div>
						            
						            
						            <!--monthly sales distribution-->
						            
						            <div class="col-xs-12 col-md-6">
						                <div class="kt-portlet kt-portlet--height-fluid">
    								            <div class="kt-widget14">
    												<div class="kt-widget14__header">
    													<h3 class="kt-widget14__title">
    														Monthly Sales Distribution
    													</h3>
    												</div>
    												<div class="kt-widget14__content">
    													<div class="kt-widget14__chart">
    														<div id="kt_chart_monthlyDistribution" class="customWidth"></div>
    													</div>
    													<div class="kt-widget14__legends">
    														<?foreach($monthlyDistribution as $row){?>
    														<div class="kt-widget14__legend">
    															<span class="kt-widget14__bullet kt-bg-<?echo $row['monthColor']?>"  <?if($row['monthColor']=="success"){echo "style='background-color: #34bfa3 !important;'";}?>></span>
    															<span class="kt-widget14__stats"><?echo $row['monthName']." : ".$row['noSales']." X ".$commission." = $".$row['noSales']*$commission?></span>
    														</div>
    														<?}?>
    													</div>
    												</div>
    											</div>
											</div>
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
    
    <script>
    jQuery(document).ready(function() {
        Distribution();
        $('input[name="timeStamp"]').on('change', function() {
            $(this).closest('form').submit();
        });
    });
    var Distribution = function() {
        Morris.Donut({
            element: 'kt_chart_weeklyDistribution',
            data: [
                <?$i=1;foreach($weeklySalesDistribution as $row){?>
                {
                    label: "Week <?echo $i;$i++;echo " : ".$row['startDate']." - ".$row['endDate'];?>",
                    value: <?echo $row['noSales']?>
                },
                <?}?>
            ],
            colors: [
                <?foreach($weeklySalesDistribution as $i=>$row){?>
                KTApp.getStateColor('<?echo $row['weekColor']?>'),
                <?}?>
            ],
        });
        
        Morris.Donut({
            element: 'kt_chart_monthlyDistribution',
            data: [
                <?foreach($monthlyDistribution as $row){?>
                {
                    label: "<?echo $row['monthName']?>",
                    value: <?echo $row['noSales']?>
                },
                <?}?>
            ],
            colors: [
                <?foreach($monthlyDistribution as $row){?>
                KTApp.getStateColor('<?echo $row['monthColor']?>'),
                <?}?>
            ],
        });
    }

    </script>
    
    
</html>