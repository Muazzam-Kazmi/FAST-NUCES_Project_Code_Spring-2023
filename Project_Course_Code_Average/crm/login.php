<?include_once("global.php");
if($logged==1){
    header("Location: home.php");
    exit();
}
if(isset($_POST['loginUser'])){
    $email=clear($_POST['email']);
    $password=clear($_POST['password']);
    $query="select * from tushantMarketing_admins where email='$email' && password='$password'";
    $result=$con->query($query);
    
    if(mysqli_num_rows($result)>0){
        $_SESSION['email']=$email;
        $_SESSION['password']=$password;
        header("Location:home.php");
    }
    else
        header("Location:?err=failed");
}
?>
<!DOCTYPE html>
<html lang="en">

	<!-- begin::Head -->
	<head>
	    <?require("./includes/views/head.php")?>
		<link href="assets/css/pages/login/login-1.css" rel="stylesheet" type="text/css" />
	</head>
    <div id="kt_header" class="kt-header  kt-header--fixed " data-ktheader-minimize="on">
    	<div class="kt-container  kt-container--fluid ">
            <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
    		<div class="kt-header-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_header_menu_wrapper">
    		    
    			<div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile ">
    				<ul class="kt-menu__nav">
    				    <li class="kt-menu__item " data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                            <a href="index.php" class="kt-menu__link"><span class="kt-menu__link-text">Home</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        </li>
                        <li class="kt-menu__item kt-menu__item--here" data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                            <a href="login.php" class="kt-menu__link"><span class="kt-menu__link-text">Login</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        </li>
                    </ul>
    			</div>
    		</div>
            <div class="kt-header__topbar kt-grid__item">
            </div>
    	</div>
    </div>
	
	<body class="kt-page--loading-enabled kt-page--loading kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header--minimize-menu kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-aside--enabled kt-aside--left kt-aside--fixed kt-page--loading">
        <div class="kt-grid kt-grid--ver kt-grid--root kt-page">
			<div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v1" id="kt_login">
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--desktop kt-grid--ver-desktop kt-grid--hor-tablet-and-mobile">
                    <div class="kt-grid__item kt-grid__item--fluid  kt-grid__item--order-tablet-and-mobile-1  kt-login__wrapper">
                        <div class="kt-login__body">
                            <div class="kt-login__form">
								<div class="kt-login__title" style="margin-top: 50px;">
								    <img src="https://www.anomoz.com/style/logo.png" height="150px" class=""></span>
								    <h1 class="mt-3"><strong><?echo $g_projectTitle?></strong></h1>
								    <br>
								    <h3>Log In</h3>
								</div>
							    
							    <form class="kt-form" action="" method="post" >
								    <?if($_GET['err']=="failed"){?>
                                        <span class="w-100 alert alert-danger" style="background-color:red;">Incorrect Credentials Try Again</span>
                                    <?}?>
                                    
                                    <div class="form-group">
										<input class="form-control" type="email" placeholder="Enter Email" name="email" required>
									</div>
									<div class="form-group">
										<input class="form-control" type="password" placeholder="Enter Password" name="password" required>
									</div>
							        <div class="kt-login__actions">
									    <input type="submit" value="Log In" name="loginUser" class="btn btn-primary btn-elevate kt-login__btn-primary w-100" >
									</div>
                                </form>
							</div>
                        </div>
                    </div>
                </div>
			</div>
		</div>
        
		<!--begin::Global Theme Bundle(used by all pages) -->
		<script src="assets/plugins/global/plugins.bundle.js" type="text/javascript"></script>
		<script src="assets/js/scripts.bundle.js" type="text/javascript"></script>
	</body>
	
	

	<!-- end::Body -->
</html>