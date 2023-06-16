<?require("./global.php");
if($logged==0)
    header("Location:index.php");

$timeStamp=strtotime(clear($_GET['timeStamp']));
if(!isset($_GET['timeStamp']))
    $timeStamp=time();
$memberShipCost=19.99;
    
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


$totalSales=getRow($con,"select count(id) as totalSales from tushantMarketing_clients where paymentStatus='Paid'")['totalSales'];;
$weeklySales=getRow($con,"select count(id) as weeklySales from tushantMarketing_clients where  paymentStatus='Paid' && timeAdded between $start_of_week_timestamp and $end_of_week_timestamp")['weeklySales'];;
$monthlySales=getRow($con,"select count(id) as monthlySales from tushantMarketing_clients where  paymentStatus='Paid' && timeAdded between $start_of_month_timestamp and $end_of_month_timestamp")['monthlySales'];
$yearlySales=getRow($con,"select count(id) as yearlySales from tushantMarketing_clients where  paymentStatus='Paid' && timeAdded between $start_of_year_timestamp and $end_of_year_timestamp")['yearlySales'];;

$totalPayroll=getRow($con,"SELECT sum(totalAmount) as totalPayroll from tushantMarketing_sales_person_payroll;")['totalPayroll'];;
$monthlyPayroll=getRow($con,"select sum(totalAmount) as monthlyPayroll from tushantMarketing_sales_person_payroll where forMonth between $start_of_month_timestamp and $end_of_month_timestamp")['monthlyPayroll'];
$yearlyPayroll=getRow($con,"select sum(totalAmount) as yearlyPayroll from tushantMarketing_sales_person_payroll where forMonth between $start_of_year_timestamp and $end_of_year_timestamp")['yearlyPayroll'];

$totalPayroll=($totalPayroll=="") ? "0" : $totalPayroll;
$monthlyPayroll=($monthlyPayroll=="") ? "0" : $monthlyPayroll;
$yearlyPayroll=($yearlyPayroll=="") ? "0" : $yearlyPayroll;



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
        $sales=getRow($con,"select count(id) as sales from tushantMarketing_clients where paymentStatus='Paid' && timeAdded between $start_timestamp and $end_timestamp")['sales'];
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
    $sales=getRow($con,"select count(id) as sales from tushantMarketing_clients where paymentStatus='Paid' && timeAdded between $start_timestamp and $end_timestamp")['sales'];
    $monthlyDistribution[] = array(
        'monthName' => date("F",$start_timestamp),
        'monthColor' => $monthlyColors[$month-1],
        'noSales' => $sales,
        
    );
}

//top sales persons
$query="SELECT concat(sp.firstName,' ',sp.lastName) as name,count(sp.id) as noSales from tushantMarketing_salesPerson sp inner join 
tushantMarketing_clients c on sp.codeId=c.code where c.paymentStatus='Paid' && c.timeAdded between $start_of_month_timestamp and $end_of_month_timestamp group by sp.id order by count(sp.id) desc limit 5";
$topSalesPersons=getAll($con,$query);



//leads in the system
$totalLeadsMonthly=getRow($con,"select count(id) as leads from tushantMarketing_clients where paymentStatus='Pending' and timeAdded between $start_of_month_timestamp and $end_of_month_timestamp")['leads'];
$totalClientsMonthly=getRow($con,"select count(id) as leads from tushantMarketing_clients where paymentStatus='Paid' and timeAdded between $start_of_month_timestamp and $end_of_month_timestamp")['leads'];
$totalCancelledUsersMonthly=getRow($con,"select count(id) as leads from tushantMarketing_clients where paymentStatus='Cancelled' and timeCancelled between $start_of_month_timestamp and $end_of_month_timestamp")['leads'];

