<?php
/** 
==================================================================
 File name   : config.php
 Version     : 1
 Begin       : 2022-05-10
 Last Update : 2022-05-10
 Author      : Alvin M. Montiano
 Description : Configuration
 =================================================================
**/
$envi = 'PROD';
$before_memory = 0;
//default settings values
$config['filesize_limit'] = 20971520;//50000000;//20MB FILE UPLOAD LIMIT
$close_conn = true;


//date_default_timezone_set('UTC');
define("DOMAIN_PATH", dirname(__DIR__));
define("UPLOAD_PATH", DOMAIN_PATH.'/upload/files');
define("DEFAULT_TIMEZONE",'Asia/Hong_Kong');
define("LANG",'en');
define("META_AUTHOR",'');
define("META_DESC",'');

$url =  base_url();
define("BASE_URL",$url);
ini_set('date.timezone',DEFAULT_TIMEZONE);
date_default_timezone_set(DEFAULT_TIMEZONE);


define("FILE_LIMIT",$config['filesize_limit']);
define('YEAR',date('Y'));
define('MONTH',date('m'));
define('DAY',date('d'));
define('DATE_NOW',date('Y-m-d'));
define('TIME_NOW',date('H:i:s'));
define('FILE_VERSION', '1.1.3');
define('PAGE_TITLE', 'WEB APP');
define('QUERY_LIMIT', 20);
//ERROR HTML
include DOMAIN_PATH .'/error_page/error_path.php';


//Define Application Groups....


$global_user_status =array(1=>"active",2=>"locked",3=>"archived");


//function path
define('CL_SESSION_PATH' , DOMAIN_PATH .'/call_func/cl_session.php');
define('CONNECT_PATH' , DOMAIN_PATH.'/call_func/connect.php');
define('VALIDATOR_PATH' , DOMAIN_PATH.'/call_func/validator.php');
define('GLOBAL_FUNC' , DOMAIN_PATH.'/call_func/global_func.php');
define('FOOTER_PATH' , DOMAIN_PATH.'/call_func/footer.php');
##define('MENU' , DOMAIN_PATH.'/admin/menu.php');
define('GRADE_MODULE' , DOMAIN_PATH.'/call_func/compute_grade.php');
define('ISLOGIN' , DOMAIN_PATH.'/call_func/islogin.php');
define('PASSWORD_HELPER' , DOMAIN_PATH.'/call_func/password_helper.php');

//global var
define('DEFAULT_SESSION', 'web_session');
define('SALT', '1234TREWPOIUYT_'); //change me
define('SESSION_CONFIG', array('name' => DEFAULT_SESSION,'path' => '/','domain' => '','secure' => false,'bits' => 4,'length' => 32,'hash' => 'sha256','decoy' => true,'min' => 60,'max' => 600,'debug' => false));


if (!file_exists(UPLOAD_PATH)) {
    mkdir(UPLOAD_PATH, 0777, true);
}


if($envi  =='DEV'){
	ifexist_ini_set("display_errors", 1);
	//error_reporting(-1);
	error_reporting(E_ALL ^ E_NOTICE);  
	ifexist_ini_set("error_log", join(DIRECTORY_SEPARATOR,array(DOMAIN_PATH,"upload","logs","php-error.log")));
	$before_memory = print_mem();
}else{
	ifexist_ini_set('display_errors', 0);
	ifexist_ini_set("log_errors", 1);
	//error_reporting(E_ALL & ~E_NOTICE);
	ifexist_ini_set("error_log", join(DIRECTORY_SEPARATOR,array(DOMAIN_PATH,"upload","logs","php-error.log")));

}

function ifexist_ini_set($func,$key){
	  if(!function_exists('ini_set')){
		 
		 return;
	  }
	  ini_set($func,$key); 
}

function file_upload_max_size() {
  static $max_size = -1;

  if ($max_size < 0) {
    // Start with post_max_size.
    $post_max_size = parse_size(ini_get('post_max_size'));
    if ($post_max_size > 0) {
      $max_size = $post_max_size;
    }

    // If upload_max_size is less, then reduce. Except if upload_max_size is
    // zero, which indicates no limit.
    $upload_max = parse_size(ini_get('upload_max_filesize'));
    if ($upload_max > 0 && $upload_max < $max_size) {
      $max_size = $upload_max;
    }
  }
  return $max_size;
}


function parse_size($size) {
  $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
  $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
  if ($unit) {
    // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
    return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
  }
  else {
    return round($size);
  }
}

function mem_convert($size)
{
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}


function print_mem()
{
   /* Currently used memory */
   $mem_usage = memory_get_usage();
   
   /* Peak memory usage */
   $mem_peak = memory_get_peak_usage();

   $return = 'The script is now using: <strong>' . mem_convert($mem_usage) . '</strong> of memory.<br>';
   $return .=  'Peak usage: <strong>' . mem_convert($mem_peak) . '</strong> of memory.<br><br>';
   
  return $return;
}
function page_url(){
	$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	return $actual_link;
}

function base_url(){   
// first get http protocol if http or https
    $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']!='off') ? 'https://' : 'http://';
    #$base_url .= "192.168.0.100/final_lms_prod/"; #change to localhost or domain
	//$base_url .= "192.168.0.6/final_lms_prod/"; #change to localhost or domain
	$base_url .= "localhost/web_app/"; #change to localhost or domain
    return $base_url; 

}

?>