<?php
require 'config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require VALIDATOR_PATH; // library for form validato

$page_title ="ADMIN LOGIN";
$page_id ="";
$error_encounter = false;

$g_user_role = $session_class->getValue('role_id');
include "redirect.php";

$csrf = new CSRF($session_class); 

$last_user = $session_class->getValue('last_user');
$login_attempt = 0;
if (!empty($last_user)) {
	$login_attempt = $session_class->getValue('login_attempt_'.$last_user);
}
$browser_attempt = $session_class->getValue('browser_attempt_login');
if (empty($browser_attempt)) {
	$browser_attempt = 0;
}


if($browser_attempt >=30){
	$mod_msg['title'] = "Login Disabled";
	$mod_msg['subtitle'] ='Login Attempt exceed.<br>Please wait for a moment to be allowed again.';
	include MOD_404;
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
#password{
	-webkit-text-security:disc; 
	text-security:disc;
	-moz-text-security: disc;
}
.password_show{
	-webkit-text-security:none!important; 
	text-security:none!important;
	-moz-text-security: none!important;
}       

</style>
</head>

<body data-layout="detached">
    <!-- HEADER -->
    <div class="container-fluid active">
        <div class="wrapper in">
            <!-- BEGIN CONTENT -->
            <!-- SIDEBAR -->

            <!--END SIDEBAR-->
            <!-- PAGE CONTAINER-->
            <div class="content-page">
                <div class="content">
                    <!-- BEGIN PlACE PAGE CONTENT HERE -->
                  <div class="row justify-content-md-center">
                        <div class="col-xs-12  col-sm-12 col-lg-6" >
                            <div class="card" style="background:#438ff4;color:white;">
                                <div class="card-body" style="padding:10px;">
                                    <h4 class="page-title"> <img src="<?php echo BASE_URL;?>images/logo-light.png" alt="" height="50"><span style="font-size:20pt;font-family:inkfree;"> SYSTEM NAME</span></h4>
                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->
                    </div>
                        <div class="row justify-content-md-center" >
                            <div class="col-xs-12 col-sm-12 col-lg-6">
                                <div class="card">
                                    <div class="card-body">
										<form class="" name='login_form' id="login_form" action="<?php echo BASE_URL;?>login.php"  method="POST">
										<h3 id="log_title">SIGN-IN</h3>
											<div class="row">
												
												<div class="form-group col-xs-12 col-sm-12 col-lg-12">
													<input type="text" class="form-control" name="username" id="username" value="" placeholder="Username" required >
												</div>
												<div class="form-group col-xs-12 col-sm-12 col-lg-12" id="password_div">
													<div class="input-group mb-2">
														<input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
														<div class="input-group-append">
														</div>
														
													</div>
													<span style="font-size:10pt;">Login Attempts: <?php echo $login_attempt;?></span>
												</div>
												<div class="form-group col-xs-12 col-sm-12 col-lg-12" id="forgotlogin">
													<a href="#" id="forgot_action"> <i class="fas fa-question-circle"></i><span> FORGOT PASSWORD</span> </a>
												</div>
												<div class="form-group col-xs-12 col-sm-12 col-lg-12" id="backlogin" style="display:none;">
													<a href="#" id="back_login"> <i class="fas fa-chevron-left"></i><span> BACK TO LOGIN</span> </a>
												</div>
												<div class="form-group col-xs-12 col-sm-12 col-lg-12">
													<button type="submit" id="btn_submit" name="submit" value="login" class="btn btn-primary">LOGIN</button> 
												</div>
												 <?php echo $csrf->input('token_login_admin_form','token_login_admin_form',3600,1); ?>
											 </div>
										</form>
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


(function() {
var global_action ="";
const back_login = document.getElementById('back_login');
const div_backlogin = document.getElementById('backlogin');

const btn_forgot = document.getElementById('forgot_action');
const div_forgot = document.getElementById('password_div');
const div_forgotlogin = document.getElementById('forgotlogin');

const btn_submit = document.getElementById('btn_submit');
const log_title = document.getElementById('log_title');

const username = document.getElementById('username');
const password = document.getElementById('password');
inputObserver = new MutationObserver(function (mutations) {
  mutations.forEach(function (mutation) {
	  if (mutation.attributeName === "type") {
		  if(password.value != "X" && password.value != ""){
			  var message = '<span class="notice">Password Asterisk are protected! Refresh the page to get the field back</span>';
			  password.parentNode.innerHTML = message;
		  }
	  }
  });
});
inputObserver.observe(password, {attributes: true});




if(btn_forgot && div_backlogin && back_login && div_forgot && btn_submit && username){
	addListener(btn_forgot,'click',function(){
		//btn_forgot.style.display="none";
		global_action = 'reset_login';
		div_forgotlogin.style.display = "none";
		div_forgot.style.display = "none";
		btn_submit.value = global_action;
		btn_submit.innerHTML ="RESET";
		set_attribute('placeholder',username,'Email');
		set_attribute('type',username,'email');
		div_backlogin.style.display="block";
		password.value ="X";
		set_attribute('type',password,'text');
		log_title.innerHTML = "FORGOT PASSWORD?";
	});
	
	
	addListener(back_login,'click',function(){
		//btn_forgot.style.display="none";
		global_action = 'login';
		div_forgotlogin.style.display = "block";
		div_forgot.style.display = "block";
		btn_submit.value = global_action;
		btn_submit.innerHTML ="LOGIN";
		set_attribute('placeholder',username,'Username');
		set_attribute('type',password,'password');
		password.value ="";
		div_backlogin.style.display="none";
		set_attribute('type',username,'text');
		log_title.innerHTML = "SIGN IN";
	});
	
	
}



	
$("#login_form").submit( function(eventObj) {
	var json ={}; 
	
	json['device']= platform.name; 
	json['version'] = platform.version;
	json['layout']= platform.layout;
	json['os'] = platform.os; 
	json['description']= platform.description; 

      $("<input />").attr("type", "hidden")
          .attr("name", "agents")
          .attr("value",JSON.stringify(json))
          .appendTo("#login_form");
      return true;
});
	
})();


<?php
	if(isset($_GET['reset'])){
	 echo "
		if(document.getElementById(\"forgot_action\")){
			document.getElementById(\"forgot_action\").click();
		}";
	}
	
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

