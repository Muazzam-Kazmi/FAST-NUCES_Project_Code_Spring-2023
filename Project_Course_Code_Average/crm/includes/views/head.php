
		<base href="">
		<meta charset="utf-8" />
		<title><?echo $g_projectTitle?> </title>
		<meta name="description" content="<?echo $g_projectTitle?> ">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!--begin::Fonts -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">

		<!--end::Fonts -->

		<!--begin::Page Vendors Styles(used by this page) -->
		<link href="assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />

		<!--end::Page Vendors Styles -->

		<!--begin::Global Theme Styles(used by all pages) -->
		<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/style.bundle.php" rel="stylesheet" type="text/css" />

		<!--end::Global Theme Styles -->

		<!--begin::Layout Skins(used by all pages) -->

		<!--end::Layout Skins -->
		<link rel="shortcut icon" href="<?echo $g_modules_global['faviconlogo']?>" />
	
	
	
	
	
	
	
<style>
    .kt-portlet__body{
        overflow:auto;
    }
    .kt-login.kt-login--v1 .kt-login__wrapper {
        background:#f9f9fc !important;
    }
   
    .kt-login.kt-login--v1 .kt-login__wrapper .kt-login__body .kt-login__form .kt-form .form-group .form-control {
  background-color: white !important;
  border: 1px #e8e8e8 solid !important;
}

<?if(isset($_GET['print'])){?>
.btn {
  display: none !important;
}
<?}?>
</style>

<?if($g_modules_global['enablePWA']){?>
<link rel="manifest" href="./webmanifest.json">
<link rel="apple-touch-icon" href="<?echo $g_modules_global['logo']?>">
<meta name="apple-mobile-web-app-status-bar" content="<?echo $g_primaryColor?>">
<meta name="theme-color" content="<?echo $g_primaryColor?>">
<script>
    if('serviceWorker' in navigator){
  navigator.serviceWorker.register('./sw.js')
    .then(reg => console.log('service worker registered'))
    .catch(err => console.log('service worker not registered', err));
}
</script>
<?}?>