<?require("./global.php");

if($logged==0)
    header("Location:index.php");

if(isset($_GET['delete-affiliate'])){
    $id=clear($_GET['delete-affiliate']);
    $query="delete from tushantMarketing_affiliates where id='$id'";
    runQuery($query);
    header("Location:?m=Affiliate email has been deleted successfully ");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?require("./includes/views/head.php") ?>
    </head>
<body class="<? echo $g_body_class ?>">
	<? require("./includes/views/header.php") ?>
	<div class="kt-grid kt-grid--hor kt-grid--root">
		<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
				<? require("./includes/views/topmenu.php") ?>
				<? require("./includes/views/leftmenu.php") ?>
				<div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
					<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
						<div class="kt-container  kt-grid__item kt-grid__item--fluid">
    
							<? if (isset($_GET['m'])) { ?>
								<div class="alert alert-info"><? echo clear($_GET['m']) ?></div>
							<? } ?>
                            
                            <div class="kt-portlet kt-portlet--mobile">
            						<div class="kt-portlet__head kt-portlet__head--lg">
            							<div class="kt-portlet__head-label">
            								<span class="kt-portlet__head-icon">
            								</span>
            								<h3 class="kt-portlet__head-title">
            								    Affiliates
            								</h3>
            							</div>
            						</div>
            						<div class="kt-portlet__body">
            							    <table class="table table-striped- table-bordered table-hover table-checkable add-search " >
                                                <thead>
                                                    <tr>
                                                        <th>Email</th>
                                                        <th>Time Added</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?
                                                $affiliates=getAll($con,"select * from tushantMarketing_affiliates order by timeAdded desc");
                                                foreach($affiliates as $row){?>
                                                        <tr>
                                                            <td><?echo $row['email']?></td>
                                                            <td><?echo date("d M Y",$row['timeAdded'])?></td>
                                                            <td>
                                                                <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#delete_record" data-url="?delete-affiliate=<?echo $row['id']?>">Delete</a>
                                                            </td>
                                                        </tr>
                                                    <?}?>
                                                </tbody>
                                            </table>
                                    </div>
        					    </div>
        				</div>
                    </div>
                </div>
			</div>
		</div>
		<? require("./includes/views/footer.php") ?>
	</div>
    <? require("./includes/views/footerjs.php") ?>
</body>
</html>