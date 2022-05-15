<?php
require '../config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require ISLOGIN;

$session_class->session_close();

function random_password($length,$keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'){
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    if ($max < 1) {
        throw new Exception('$keyspace must be at least two characters long');
    }
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
}



if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')){
	include HTTP_404;
	exit();
}


header("Content-type: application/json; charset=utf-8");

if(!($g_user_role[0] == "ADMIN" OR $g_user_role[0] == "REGISTRAR")){ 
    $response_msg['msg'] = '';
	$response_msg['errors'] = 'Invalid User Role!';
	$response_msg['result']= 'error';
	echo output($response_msg);
	exit();
}

$action = isset($_POST['action']) ? $_POST['action']:'';
$user_id =  isset($_POST['user_id']) ? $_POST['user_id']:'';
$type =  isset($_POST['type']) ? $_POST['type']:'';



$error =false;
$response_msg =array();
$response_msg['errors']="";
$response_msg['result'] ="";
$response_msg['msg'] ="";
$response_msg['token'] ="";
$to_encode=array();


if(empty($user_id) OR !is_digit($user_id)){
	$error =true;
	$response_msg['msg'] = '';
	$response_msg['errors'] = 'No User Selected!';
	$response_msg['result']= 'error';
	echo output($response_msg);
	exit();
}

$expected = array('INSTRUCTOR','STUDENT','ADMINS');
if(!in_array($type,$expected)){
	$error =true;
	$response_msg['msg'] = '';
	$response_msg['errors'] = 'Invalid User Type!';
	$response_msg['result']= 'error';
	echo output($response_msg);
	exit();
}

$log_array = array();
$new_pw_text = random_password(8);
$new_password = set_password($new_pw_text);
if($new_password == ""){
	$error =true;
	$response_msg['msg'] = '';
	$response_msg['errors'] = 'Unable to generate new password!';
	$response_msg['result']= 'error';
	echo output($response_msg);
	exit();
}



if($action == "RESET_PASSWORD" AND $type == "ADMINS" AND $g_user_role[0] == "ADMIN"){
		$sql_query = "SELECT user_id,id_no,username,firstname,lastname,user_role FROM users WHERE user_id = '".$user_id."' LIMIT 1";
		$tmp_array = array();
		if($query = call_mysql_query($sql_query)){
			if($num = call_mysql_num_rows($query)){
				if($array = call_mysql_fetch_array($query)){
					$log_array = array('ADMIN_ID'=>$array['user_id'],'ADMIN_NO'=>$array['id_no'],'FIRSTNAME'=>$array['firstname'],'LASTNAME'=>$array['lastname'],'USERNAME'=>$array['username'],'USER_ROLE'=>$array['user_role']);
				}
			}
		}	
	
	
		if(!empty($log_array)){
			
			$reset_query = "UPDATE users SET password = '".$new_password."',locked = '0' WHERE user_id = '".$user_id."'";
			call_mysql_query($reset_query);
			activity_log_new("Reset Password Admin Account:".$array['username'] ." - DETAILS : \r\n(".json_encode($log_array).")");
			
			$response_msg['errors']="";
			$response_msg['msg'] = $new_pw_text;
			$response_msg['result'] ="success";		
			echo output($response_msg);
			exit();
		}

}else{
	$response_msg['msg'] = '';
	$response_msg['errors'] = 'Invalid Request!';
	$response_msg['result']= 'error';
	echo output($response_msg);
	exit();
}

	
	

$response_msg['errors']="Unable to save!";
$response_msg['msg'] = '';
$response_msg['result'] ="error";		
echo output($response_msg);
exit();
	

?>