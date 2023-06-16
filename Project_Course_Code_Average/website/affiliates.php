<?
require("./global.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
    $email=clear($_POST['email']);
    $timeAdded=time();
    $id=random();
    $query="insert into tushantMarketing_affiliates set id='$id',timeAdded='$timeAdded',email='$email'";
    runQuery($query);
    
    header("Location:?m=1");
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
			    
			    <section class="sk__pt-l" style="padding-top: 100px;">
					<div class="container sk__supercontainer">
						<div class="row text-center">
							<div class="col-12 col-md-10 offset-md-1 sk__reveal-header-text">
								<div class="cover-text-wrapper">
								    <?if(isset($_GET['m'])){?>
									    <p class="alert alert-success" style="background-color: green;border-color: green;color:white;">
    								        Thank You For Your response. 
    									    We will be in touch with you very soon
									    </p>
									    <?}?>
									<div class="fancy-gradient-text-box">
										<h1 class="super-heading sk__gradient-fancy-text">All About Affiliation</h1>
									</div>
								</div>
								<div class="cover-text-wrapper">
									<h2 class="h2-large sk__heading-spacer-s" style="padding-bottom: 0;margin-bottom: 0;color:gold;">
									    What is an affiliate? 
									    What does it mean to be an affiliate with our community
									</h2>
								
									<h2 class="h2-large sk__heading-spacer-s" style="padding-bottom: 0;margin-bottom: 0;color:white;">
									    Imagine living the life of your dreams - earning money effortlessly while enjoying all that life has to offer.
									     With access to the world's biggest commission, you have the potential to 
									    make an astounding money. It's an opportunity to live your best life, with passive
									    income and ongoing rewards at your fingertips.
									</h2>
								</div>
							</div>
						</div>
					</div>
				</section>
				
				<section class="sk__features-section sk__py-s dark-shade-3-bg text-center text-sm-start" style="padding-bottom: 0;"> 
					<div class="container sk__supercontainer">
						<div class="row sk__heading-spacer-s">
							<div class="col">
								<h1 class="super-heading sk__clipped-text sk__gradient-back-v1 mb-sm-1">Perks Of Being An Affiliate</h1>
							</div>
						</div>
						<div class="row sk__features">
						    <?
						    $title=array(
						        "Some of the world’s biggest commission",
						        "10% commission on all skins/crates/subscriptions that you sell",
						        "An all-expense paid on-location holiday",
						        );
						    foreach($title as $row){
						    ?>
						    <div class="col-x1-12 col-sm-6 col-md-4 sk__feature-col" style="height: 340px;background-repeat: no-repeat;background-image: url('images/goldBorder.png');opacity: 1;background-size: contain;">
								<div class="sk__feature" >
									<h5 style="color: gold;"><?echo $row;?></h5>
									<div class="colorline-deco">
										<div class="colorline-deco-normal sk__absolute"></div>
										<div class="colorline-deco-hover sk__absolute sk__gradient-back-v1"></div>
									</div>
								</div>
							</div>
							<?}?>
						</div>
					</div>
				</section>
				
				
				<section>
				    <div class="container sk__supercontainer sk__main-slide-content text-center">

										<div class="row">
											<div class="col-xl-10 offset-xl-1" style="opacity: 1;">
												<span class="animated-element phase-1" style="transform: translate(0px, 0px); opacity: 1;"></span>
												<span class="animated-element phase-1" style="transform: translate(0px, 0px); opacity: 1;"></span>
												<div class="cover-text-wrapper" style="opacity: 1;">
													<h1 class="super-heading sk__clipped-text sk__gradient-back-v1 mb-sm-1" style="transform: translate(0px, 0px); opacity: 1;">Become An Affiliate</h1>
												</div>
												<div class="cover-text-wrapper" style="opacity: 1;">
													<h2 class="h2-regular thin animated-element phase-1" style="transform: translate(0px, 0px); opacity: 1;">
													    Submit your email address and we'll be in touch with you very soon 
													</h2>
												</div>
											</div>
										</div>
									
										<div class="row">
											<div class="col col-md-6 offset-md-3 col-xl-4 offset-xl-4">
												<div class="widget custom_subscribe_widget">
													<div class="sk__widget-inner" style="opacity: 1;">
														<form method="post" action="" class="sk__form sk__subscribe-form animated-element phase-2" style="transform: translate(0px, 0px); opacity: 1;">
															<div class="form-group">
																<input type="email" name="email" placeholder="Enter Email Address*" tabindex="1" required>
															</div>
															<button type="submit" tabindex="2">Submit</button>
														</form>
                                                    </div>
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
