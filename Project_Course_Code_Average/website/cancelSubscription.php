<?
require("global.php");
require_once('vendor/autoload.php');

\Stripe\Stripe::setApiKey($g_stripeCred['private_test_key']); 

$stripe = new \Stripe\StripeClient([
    "api_key" => $g_stripeCred['private_test_key'], 
    "stripe_version" => "2020-08-27"
    ]
);

$normalView=0;
$verificationView=0;

if($_GET['view']=="verification"){
    $verificationView=1;
    $heading="Verification Code";
}
else{
    $normalView=1;
    $heading="Cancel Subscription";
}

if(isset($_POST['cancelSubscription'])){
    $email=clear($_POST['email']);
    
    $query="select * from tushantMarketing_clients where email='$email'";
    $clientDeets=getRow($con,$query);
    $result=$con->query($query);
    if(mysqli_num_rows($result)==0){
        header("Location:?m=No Such Account Exists");
        exit();
    }
    
    //checking if his subscription status is cancelled
    $subscription = \Stripe\Subscription::retrieve($clientDeets['subscriptionId']);
    if ($subscription->status == 'canceled') {
        header("Location:?m=Your Subscription Has Already Been Cancelled");
        exit();
    }
    else{
        //sending code to the client email address
        $random=random();
        $clientId=$clientDeets['id'];
        $verificationCode=random();
    
        $query="delete from tushantMarketing_verification_codes where clientId='$clientId'";
        runQuery($query);
    
        $query="insert into tushantMarketing_verification_codes set id='$random',clientId='$clientId',code='$verificationCode'";
        runQuery($query);
        
    	header("Location:?m=Your verification code is : $verificationCode &view=verification");
    }
}

if(isset($_POST['verificationCode'])){
    $code=clear($_POST['code']);
    
    $query="select * from tushantMarketing_verification_codes where code='$code'";
    $result=$con->query($query);
    if(mysqli_num_rows($result)==0){
        header("Location:?m=No Such Code Exists Try Again");
        exit();
    }
    else{
        $clientDeets=getRow($con,"select * from tushantMarketing_clients where id=(select clientId from tushantMarketing_verification_codes where code='$code')");
        $clientId=$clientDeets['id'];
        $codeId=$clientDeets['code'];
        
        $subscriptionId=$clientDeets['subscriptionId'];
        $stripe->subscriptions->cancel(
          $subscriptionId,
          []
        );
        //decreasing the sales of the salesperson whose code was used by this client
        $query="update tushantMarketing_salesPerson set totalSales=totalSales-1 where codeId='$codeId'";
        runQuery($query);
        
        $timeCancelled=time();
        $query="update tushantMarketing_clients set paymentStatus='Cancelled',timeCancelled='$timeCancelled' where id='$clientId'";
        runQuery($query);
        header("Location:thankyou.php?m=Your Subscription Has Been Cancelled Successfully");
    }
    
        
}



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
			    

				
				<!-- Header
				================================================== -->
				<section class="sk__pt-l">
					<div class="container sk__supercontainer">
						<div class="row text-center">
							<div class="col-12 col-md-10 offset-md-1 sk__reveal-header-text">
								<div class="cover-text-wrapper">
									<div class="fancy-gradient-text-box">
										<h1 class="super-heading sk__gradient-fancy-text"><?echo $heading?></h1>
									    <?if(isset($_GET['m'])){$m=clear($_GET['m']);?>
									    <p class="alert alert-danger" style="background-color: red;border-color: red;color:white;"><?echo $m;?></p>
									    <?}?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>

                <section id="contact-us" class="sk__contact-us sk__py-m sk__parallax-background-section sk__flex-center-y sk__fade-in-10" style="padding-bottom: 0;padding-top: 0;min-height:0px;">
					<div class="sk__parallax-background-element sk__absolute sk__image-back-cover"></div>
					<div class="sk__tint sk__absolute"></div>
					<div class="container sk__powercontainer">
						
						<div class="row">
							<!-- Contact Form -->
							<div class="col-12 col-lg-10 offset-0 offset-lg-1 sk__contact-form-col d-flex justify-content-end">
								<div class="sk__contact-right text-center text-sm-start">

                                    <form action="" method="post" enctype="multipart/form-data">
                                        <?if($normalView){?>
                                        <div class="form-group">
											<input type="text" name="email" placeholder="Enter Email Address" tabindex="5">
										</div>
                                        <input type="submit" name="cancelSubscription" value="Cancel Subscription !" style="background-color: #dbb65d;color: black;border-color: #dbb65d;">
                                        <?}else if($verificationView){?>
                                        
                                        <div class="form-group">
											<input type="text" name="code" placeholder="Enter Verification Code" tabindex="5">
										</div>
                                        <input type="submit" name="verificationCode" value="Submit Verification Code !" style="background-color: #dbb65d;color: black;border-color: #dbb65d;">
                                        
                                        <?}?>
                                    </form>

								</div>
							</div>
						</div>
					</div>

				</section>

                <footer class="dark-shade-2-bg position-relative">
					<?include("includes/footer.php");?>
				</footer>
				
				<div class="sk__body-end"></div>
			</div>
		</div>
	</main>
	
	<?include("includes/footerjs.php")?>
</body>

</html>
