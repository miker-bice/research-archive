<?php
if($g_user_role[0]=="ADMIN"  OR $g_user_role[0]=="REGISTRAR"){
	header("Location: ".BASE_URL."main.php");
	exit();	
}
?>