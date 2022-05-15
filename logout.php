<?php
require 'config/config.php';
require CONNECT_PATH;
require GLOBAL_FUNC;
require CL_SESSION_PATH;

$g_user_role = $session_class->getValue('role_id');
$g_user_name = $session_class->getValue('name');

$event   = isset($_GET['event']) ? "@".$_GET['event']: ''; 

$location ="index.php";
if($g_user_role[0]=="ADMIN"  OR $g_user_role[0]=="REGISTRAR" OR  $g_user_role[0]=="VPAA" ){
	user_log('LOGOUT');
	$location = BASE_URL."index.php";
}

$session_class->end();
header('Location: '.$location); 
exit();
?>