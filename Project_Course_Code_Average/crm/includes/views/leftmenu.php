<?if(!isset($_GET['print'])){?>
<?if($g_modules_global['enableLeftMenu']){?>
    <button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
    <div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">
    
    	<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
    		<div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1">
    			<ul class="kt-menu__nav ">
    				<li class="kt-menu__item " aria-haspopup="true"><a target="_blank" href="./home.php" class="kt-menu__link "><span class="kt-menu__link-text"><img src="<?echo $g_logo?>" class="w-100 "></span></a></li>
    				<?foreach($menuItems as $menuItem){?>
    				    <li class="kt-menu__item <?if($filenameLink==$menuItem[0]){echo 'kt-menu__item--here';}?>" aria-haspopup="true"><a href="./<?echo $menuItem[0]?>" class="kt-menu__link "><span class="kt-menu__link-text"><?echo ucfirst($menuItem[1])?></span></a></li>
    				<?}?>
    			</ul>
    		</div>
    	</div>
    
    </div>
<?}?>
<?}?>