$totalLeads=getRow($con,"select count(id) as leads from tushantMarketing_clients where paymentStatus='Pending' ")['leads'];
$totalClients=getRow($con,"select count(id) as leads from tushantMarketing_clients where paymentStatus='Paid' ")['leads'];
$totalCancelledUsers=getRow($con,"select count(id) as leads from tushantMarketing_clients where paymentStatus='Cancelled'")['leads'];

        
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
							        <div class="alert alert-info"><?echo $_GET['m']?></div>
							    <?}?>
						        <div class="row">
						            
						            <div class="col-12 ">
                                      <form method="get" action="" enctype="multipart/form-data">
                                        <div class="row">
                                          <div class="col-12 d-flex justify-content-center " style="margin-bottom:20px;">
                                            <h3 style="margin-top: 5px;">Input Date : </h3>
                                            <input type="date" name="timeStamp" class="form-control" value="<?echo date("Y-m-d",$timeStamp);?>" style="margin-left: 10px;width:40%">
                                          </div>
                                        </div>
                                      </form>
                                    </div>
						            <div class="col-12">
					                    <!--basic information-->
					                        <div class="kt-portlet ">
            									<div class="kt-portlet__body">
            										<div class="kt-widget kt-widget--user-profile-3">
            											<div class="kt-widget__top">
            												<div class="kt-widget__content">
            													<div class="kt-widget__head">
            													    <a class="kt-widget__username ">System Information</a>
            													</div>
            													<div class="kt-widget__subhead" style="font-size: initial;">
        													        <div class="row">
            													        <div class="col-md-4 col-xs-6 col-xl-4 col-sm-6">
            													            <label>Total Sales: <b><?echo $totalSales?></b></label>
            													        </div>
            													        <div class="col-md-4 col-xs-6 col-xl-4 col-sm-6">
            													            <label>Year Sales (<?echo date("Y",$timeStamp)?>) : <b><?echo $yearlySales?></b></label>
            													        </div>
            													        <div class="col-md-4 col-xs-6 col-xl-4 col-sm-6">
            													            <label>Month Sales (<?echo date("M Y",$timeStamp)?>) : <b><?echo $monthlySales?></b></label>
            													        </div>
            													        
            													        <div class="col-md-4 col-xs-6 col-xl-4 col-sm-6">
            													            <label>Total Clients: <b><?echo $totalLeads?></b></label>
            													        </div>
            													        <div class="col-md-4 col-xs-6 col-xl-4 col-sm-6">
            													            <label>Total Leads: <b><?echo $totalClients?></b></label>
            													        </div>
            													        <div class="col-md-4 col-xs-6 col-xl-4 col-sm-6">
            													            <label>Total Cancelled Clients: <b><?echo $totalCancelledUsers?></b></label>
            													        </div>
            													        
            													        <div class="col-md-4 col-xs-6 col-xl-4 col-sm-6">
            													            <label>Total Revenue: <b><?echo $totalSales*$memberShipCost?></b></label>
            													        </div>
            													        <div class="col-md-4 col-xs-6 col-xl-4 col-sm-6">
            													            <label>Year Revenue (<?echo date("Y",$timeStamp)?>) : <b><?echo $yearlySales*$memberShipCost?></b></label>
            													        </div>
            													        <div class="col-md-4 col-xs-6 col-xl-4 col-sm-6">
            													            <label>Month Revenue (<?echo date("M Y",$timeStamp)?>) : <b><?echo $monthlySales*$memberShipCost?></b></label>
            													        </div>
            													        <div class="col-md-4 col-xs-6 col-xl-4 col-sm-6">
            													            <label>Total Payroll: <b><?echo "$".$totalPayroll?></b></label>
            													        </div>
            													        <div class="col-md-4 col-xs-6 col-xl-4 col-sm-6">
            													            <label>Year Payroll (<?echo date("Y",$timeStamp)?>) : <b><?echo "$".$yearlyPayroll?></b></label>
            													        </div>
            													        <div class="col-md-4 col-xs-6 col-xl-4 col-sm-6">
            													            <label>Month Payroll (<?echo date("M Y",$timeStamp)?>) : <b><?echo "$".$monthlyPayroll?></b></label>
            													        </div>
            													        
            													    </div>
                											    </div>
            												</div>
            											</div>
            										</div>
            									</div>
            								</div>
						            </div>
						            
						            <!-- top 5 sales person-->
						            <div class="col-xs-12 col-md-6">
						                <div class="kt-portlet kt-portlet--height-fluid">
								            <div class="kt-widget14">
												<div class="kt-widget14__header">
													<h3 class="kt-widget14__title">
														Top 5 Sales Person For Month : <?echo date("F",$timeStamp);?>
													</h3>
												</div>
												<div class="kt-widget14__content">
													<div class="kt-widget14__chart">
														<div id="kt_chart_topSalesPerson" class="customWidth"></div>
													</div>
													<div class="kt-widget14__legends">
														<?foreach($topSalesPersons as $i=>$row){?>
														<div class="kt-widget14__legend">
															<span class="kt-widget14__bullet kt-bg-<?echo $monthlyColors[$i]?>" <?if($monthlyColors[$i]=="success"){echo "style='background-color: #34bfa3 !important;'";}?>></span>
															<span class="kt-widget14__stats"><?echo $row['noSales']." X ".$memberShipCost." = $".$row['noSales']*$memberShipCost?></span>
														</div>
														<?}?>
													</div>
												</div>
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
															<span class="kt-widget14__stats"><?echo "Week ".($i+1)." : ".$row['noSales']." X ".$memberShipCost." = $".$row['noSales']*$memberShipCost?></span>
														</div>
														<?}?>
													</div>
												</div>
											</div>
										</div>
						            </div>
						            
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
															<span class="kt-widget14__stats"><?echo $row['monthName']." : ".$row['noSales']." X ".$memberShipCost." = $".$row['noSales']*$memberShipCost?></span>
														</div>
														<?}?>
													</div>
												</div>
											</div>
										</div>
						            </div>
						            
						            <div class="col-xs-12 col-md-6">
						                <div class="kt-portlet kt-portlet--height-fluid">
								            <div class="kt-widget14">
												<div class="kt-widget14__header">
													<h3 class="kt-widget14__title">
														Clients Vs Cancelled Clients Vs Leads
													</h3>
												</div>
												<div class="kt-widget14__content">
													<div class="kt-widget14__chart">
														<div id="kt_chart_leads" class="customWidth"></div>
													</div>
													<div class="kt-widget14__legends">
														<div class="kt-widget14__legend">
															<span class="kt-widget14__bullet kt-bg-primary"></span>
															<span class="kt-widget14__stats">Clients : <?echo $totalClientsMonthly?></span>
														</div>
														<div class="kt-widget14__legend">
															<span class="kt-widget14__bullet kt-bg-warning"></span>
															<span class="kt-widget14__stats">Leads : <?echo $totalLeadsMonthly?></span>
														</div>
														<div class="kt-widget14__legend">
															<span class="kt-widget14__bullet kt-bg-danger"></span>
															<span class="kt-widget14__stats">Cancelled Clients : <?echo $totalCancelledUsersMonthly?></span>
														</div>
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
        
        Morris.Donut({
            element: 'kt_chart_topSalesPerson',
            data: [
                <?foreach($topSalesPersons as $row){?>
                {
                    label: "<?echo $row['name']?>",
                    value: <?echo $row['noSales']?>
                },
                <?}?>
            ],
            colors: [
                <?foreach($topSalesPersons as $i=>$row){?>
                KTApp.getStateColor('<?echo $monthlyColors[$i]?>'),
                <?}?>
            ],
        });
        
        Morris.Donut({
            element: 'kt_chart_leads',
            data: [
                {
                    label: "Clients",
                    value: <?echo $totalClientsMonthly?>
                },
                {
                    label: "Leads",
                    value: <?echo $totalLeadsMonthly?>
                },
                {
                    label: "Cancelled Clients",
                    value: <?echo $totalCancelledUsersMonthly?>
                },
            ],
            colors: [
                KTApp.getStateColor('primary'),
                KTApp.getStateColor('warning'),
                KTApp.getStateColor('danger'),
            ],
        });
        
        
        
        
    }

    </script>
    
    
</html>