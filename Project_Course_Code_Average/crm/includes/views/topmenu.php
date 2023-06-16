<?$filenameLink = basename($_SERVER['PHP_SELF']);?>

<div id="kt_header" class="kt-header  kt-header--fixed " data-ktheader-minimize="on">
	<div class="kt-container  kt-container--fluid ">

		<button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
		<div class="kt-header-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_header_menu_wrapper">
		    <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile ">
			    <div class="col-3 mx-auto my-auto" >
					<div class="" style="width: 200px;">
						<img src="<?echo $g_modules_global['logo']?>" height="40px" class=""></span>
					</div>
				</div>
				<ul class="kt-menu__nav">
				    <?if($logged==1){?>
					    <li class="kt-menu__item <?if($filenameLink=='home.php'){echo 'kt-menu__item--here';}?>" data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                            <a href="home.php" class="kt-menu__link"><span class="kt-menu__link-text">Home</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        </li>
                        <li class="kt-menu__item <?if($filenameLink=='salesPersons.php'){echo 'kt-menu__item--here';}?>" data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                            <a href="salesPersons.php" class="kt-menu__link"><span class="kt-menu__link-text" style="white-space: pre;">Sales Persons</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        </li>
                        <li class="kt-menu__item <?if($filenameLink=='clients.php'){echo 'kt-menu__item--here';}?>" data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                            <a href="clients.php" class="kt-menu__link"><span class="kt-menu__link-text">Clients</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        </li>
                        <li class="kt-menu__item <?if($filenameLink=='payrolls.php'){echo 'kt-menu__item--here';}?>" data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                            <a href="payrolls.php" class="kt-menu__link"><span class="kt-menu__link-text">Payrolls</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        </li>
                        <li class="kt-menu__item <?if($filenameLink=='cancelledClients.php'){echo 'kt-menu__item--here';}?>" data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                            <a href="cancelledClients.php" class="kt-menu__link"><span class="kt-menu__link-text" style="white-space: pre;">Cancelled Clients</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        </li>
                        <li class="kt-menu__item <?if($filenameLink=='leads.php'){echo 'kt-menu__item--here';}?>" data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                            <a href="leads.php" class="kt-menu__link"><span class="kt-menu__link-text">Leads</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        </li>
                        <li class="kt-menu__item <?if($filenameLink=='affiliates.php'){echo 'kt-menu__item--here';}?>" data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                            <a href="affiliates.php" class="kt-menu__link"><span class="kt-menu__link-text">Affiliates</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        </li>
                    <?}else{?>
                        <li class="kt-menu__item <?if($filenameLink=='login.php'){echo 'kt-menu__item--here';}?>" data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                            <a href="login.php" class="kt-menu__link"><span class="kt-menu__link-text">Login</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        </li>
                    <?}?>
                </ul>
            </div>
		</div>

		<?if($logged==1){?>
		<div class="kt-header__topbar kt-grid__item">
            <div class="kt-header__topbar-item kt-header__topbar-item--user">
				<div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
					<span class="kt-header__topbar-welcome kt-visible-desktop">Hi,</span>
					<span class="kt-header__topbar-username kt-visible-desktop"></span>
					<!--
					<img alt="Pic" src="assets/media/users/300_21.jpg" />
					-->

					<!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
					<span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold"><?echo substr($session_name, 0, 1);?></span>
				</div>
				<div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">

					<!--begin: Head -->
				<div class="kt-user-card kt-user-card--skin-light kt-notification-item-padding-x">
						<div class="kt-user-card__avatar">
						    <!--
							<img class="kt-hidden-" alt="Pic" src="assets/media/users/300_25.jpg" />
							-->

						    <span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold"><?echo substr($session_name, 0, 1);?></span>
						</div>
						<div class="kt-user-card__name">
							<?echo $session_name?>
						</div>
						<div class="kt-user-card__badge">
							<a href="?logout=1" class="btn btn-label-primary btn-sm btn-bold btn-font-md">Logout</a>
						</div>
					</div>
                </div>
			</div>
		</div>
		<?}?>

		<!-- end:: Header Topbar -->
	</div>
</div>
