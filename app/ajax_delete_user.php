<?php
require '../config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require ISLOGIN;

$session_class->session_close();

if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')){
	include HTTP_404;
	exit();
}


header("Content-type: application/json; charset=utf-8");

if(!($g_user_role[0] == "ADMIN")){ 
    $response_msg['msg'] = '';
	$response_msg['errors'] = 'Invalid User Role!';
	$response_msg['result']= 'error';
	echo output($response_msg);
	exit();
}



$action = isset($_POST['action']) ? $_POST['action']:'';

$error =false;
$response_msg =array();
$response_msg['errors']="";
$response_msg['result'] ="";
$response_msg['msg'] ="";
$response_msg['token'] ="";
$to_encode=array();


$values =  isset($_POST['user_ids']) ? $_POST['user_ids']:'';

if(empty($values)){
	$error =true;
	$response_msg['msg'] = '';
	$response_msg['errors'] = 'No User Selected!';
	$response_msg['result']= 'error';
	echo output($response_msg);
	exit();
}

$array_users= json_decode($values);

if ($array_users === null && json_last_error() !== JSON_ERROR_NONE) {
	$response_msg['msg'] = '';
	$response_msg['errors'] = 'Invalid Input JSON!';
	$response_msg['result']= 'error';
	echo output($response_msg);
	exit();
}

foreach ($array_users as $value) {
	$value = trim($value);
	if(empty($value) OR  !(is_digit($value))){
		$error =true;
		$response_msg['msg'] = '';
		$response_msg['errors'] = 'Invalid Input!';
		$response_msg['result']= 'error';
		break;
	}
}

if($error){
	echo output($response_msg);
	exit();
}


if($action == "DELETE_USER" AND !empty($array_users)){

	$list =  implode(",",$array_users);
	$sql_query = "SELECT username,id_no,user_id,firstname,lastname,email_address FROM users WHERE user_id IN (".$list.")";	
	$tmp_array = array();
	if($query = call_mysql_query($sql_query)){
		if($num = call_mysql_num_rows($query)){
			while($array = call_mysql_fetch_array($query)){
				$index = $array['user_id'];
				$text = " ".$array['id_no']."::".$array['firstname']." ".$array['lastname']."::".$array['email_address']." [".$index."] ";
				array_push($tmp_array,$text);
			}
		}
	}
		
	$log = implode("\r\n",$tmp_array);	
	$update = "UPDATE users SET id_no='', username='',email_address='',status = '1' WHERE user_id IN (".$list.")";
	if($query = call_mysql_query($update)){
		if($num = call_mysql_affected_rows()){
			activity_log_new("Delete User/s - DETAILS : \r\n(".$log.")");
			
			$response_msg['errors']="";
			$response_msg['msg'] = '';
			$response_msg['result'] ="success";
		}
	}
	
	if(empty($response_msg['result'])) {   
		$response_msg['errors']="Unable to Delete, Data not found!";
		$response_msg['msg'] = '';
		$response_msg['result'] ="error";	
	}
	echo output($response_msg);
	exit();
	
}
?>