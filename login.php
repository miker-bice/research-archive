<?php
require 'config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$error_encountered  = false;
$num_row =0;
$reset_password="";
$row_teacher=array();


$csrf = new CSRF($session_class); 
$token_1 = $csrf->validate('token_login_admin_form',$_POST['token_login_admin_form']);
if($token_1) {
	
}else{
	$error=true;
	$msg_response = array();
	$msg_response['status']="error";
	$msg_response['msg']="Invalid Auth-Token";
	$session_class->setValue('error',$msg_response['msg']);
	header('Location: '.BASE_URL.'app/admin/index.php'.$reset_password);
	exit();
}



if(isset($_POST['username']) AND isset($_POST['password']) AND isset($_POST['submit']) AND $_POST['submit'] =="login" ){
	$msg_response = array();
	$msg_response['status']="";
	$msg_response['msg']="";

	$username = isset($_POST['username']) ? trim($_POST['username']) : '';
	$password = isset($_POST['password']) ? trim($_POST['password']) : '';
	$agent = isset($_POST['agents']) ? json_decode($_POST['agents'],true):array();
	//var_dump($agent);
	//exit();
	

	if(!empty($username) AND !empty($password)){
			/* student */
			
		$password =set_password($password);
		$query = "SELECT user_id,username,password,firstname,lastname,location,user_role,status,locked FROM users WHERE username='".escape($db_connect,$username)."' LIMIT 1";
				$result = mysqli_query($db_connect,$query);
		if($result){
			$num_row = mysqli_num_rows($result);
			$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

		}
		
		$session_class->incValue('browser_attempt_login',1);
		$error_login = false;
		

		if($num_row == 0 ){
			$msg_response['status']="error";
			$msg_response['msg']="Please Check your username";
		}else if( $num_row > 0 ) { 
			$name =$row['firstname']." ".$row['lastname'];
			
			if($row['status']==1){
				$msg_response['status']="error";
				$msg_response['msg']="Deactivated Account";
			}else{
				
				$row['location']  = empty(trim($row['location'])) ? "" : BASE_URL.$row['location'];
				
				$login_attempt = 0;
				if($row['password'] != $password){
					$session_class->setValue('last_user',sha1($username));
					$session_class->incValue("login_attempt_".sha1($username),1);
					$error_login =true;
					$msg_response['status']="error";
					$msg_response['msg']="Please check Username and Password!";
					
					$login_attempt =  $session_class->getValue('login_attempt_'.sha1($username));
				}

				if($row['locked'] == 1){
					$msg_response['status']="error";
					$msg_response['msg']="Account ".var_html($username)." has been locked.Please reset password or Contact System Admin.!";
				}else if(!empty($login_attempt) AND $login_attempt >=4 ){
					$msg_response['status']="error";
					$msg_response['msg']="Account ".var_html($username)." has been locked.Please reset password or Contact System Admin.!";
					$locked_query = "UPDATE users SET locked = '1' WHERE user_id = '".$row['user_id']."'";
					if(mysqli_query($db_connect,$locked_query)){
						
					}		
				}else if($row['user_role'] == 1 AND !$error_login){ //admin
					$session_class->setValue('user_id',$row['user_id']);
					$session_class->setValue('role_id',array('ADMIN'));
					$session_class->setValue('photo',$row['location']);
					$session_class->setValue('name',$name); 
					$session_class->setValue('agent_browser',$agent);
					$fingerprint = $session_class->getValue('fingerprint');
					$session_class->setValue('browser_fingerprint',$fingerprint);
					
					$session_class->setValue('success',"Welcome to e-GURO");
					$session_class->dropValue('browser_attempt_login');
					user_log("LOGIN",$agent);
					header('Location:'.BASE_URL.'main.php');
					exit();

				}else if($row['user_role'] == 2 AND !$error_login){ //registrar
					$session_class->setValue('user_id',$row['user_id']);
					$session_class->setValue('role_id',array('REGISTRAR'));
					$session_class->setValue('photo',$row['location']);
					$session_class->setValue('name',$name); 
					$session_class->setValue('agent_browser',$agent);
					$fingerprint = $session_class->getValue('fingerprint');
					$session_class->setValue('browser_fingerprint',$fingerprint);

					$session_class->setValue('success',"Welcome to e-GURO");
					$session_class->dropValue('browser_attempt_login');
					user_log("LOGIN",$agent);
					header('Location:'.BASE_URL.'main.php');
					exit();
				}else if($row['user_role'] == 3 AND !$error_login){ //VPAA
					$session_class->setValue('user_id',$row['user_id']);
					$session_class->setValue('role_id',array('VPAA'));
					$session_class->setValue('photo',$row['location']);
					$session_class->setValue('name',$name); 
					$session_class->setValue('agent_browser',$agent);
					$fingerprint = $session_class->getValue('fingerprint');
					$session_class->setValue('browser_fingerprint',$fingerprint);

					$session_class->setValue('success',"Welcome to e-GURO");
					$session_class->dropValue('browser_attempt_login');
					user_log("LOGIN",$agent);
					header('Location: '.BASE_URL.'main.php');
					exit();
				}	
			}
		}
 	
	}else{
		$msg_response['status']="error";
		$msg_response['msg']="Invalid Input";
	}
	
}else if(isset($_POST['username']) AND isset($_POST['submit']) AND $_POST['submit'] =="reset_login" ){
	
	$agent = isset($_POST['agents']) ? json_decode($_POST['agents']):array();
	$emailto = isset($_POST['username']) ? trim($_POST['username']) : '';
	$error =false;
	$reset_password ="?reset=true";
	if($emailto ==""){
		$error = true;
		$msg_response['status']="error";
		$msg_response['msg']="Provide Email";
	}
	
	require DOMAIN_PATH.'/call_func/Exception.php';
	require DOMAIN_PATH.'/call_func/PHPMailer.php';
	require DOMAIN_PATH.'/call_func/SMTP.php';
	require DOMAIN_PATH.'/config/smtp_data.php';
	
	if (!filter_var($emailto, FILTER_VALIDATE_EMAIL)) {
		$error = true;
		$msg_response['status']="error";
		$msg_response['msg']="Provide Valid Email";
	}
	
	if($error == false){
		$num_row =0;
		$query = "SELECT * FROM users WHERE email_address='".escape($db_connect,$emailto)."'";
		if($result = mysqli_query($db_connect,$query)){
			$num_row = mysqli_num_rows($result);
			$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

		}
			
		$firstname ="";
		$user_id = "";
		$user_role = "";
		if($num_row == 0){
			$msg_response['status']="error";
			$msg_response['msg']="Internal Complict";
		}else if( $num_row > 0 ) { 
			//found student
			$firstname = $row['firstname'];
			$user_id = $row['user_id'];
			$user_type =1;
			
			
			if($row['user_role'] == 1){
				$user_role = "ADMIN";
			}else if($row['user_role'] == 2){
				$user_role = "REGISTRAR";
			}else{
				$user_role = "VPAA";
			}
			
		}else{
			$msg_response['status']="error";
			$msg_response['msg']="Email not found!";
		}
		
		
		if($firstname!="" AND $user_id!=""){
			
			$n = 24;
			$code = bin2hex(openssl_random_pseudo_bytes($n/2));
	
			$exp_date = date("Y-m-d H:i:s", strtotime('+4 hours', strtotime(DATE_NOW." ".TIME_NOW)));
			$reset = "INSERT INTO reset_code(reset_code,user_id,email_address,created,expire_date,status,user_type) VALUES ('".$code."','".$user_id."','".escape($db_connect,$emailto)."','".DATE_NOW." ".TIME_NOW."','".$exp_date."','0','".$user_type."')";
			if(mysqli_query($db_connect,$reset)){
					$reset_id = mysqli_insert_id($db_connect);
					$website_url = BASE_URL;
					$link_reset =BASE_URL."reset_password.php?code=".$code;
					$emailTo = $emailto;
					
					$mail = new PHPMailer;
					$mail->isSMTP(); 
					$mail->isHTML = true;
					$mail->SMTPDebug = 0; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
					$mail->Host = SMTP_HOST;
					$mail->Port = SMTP_PORT;
					//$mail->SMTPSecure = SMTP_SECURE;
					$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
					$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
					$mail->SMTPAutoTLS = false;
    	                $mail->SMTPOptions = array(
                        'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                        )
                    );
		
						
					$mail->Username = SMTP_USER;
					$mail->Password = SMTP_PASS;
					  //Recipients
					$mail->setFrom(SMTP_FROMEMAIL,SMTP_FROMNAME);
					$mail->addReplyTo(SMTP_REPLYTO,SMTP_REPLYNAME);
					$mail->addAddress($emailTo);
					$mail->Subject = 'Password Reset Request';      // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
					
					$msg_raw="<!DOCTYPE html><html lang='en'><head><title>e-Guro</title></head><body>";
					include DOMAIN_PATH.'/app/global/reset_body.php';
					$msg_raw .= "</body></html>";
					$mail->msgHTML($msg_raw);
					$mail->AltBody = $msg_text;

					if(!$mail->send()){
						$msg_response['status']="error";
						$msg_response['msg']="Email Server Error";
						//echo "Mailer Error: " . $mail->ErrorInfo;
						//exit();
					}else{
						//echo "Message sent!";
						
						$fingerprint = $session_class->getValue('fingerprint');
						$session_class->setValue('agent_browser',$agent);
						$session_class->setValue('browser_fingerprint',$fingerprint);
						$session_class->setValue('user_id',$user_id);
						$session_class->setValue('role_id',array($user_role));
											
						$log = json_encode(array('RESET_ID'=>$reset_id,'RESET_CODE'=>$code,'USER_ID'=>$user_id,'EMAIL'=>$emailto,'DATE_TIME'=>DATE_NOW.' '.TIME_NOW,'EXP_TIME'=>$exp_date));											
						activity_log_new("REQUEST - RESET CODE [EMAIL - ".$emailto."] - Details::".$log);	
												
						$session_class->dropValue('user_id');
						$session_class->dropValue('role_id');
						$session_class->dropValue('browser_fingerprint');
						$session_class->dropValue('agent_browser');
					
						$msg_response['status']="ok";
						$msg_response['msg']="Password Reset Email Sent!";
						$session_class->end();
						$reset_password="";
					}
					
			}
		
		}
		
		

	}
}
if(isset($msg_response['msg']) AND $msg_response['status'] == "error" ){
	$session_class->setValue('error',$msg_response['msg']);
}else if(isset($msg_response['msg']) AND $msg_response['status'] == "ok" ){
	$session_class->setValue('success',$msg_response['msg']);
}

header('Location:'.BASE_URL.'app/admin/index.php'.$reset_password);
exit();
//echo output($msg_response);

		
?>
