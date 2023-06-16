<?
require("./global.php");
require_once('vendor/autoload.php');

$stripe = new \Stripe\StripeClient([
    "api_key" => $g_stripeCred['private_test_key'], 
    "stripe_version" => "2020-08-27"
    ]
);


if(isset($_POST['addClient'])){
    $firstName=clear($_POST['firstName']);
    $lastName=clear($_POST['lastName']);
    $name=$firstName." ".$lastName;
    $contactNo=clear($_POST['contactNo']);
    $email=clear($_POST['email']);
    $code=clear($_POST['code']);
    $id=random();
    //checking for duplicate email
    $emails=getRow($con,"select * from tushantMarketing_clients where email='$email' && paymentStatus='Paid'");
    //checking for valid code
    if($code!=""){
        $query="select * from tushantMarketing_salesPerson where BINARY codeId='$code'";
        $result=$con->query($query);
        if(mysqli_num_rows($result)==0){
            header("Location:?m=Invalid Referral Code . Try Again");
            exit();
        }
    }
    else
        $code="Marketing";
    
    if(count($emails)>2){
        header("Location:?m=This Email has Already Been Used ");
        exit();
    }
    else{
        //if the person who again signedup but previously didnot pay needs to be deleted
        $query="delete from tushantMarketing_clients where email='$email'";
        runQuery($query);
    }
    $timeAdded=time();
    $query="insert into tushantMarketing_clients set id='$id',contactNo='$contactNo',name='$name',firstName='$firstName',lastName='$lastName',
    email='$email',code='$code',timeAdded='$timeAdded'";
    runQuery($query);

    $successUrl = $g_website."/thankyou.php?clientId=$id&subscriptionId={CHECKOUT_SESSION_ID}";
    $cancel_url = $g_website."/signup.php?m=Payment Failed";
    
    $checkout_session = $stripe->checkout->sessions->create([
        'line_items' => [[
          'price' => 'price_1MrjEJHQjkfG1DwOwZCZXoFt',
          'quantity' => 1,
        ]],
        'mode' => 'subscription',
        'success_url' => $successUrl,
        'cancel_url' => $cancel_url,
      ]);
    header("HTTP/1.1 303 See Other");
    header("Location: " . $checkout_session->url);
    ?>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe('<?echo $g_stripeCred['public_test_key']?>');
           stripe.redirectToCheckout({
                sessionId: '<?echo $session['id']?>'
              }).then(function (result) {

              });
    </script>
<?

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
										<h1 class="super-heading sk__gradient-fancy-text">Sign Up</h1>
									    <?if(isset($_GET['m'])){$m=clear($_GET['m']);?>
									    <p class="alert alert-danger" style="background-color: red;border-color: red;color:white;"><?echo $m;?></p>
									    <?}?>
									</div>
								</div>
								<div class="cover-text-wrapper">
									<h2 class="h2-large sk__heading-spacer-s" style="padding-bottom: 0;margin-bottom: 0;color:gold;">
									    Get the membership for  <strong>$19.99/month!</strong></h2>
								</div>
							</div>
						</div>
					</div>
				</section>


				<!-- Contact Us Section
				================================================== -->
				<section id="contact-us" class="sk__contact-us sk__py-m sk__parallax-background-section sk__flex-center-y sk__fade-in-10" style="padding-bottom: 0;padding-top: 0;min-height:0px;">
					<div class="sk__parallax-background-element sk__absolute sk__image-back-cover"></div>
					<div class="sk__tint sk__absolute"></div>
					<div class="container sk__powercontainer">
						
						<div class="row">
							<!-- Contact Form -->
							<div class="col-12 col-lg-10 offset-0 offset-lg-1 sk__contact-form-col d-flex justify-content-end">
								<div class="sk__contact-right text-center text-sm-start">

                                    <form action="" method="post" enctype="multipart/form-data">

										<div class="form-group">
											<input type="text" name="firstName" placeholder="First Name" tabindex="1" required>
										</div>
										<div class="form-group">
											<input type="text" name="lastName" placeholder="Last Name" tabindex="2" required>
										</div>
										<div class="form-group">
											<input type="text" name="contactNo" placeholder="Contact Number" tabindex="3" required>
										</div>
										<div class="form-group">
											<input type="email" name="email" placeholder="Email" tabindex="4" required>
										</div>
										<div class="form-group">
											<input type="text" name="code" placeholder="Code" tabindex="5">
										</div>
                                        <input type="submit" name="addClient" value="Sign Up !" style="background-color: #dbb65d;color: black;border-color: #dbb65d;">
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
