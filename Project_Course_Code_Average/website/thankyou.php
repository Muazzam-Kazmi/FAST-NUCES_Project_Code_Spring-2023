<?
require("global.php");
require_once('vendor/autoload.php');

\Stripe\Stripe::setApiKey($g_stripeCred['private_test_key']); 

$clientId=clear($_GET['clientId']);
//this means that this client has completed the signup
if(isset($_GET['clientId'])){
    
    $subscriptionId=clear($_GET['subscriptionId']);
    $session = \Stripe\Checkout\Session::retrieve($subscriptionId);
    $subscriptionId = $session->subscription;

    $query="update tushantMarketing_clients set paymentStatus='Paid',subscriptionId='$subscriptionId' where id='$clientId'";
    runQuery($query);
    
    $clientDeets=getRow($con,"select * from tushantMarketing_clients where id='$clientId'");
    
    //update the salesperson sales whose code has been entered
    $codeId=$clientDeets['code'];
    $query="update tushantMarketing_salesPerson set totalSales=totalSales+1 where codeId='$codeId'";
    runQuery($query);
    
    //if by increasing the sales, tier is changing then change tier
    $updateTier=0;
    $bonus=0;
    if($salesPersonDeets['totalSales']==5){
        $salesTier="Tier 1";
        $updateTier=1;
        $bonus=50;
    } 
    else if($salesPersonDeets['totalSales']==7){    
        $salesTier="Tier 2";
        $updateTier=1;
        $bonus=200;
    }
    else if($salesPersonDeets['totalSales']==9){    
        $salesTier="Tier 3";
        $updateTier=1;
        $bonus=500;
    }
    else if($salesPersonDeets['totalSales']==12){    
        $salesTier="Tier 4";
        $updateTier=1;
    }
    else if($salesPersonDeets['totalSales']==15){    
        $salesTier="Tier 5";
        $updateTier=1;
    }
    else if($salesPersonDeets['totalSales']==16){    
        $salesTier="Tier 6";
        $updateTier=1;
    }
    else if($salesPersonDeets['totalSales']==17){    
        $salesTier="Tier 7";
        $updateTier=1;
    }
    else if($salesPersonDeets['totalSales']==18){    
        $salesTier="Tier 8";
        $updateTier=1;
    }
    else if($salesPersonDeets['totalSales']==19){    
        $salesTier="Tier 9";
        $updateTier=1;
    }
    else if($salesPersonDeets['totalSales']==20){    
        $salesTier="Tier 10";
        $updateTier=1;
    }
    
    if($updateTier){
        $query="update tushantMarketing_salesPerson set salesTier='$salesTier' where codeId='$codeId'";
        runQuery($query);
        
        //if bonus awarded then make entry in bonus table
        if($bonus!=0){
            $salesPersonId=getRow($con,"select * from tushantMarketing_salesPerson where codeId='$codeId'")['id'];
            $random=random();
            $timeAdded=time();
            $query="insert into tushantMarketing_bonus set id='$random',salesPersonId='$salesPersonId',upgradedTo='$salesTier',bonusAwarded='$bonus',timeAdded='$timeAdded'";
            runQuery($query);
        }
    }
    
    header("Location:thankyou.php?m=Thank You for buying the membership");
}
$m=clear($_GET['m']);
?>
<!DOCTYPE html>
<html lang="en-US">

<head>
	<?include("includes/head.php");?>
</head>

<body class="sk__homepage sk__home-hero-image dark-shade-1-bg ">

	<main id="primary" class="site-main">
		
		<?include("includes/topmenu.php");?>

        <div id="smooth-wrapper" class="pushable-content">
			<div id="smooth-content">
			    

				<!-- Hero Section / Hero Slider
				================================================== -->
				<section class="sk__hero-section sk__fade-in-1 duration-10">
					<!-- Carousel -->
					<div id="sk__hero-carousel-slider" class="sk__static-carousel-slider carousel slide dark-shade-1-bg">
				
						<!-- Slides -->
						<div class="carousel-inner">

							<!-- Slide 1 -->
							<div class="carousel-item zooming active hero-slide-1 sk__hero-slider-item sk__image-back-cover">
								<section class="sk__parallax-background-section sk__hero-item-center-center">
									<div class="sk__parallax-background-element sk__absolute sk__image-back-cover" style="background-image: url(uploads/banner.png);"></div>

									<div class="container flex-helper-div"></div>

									<!-- Hero content -->
									<div class="container sk__supercontainer sk__main-slide-content text-center">

										<div class="row">
											<div class="col-xl-10 offset-xl-1">
												<span class="animated-element phase-1"></span>
												<span class="animated-element phase-1"></span>
												<div class="cover-text-wrapper">
													<h1 class="hero-h1 animated-element phase-1"><!--Thank You !--></h1>
												</div>
												<div class="cover-text-wrapper">
													<h1 class="h2-regular thin animated-element phase-1" style="color:aqua;"><?echo $m;?></h1>
												</div>
											</div>
										</div>
									</div>

									<!-- Social icons section -->
									<div class="container sk__supercontainer text-center">
										<div class="row">
											<div class="col col-md-6 offset-md-3 col-xl-4 offset-xl-4 px-0">
												<!-- Footer Social Icons Menu -->
												<!--<section class="">
													<h5 class="animated-element phase-1 mb-0 mb-sm-2">Follow Us & Stay Informed</h5>
													<div class="">
														<div class="animated-element phase-1 mb-0">
															<a style="margin-right:30px;" class="" href="https://www.facebook.com/SkilltechWebDesign" target="_blank"><span><span class="icon-facebook1"></span></span></a>
															<a style="margin-right:30px;" class="" href="https://www.facebook.com/SkilltechWebDesign" target="_blank"><span><span class="icon-instagram"></span></span></a>
															<a style="margin-right:30px;" class="" href="https://www.facebook.com/SkilltechWebDesign" target="_blank"><span>
															    TikTok
															</a>
														</div>
													</div>
												</section>-->
											</div>
										</div>
									</div>


								</section>
							</div>
							<!-- /.hero-slide-1 -->
				
						</div>
						
					</div>
					<!-- /#sk__hero-carousel-slider -->
				</section>
				<!-- /.sk__hero-section -->
				
				<section class="sk__parallax-background-section sk__parallax-fixer-section sk__parallax-fixer-ignore-height overflow-hidden" style="max-height: 0;">
					<div class="sk__parallax-background-element"></div>
				</section>


				<!-- Helper div for inserting before scripts
				================================================== -->
				<div class="sk__body-end"></div>
			    
			</div>
		</div>
	</main>
	
	<?include("includes/footerjs.php")?>
</body>

</html>
