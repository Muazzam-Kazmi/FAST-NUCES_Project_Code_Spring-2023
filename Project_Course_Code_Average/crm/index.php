<?require("./global.php");

if(isset($_GET['logout'])){
    
    $_SESSION['email'] = "";
    $_SESSION['password'] = "";
    session_destroy();
    $logged=0;
    ?><script>window.location = "?";</script><?
}


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?require("./includes/home/head.php");?>
    </head>
    <body>
        <div class="site-mobile-menu site-navbar-target">
            <div class="site-mobile-menu-header">
                <div class="site-mobile-menu-close">
                    <span class="icofont-close js-menu-toggle"></span>
                </div>
            </div>
            <div class="site-mobile-menu-body"></div>
        </div>

        <!-- header -->
        <?require("./includes/home/header.php");?>
        <!-- header -->

        <div class="hero-section">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-lg-5">
                        <span class="subheading mb-2" >Welcome to our site</span>
                        <h1 class="heading mb-3"  data-aos-delay="100"><?echo $g_projectTitle?></h1>
                        <p class="mb-5"  data-aos-delay="200">
                           <?echo $g_tagline?>
                        </p>
                        
                        <p data-aos-delay="300">
                            <?if($logged==0){?> 
                            <a href="./login.php" class="btn btn-outline-primary">Login</a>
                            <?}else{?>
                            <a href="./home.php" class="btn btn-outline-primary">Dashboard</a>
                            <?}?>
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <div class="img-wrap" >
                            <img src="./assetshome/images/images-xhero_1.png.pagespeed.ic.wYR1YLKBJK.png" alt="Image" class="img-fluid" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- footer -->
        <?require("./includes/home/footer.php");?>
    </body>
</html>
