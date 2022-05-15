<?php
require 'config/config.php';
require CONNECT_PATH;
require CL_SESSION_PATH;
require GLOBAL_FUNC;
require ISLOGIN;// check kung nakalogin

if(!($g_user_role[0] == "ADMIN")){  
	header("Location: ".BASE_URL);
	exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
    include DOMAIN_PATH."/app/global/meta_data.php";
    include DOMAIN_PATH."/app/global/include_top.php";

?>
<style>
    .da-thumbs  img{
        height: auto;
        max-width: 100%;
        vertical-align: middle;

    }
    .img-polaroid {
        padding: 4px;
        background-color: #fff;
        border: 1px solid #ccc;
        border: 1px solid rgba(0,0,0,0.2);
        -webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        -moz-box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
	
</style>
</head>

<body data-layout="detached">
    <!-- HEADER -->
  <?php include DOMAIN_PATH."/app/global/top_bar.php"; ?>     <!--topbar -->
    <div class="container-fluid active">
        <div class="wrapper in">
            <!-- BEGIN CONTENT -->
            <!-- SIDEBAR -->
			
            <?php

			include DOMAIN_PATH."/app/global/sidebar.php";


			?>
            <!--END SIDEBAR-->
            <!-- PAGE CONTAINER-->
            <div class="content-page">
                <div class="content">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                    </div>
                                </div>

                            </div> <!-- end col-->
                        </div>



                    <!-- END PLACE PAGE CONTENT HERE -->
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
    </div>
    <!-- all the js files -->
    <!-- bundle -->
<?php  include FOOTER_PATH; ?>
</body>
<?php include DOMAIN_PATH."/app/global/include_bottom.php"; ?>
<script>
addClass(document.getElementById('student_link'),'active');
<?php
		$msg_success =$session_class->getValue('success');
    	if(isset($msg_success) AND $msg_success !=""){
			echo "success_notif('".$msg_success."');";
			$session_class->dropValue('success');
    	}

    	$msg_error =$session_class->getValue('error');
    	if(isset($msg_error) AND $msg_error !=""){
			echo "error_notif('".$msg_error."');";
			$session_class->dropValue('error');
    	}
?>



</script>
</html>
