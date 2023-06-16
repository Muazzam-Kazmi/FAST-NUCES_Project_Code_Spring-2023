<!-- begin::Page loader -->

<!-- end::Page Loader -->

<!-- begin:: Page -->
<?if(!isset($_GET['print'])){?>
<style>
    .kt-header__topbar--mobile-on .kt-header__topbar{
        z-index:1;
    }
</style>
<!-- begin:: Header Mobile -->
<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
	<div class="kt-header-mobile__logo">
		<a href="./">
			<img alt="Logo" src="<?echo $g_modules_global['logo']?>"  style="height:40px"/>
		</a>
	</div>
	<div class="kt-header-mobile__toolbar">
	    <!--
		<button class="kt-header-mobile__toolbar-toggler kt-header-mobile__toolbar-toggler--left" id="kt_aside_mobile_toggler"><span></span></button>
		-->
		<button class="kt-header-mobile__toolbar-toggler" id="kt_header_mobile_toggler"><span></span></button>
		<button class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more-1"></i></button>
	</div>
</div>

<!-- end:: Header Mobile -->


<!-- end:: Page -->

<!-- begin::Quick Panel -->
<?require("./includes/views/quickpanel.php")?>

<!-- end::Quick Panel -->

<!-- begin::Scrolltop -->
<div id="kt_scrolltop" class="kt-scrolltop">
	<i class="fa fa-arrow-up"></i>
</div>

<!-- end::Scrolltop -->
<?}?>

