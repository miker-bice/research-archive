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

if(!($g_user_role[0] == "ADMIN" OR $g_user_role[0] == "REGISTRAR")){  
	$output =  json_encode(["last_page"=>1, "data"=>"","total_record"=>0]);
	echo $output;
	exit();
}

//table initial
$query_limit = QUERY_LIMIT;
$table_name= "activity_log";
$field_query ='*';	
$pages =0;
$start = 0;
$size = 0;

$sorters =array();
$orderby ="activity_log_id DESC";
$sql_where="";
$sql_conds="";
$sql_where_array=array();
$to_encode=array();
$output="";

$dbfield = array('al.date_log','al.action','CONCAT(u.firstname," ",u.lastname) as name'); // need iset based sa table columns
$dborig = array('date_log','action','name'); // tabulator  checking

if(isset($_GET['filters'])){ // check yung filter
	$filters =array();
	$sort_filters =array();
	$filters = $_GET['filters'];
	
	
	foreach($filters as $filter){
		if(isset($filter['field'])){
			$id = $filter['field'];
			$sort_filters[$id] = $filter['value'];
		}
	}
	
	foreach($dborig as $id){
		if(isset($sort_filters[$id])){
			$value =escape($db_connect,$sort_filters[$id]);
			if($id == 'name'){
				array_push($sql_where_array,' CONCAT (u.firstname," ",u.lastname) LIKE \'%'.$value.'%\'');
				continue;
			}
			array_push($sql_where_array,$id.' LIKE \'%'.$value.'%\'');
		}
	}

}

if(!empty($sql_where_array)){
	$temp_arr = implode(' AND ',$sql_where_array);
	$sql_where = (empty($temp_arr)) ? '' : $temp_arr;		
}

if(isset($_GET['sorters'])){ // for sorter
	$sorters = $_GET['sorters'];
	$tag =array('asc','desc');
	if(in_array($sorters[0]['field'],$dborig) AND in_array($sorters[0]['dir'],$tag)){
		$orderby = $sorters[0]['field'].' '.$sorters[0]['dir'];
	}
}

if(isset($_GET['size']) AND is_digit($_GET['size'])){ // page size
	$query_limit = ($_GET['size'] > $query_limit) ? $_GET['size'] : $query_limit;
}

//total query counter 
$field_query ='COUNT(DISTINCT activity_log_id) as count'; // baguhin based sa need
$sql_conds = (empty($sql_where)) ? '' : 'WHERE '.$sql_where;
$default_query ="SELECT ".$field_query." FROM ".$table_name." as al  LEFT JOIN (SELECT firstname,lastname,user_id FROM users) as u ON u.user_id = al.user_id  ".$sql_conds;
$total_query = 0;
if($query = call_mysql_query($default_query)){
	if($num = call_mysql_num_rows($query)){
		while($data = call_mysql_fetch_array($query)){
			$total_query = $data['count'];
		}
	}
}
$pages= ($total_query===0) ? 1 : ceil($total_query/$query_limit);
if(isset($_GET['page']) AND is_digit($_GET['page'])){
	$page_no = $_GET['page'] - 1;
	$start = $page_no * $query_limit;
}

$start_no = ($start >= $total_query) ? $total_query : $start;
$field_query = implode(',',$dbfield);
$sql_conds = (empty($sql_where)) ? '' : 'WHERE '.$sql_where; // ichange based sa need
$default_query ="SELECT ".$field_query." FROM ".$table_name." as al  LEFT JOIN (SELECT firstname,lastname,user_id FROM users) as u ON u.user_id = al.user_id  ".$sql_conds."   ORDER BY ".$orderby;
$limit=" LIMIT ". $start_no.",".$query_limit; 
$sql_limit=$default_query.' '.$limit;

if($query = call_mysql_query($sql_limit)){
	if($num = call_mysql_num_rows($query)){
		while($data = call_mysql_fetch_array($query)){
			$data = array_html($data);
			$to_encode[] = $data;
		}
	}
	$output = json_encode(["last_page"=>$pages, "data"=>$to_encode,"total_record"=>$total_query]);
}else{
	$output =  json_encode(["last_page"=>0, "data"=>"","total_record"=>0]);
}

echo $output; //output

?>