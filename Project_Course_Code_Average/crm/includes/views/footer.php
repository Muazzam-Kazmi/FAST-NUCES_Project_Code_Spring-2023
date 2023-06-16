<?if(!isset($_GET['print'])){?>
<div class="kt-footer kt-grid__item" id="kt_footer">
	<div class="kt-container ">
		<div class="kt-footer__wrapper">
			<div class="kt-footer__copyright">
				<script>
                document.write(new Date().getFullYear());
            </script>
            &nbsp;&copy;&nbsp;<a href="./" target="_blank" class="kt-link"><?echo $g_projectTitle?></a>
			</div>
			<div class="kt-footer__menu">
				<a href="//anomoz.com?src=<?echo urlencode($g_website)?>" target="_blank" class="kt-link">Built by Anomoz Softwares</a>
				
			</div>
		</div>
	</div>
</div>
<?}?>