<?php
defined('DOMAIN_PATH') || define('DOMAIN_PATH', dirname(__DIR__));
include DOMAIN_PATH.'/config/db_data.php';
$db_connect = mysqli_connect(HOST,DB_USER,DB_PASS,DB_NAME);

if (mysqli_connect_errno($db_connect)){
  $error = "Failed to connect to Database: " . mysqli_connect_error();
  error_log($error);
  echo $error;
  exit();
}

function escape($con = "",$str){
	global $db_connect;
	$string=mysqli_real_escape_string($db_connect,$str);
	return $string;
}

function db_close(){
	global $db_connect;
	mysqli_close($db_connect);
}

function call_mysql_query($query,$connect = ''){
	global $db_connect;
	$connect = empty($connect) ? $db_connect : $connect;
	if(empty($query)) { return false; }
    $r = mysqli_query($connect,$query);
    return $r;
}


function call_mysql_fetch_array($query,$resulttype=MYSQLI_ASSOC,$connect=''){
	global $db_connect;
	return mysqli_fetch_array($query,$resulttype);
}

function call_mysql_num_rows($query){
	$result = 0;
	if($query){
		$result = mysqli_num_rows($query);
	}
	return $result;
}

function call_mysql_affected_rows($connect = ''){
	global $db_connect;
	$connect = empty($connect) ? $db_connect : $connect;
	return mysqli_affected_rows($connect);
}


function mysqli_query_return($sql_query,$connect = ""){
	global $db_connect;
	$connect = empty($connect) ? $db_connect : $connect;
	$rdata = array();
	if(empty($sql_query)) { return $rdata;}  
	
  	if($query = mysqli_query($connect,$sql_query)){
		if($num = mysqli_num_rows($query)){
			while($data = mysqli_fetch_array($query,MYSQLI_ASSOC)){
				array_push($rdata,$data);
			}
		}
	}

	return $rdata;
}

function mysqliquery_return($sql_query,$connect ="",$type = MYSQLI_ASSOC){
	global $db_connect;
	
	$connect = (empty($connect)) ? $db_connect : $connect;
    $rdata = array();
	
	if($query=mysqli_query($connect,$sql_query)){
		$num=mysqli_num_rows($query);
		if($num > 0){
			while($data=mysqli_fetch_array($query,$type)){
				$rdata[] = $data;
			}
		}
	}
	return $rdata;
}

?>