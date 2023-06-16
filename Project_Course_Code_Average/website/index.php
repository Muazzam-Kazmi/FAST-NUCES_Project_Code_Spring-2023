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

				<!-- Hero Social Icons Menu -->
				<section class="hero-socials-section">
					<div class="hero-socials-inner">
						<div class="hero-socials">
							<!-- <a class="social-icons" href="" target="_blank">
								<span>
									<span class="icon-youtube1"></span>
								</span>
							</a> -->
						</div>
					</div>
				</section>
			
				<!-- Hero Section / Hero Slider
				================================================== -->
				<section class="sk__hero-section">
					<!-- Carousel -->
					<div id="sk__hero-carousel-slider" class="sk__static-carousel-slider carousel slide dark-shade-1-bg">
				
						<!-- Slides -->
						<div class="carousel-inner">

							<!-- Slide 1 -->
							<div class="carousel-item  active hero-slide-1 sk__hero-slider-item sk__image-back-cover">

								<section class="sk__parallax-background-section sk__hero-item-theme-style">
									<!--url('uploads/MEMBERS CLUB HEADER.png')-->
									<div class="sk__parallax-background-element sk__absolute sk__image-back-cover"
									 style="background-image:url('uploads/banner.png');transform: unset;"></div>

									<div class="flex-helper-div"></div>
									
									<div class="hero-h1-box">
										<div class="cover-text-wrapper">
											<!-- <h1 class="hero-h1 animated-element phase-1 text-center text-md-start text-white">AWS Marketing<br> is Here</h1>
												<a class="btn btn-outline-light animated-element phase-1 mb-4" href="#about-us" role="button">Sign Up Now</a> -->
									
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

				
				<!-- get the member ship now section -->
				<section class="sk__cta-warp position-relative sk__image-back-cover" style="padding-bottom: 0px; ">
					<div class="container sk__powercontainer">
						<div class="row">
							<div class="col text-center">
								<div class="sk__warped-text-wrapper sk__flex-center">
									<span class="sk__warped-text" style="color: gold;">GET THE MEMBER SHIP NOW</span>
								</div>
								<h3><strong style="color: gold;">JOIN THE FUN !</strong></h3>
								<a href="signup.php" class="btn btn-lg btn-outline-light sk__warped-button" style="margin-bottom: 20px;background-color: #dbb65d;color: black;border-color:black">SIGN UP NOW !</a>
							</div>
						</div>
					</div>
				</section>

				<!-- Numbers Section (Animated Counters)
				================================================== -->
				<section class="sk__numbers-section dark-shade-3-bg sk__solid-menu-bar">
					<div class="container-fluid">
						<div class="row sk__numbers-row text-center">
							<?
				            $titles=array("Classes","Maps","Trainers","Premium Accounts","Skins","Crates");
							$numbers=array("7","10","300+","1000+","10000+","3000+");
							for($i=0;$i<6;$i++){?>
							<div class="col-6 col-sm-4 col-md counters-wrap sk__flex-center" 
							<?if($titles[$i]=="Crates"){?>
							style="
                                background-image: url('images/rightBorder.png');
                                background-repeat: no-repeat;
                                background-size: contain;
                                background-position: right;
                                margin-right: 5px;
                            "
							<?}else if($titles[$i]=="Classes"){?>
							style="
                                background-image: url('images/leftBorder.png');
                                background-repeat: no-repeat;
                                background-size: contain;
                                background-position: left;
                            "
							<?}?>
							>
								<div class="flex-child">
									<span class="sk__counter" data-gsap-counter-number="<?echo $numbers[$i];?>" style="color: gold;">0</span>
									<p><?echo $titles[$i]?></p>
									<span class="numbers-deco sk__absolute"></span>
								</div>
							</div>
							<?}?>
						</div>
					</div>
				</section>

				<section class="sk__deco-row-section">
					<div class="container-fluid">
						<div class="row sk__deco-row dark-shade-7-bg dark-shade-5-border" style="background-color: #dbb65d !important;padding: 3px;margin-top: 10px;"></div>
					</div>
				</section>


				<section class="sk__features-section sk__py-s dark-shade-3-bg text-center text-sm-start" style="padding-bottom: 0;"> 
					<div class="container sk__supercontainer">
						<div class="row sk__heading-spacer-s">
							<div class="col">
								<h1 class="super-heading sk__clipped-text sk__gradient-back-v1 mb-sm-1">Membership Perks</h1>
							</div>
						</div>
						<div class="row sk__features">
						    <?
						    $title=array("Premium Discounts","Free Gifts ","CS GO Community","Professional Team","Winning Prizes","Free Trainers");
						    $content=array(
						        "10% discounts for any skinds and crates",
						        "Free gifts from CS GO Community during special occasions",
						        "CS GO Community is always here to help",
						        "A team from which you will learn alot",
						        "Bumper prizes for the winning team",
						        "You can avail free trainers any time",
						        );
						    for($i=0;$i<6;$i++){
						    ?>
						    <div class="col-x1-12 col-sm-6 col-md-4 sk__feature-col" style="height: 340px;background-image: url('images/goldBorder.png');opacity: 1;background-size: contain;background-repeat: no-repeat;">
								<div class="sk__feature" style="padding-top: 60px;">
									<h5 style="color: gold;"><?echo $title[$i];?></h5>
									<div class="colorline-deco">
										<div class="colorline-deco-normal sk__absolute"></div>
										<div class="colorline-deco-hover sk__absolute sk__gradient-back-v1"></div>
									</div>
									<p>
									    <?echo $content[$i];?>.
									</p>
								</div>
							</div>
							<?}?>
						</div>
					</div>
				</section>
				
				
				<footer class="dark-shade-2-bg position-relative">
					<?include("includes/footer.php");?>
				</footer>
				<div class="sk__body-end"></div>
			</div>
			<!-- /#smooth-content -->

		</div>
		<!-- /#smooth-wrapper -->

	</main>
	
	<?include("includes/footerjs.php")?>
</body>

</html>
