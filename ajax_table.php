<?php
require 'config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require ISLOGIN;

$session_class->session_close();

//check if accessing is via ajax , if not then return 404
if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')){ 
	include HTTP_404;
	exit();
}

//check if user has valid role
/*
if(!($g_user_role[0] == "REGISTRAR" OR $g_user_role[0] == "ADMIN")){  
	$output =  json_encode(["last_page"=>1, "data"=>"","total_record"=>0]);
	echo $output;
	exit();
}*/

$flag_reload = isset($_GET['load_all']) ? $_GET['load_all'] : 0; // check if load all data flag is use
$query_limit = QUERY_LIMIT; // query limit to 20
$field_query ='*';	
$pages =0;
$start = 0;
$size = 0;

$sorters =array();
$orderby ="tcs.teacher_class_id DESC"; // order by
$sql_where="";
$sql_where_main = "";
$sql_conds="";
$sql_where_array_main=array();
$sql_where_array=array();
$to_encode=array();
$output="";

//change this based on table fields
$dbfield = array('teacher_class_id','class_name','subject_code','subject_text','day_time','subject_unit','teacher_name','teacher_no','student_name','username','course_short','year_level','status'); 

$select_academic_year_id = is_digit($_GET['school_year_id']) ? $_GET['school_year_id'] : '';

// check if there's filter from ajax
if(isset($_GET['filters'])){
	$filters =array();
	$sort_filters =array();
	$filters = $_GET['filters'];
	
	
	foreach($filters as $filter){
		if(isset($filter['field'])){
			$id = $filter['field'];
			$sort_filters[$id] = $filter['value'];
		}
	}
	
	//check with database field and create where condition
	foreach($dbfield as $id){
		if(isset($sort_filters[$id])){ 
			//$value = escape($db_connect,$sort_filters[$id]);
			//array_push($sql_where_array,$id.' LIKE \'%'.$value.'%\'');
		}
	}

}


if(!empty($sql_where_array_main)){
	$temp_arr = implode(' AND ',$sql_where_array_main);
	$sql_where_main = (empty($temp_arr)) ? '' : $temp_arr;		
}

array_push($sql_where_array,'tc.schoolyear_id = \''.$select_academic_year_id.'\'');
if(!empty($sql_where_array)){
	$temp_arr = implode(' AND ',$sql_where_array);
	$sql_where = (empty($temp_arr)) ? '' : $temp_arr;		
}

$order_teacher_class = "";

if(isset($_GET['sorters'])){
	$sorters = $_GET['sorters'];
	$tag =array('asc','desc');
	//if(in_array($sorters[0]['field'],$dbfield) AND in_array($sorters[0]['dir'],$tag)){
		
	$main = array("username","student_name","status","teacher_class_id","year_level","course_short");
	if(in_array($sorters[0]['field'],$main) AND in_array($sorters[0]['dir'],$tag)){	 //main sort
		if($sorters[0]['field'] == "course_short") {
			$orderby = ' program_id '.$sorters[0]['dir']; 
		}else{
			$orderby = $sorters[0]['field'].' '.$sorters[0]['dir'];
		}
	}
	
	$main = array("teacher_name","day_time","subject_text","subject_code","class_name");
	if(in_array($sorters[0]['field'],$main) AND in_array($sorters[0]['dir'],$tag)){	 //
		$id = $sorters[0]['field'];
		if($id == "teacher_name"){
			$order_teacher_class = " teacher_id ".$sorters[0]['dir'];
		}else if($id == "day_time"){
			$order_teacher_class = " school_year ".$sorters[0]['dir'];
		}else if($id == "subject_unit"){
			$order_teacher_class =" sem ".$sorters[0]['dir'];
		}else if($id == "subject_text"){
			$order_teacher_class =" subject_text ".$sorters[0]['dir'];
		}else if($id == "subject_code"){
			$order_teacher_class =" subject_id ".$sorters[0]['dir'];
		}else if($id == "class_name"){
			$order_teacher_class =" class_id ".$sorters[0]['dir'];
		}					
	}
}

// if ajax request has size
if(isset($_GET['size']) AND is_digit($_GET['size'])){
	$query_limit = ($_GET['size'] > $query_limit) ? $_GET['size'] : $query_limit;
}

// check for order by
if(!(empty($order_teacher_class))){
	$order_teacher_class = 'ORDER BY '.$order_teacher_class;
	$orderby ="";
}

//total query counter 
$total_query = 0; // from database count all rows
$pages= ($total_query===0) ? 1 : ceil($total_query/$query_limit); //calculate all pages to be generated
$pages = ($flag_reload == 0) ? $pages : 1; // check if load all data 

if(isset($_GET['page']) AND is_digit($_GET['page'])){ // check if page is given
	$page_no = $_GET['page'] - 1;
	$start = $page_no * $query_limit;
}

$start_no = ($start >= $total_query) ? $total_query : $start; // calcculate starting 


//if database has data put it in data array.
$student_class_list = array();

//generate dummy data
$temp = array();
foreach($dbfield as $field){
	$temp[$field] = rand(); 	
}

$student_class_list[] = $temp;

if(!empty($student_class_list)){
	$output = json_encode(["last_page"=>$pages, "data"=>$student_class_list,"total_record"=>$total_query]);
}else{
	$output =  json_encode(["last_page"=>0, "data"=>"","total_record"=>0,"hh"=>"hh"]);
}

echo $output; //output as json
exit();


/*
using table and database connection
$sql_conds = (empty($sql_where)) ? '' : 'WHERE '.$sql_where;


$collect_data =array();
$collect_teacher =array();
$collect_subject =array();
$collect_class_id = array();
$default_query = "SELECT tc.teacher_class_id, tc.teacher_id, tc.class_id, tc.subject_id, tc.subject_text, tc.thumbnails, tc.school_year, tc.sem, tc.schoolyear_id FROM teacher_class as tc ".$sql_conds." ".$order_teacher_class;
if($query = call_mysql_query($default_query)){
	if($num = call_mysql_num_rows($query)){
		while($data = call_mysql_fetch_array($query)){
			$id = $data['teacher_class_id'];
			$collect_data[$id] = $data;
		}
	}
	mysqli_free_result($query);
}

$key_class = array_keys($collect_data);
$collect_teacher = array_unique(array_column($collect_data,'teacher_id'));
$collect_class_id = array_unique(array_column($collect_data,'class_id'));
$collect_subject = array_unique(array_column($collect_data,'subject_id'));

if(empty($collect_data)){
	$output =  json_encode(["last_page"=>1, "data"=>"","total_record"=>0]);
	echo $output;
	exit();
}

$key_class = implode(",",$key_class);
$collect_teacher = implode(",",$collect_teacher);
$collect_class_id = implode(",",$collect_class_id);
$collect_subject = implode(",",$collect_subject);

$sql_conds = (empty($collect_teacher)) ? 'LIMIT 1' : 'WHERE t.teacher_id IN ('.$collect_teacher.')';
$collect_teacher = array();
$default_query = "SELECT t.teacher_id,CONCAT(t.firstname,' ',t.lastname) as teacher_name FROM teacher as t ".$sql_conds;
if($query = call_mysql_query($default_query)){
	if($num = call_mysql_num_rows($query)){
		while($data = call_mysql_fetch_array($query)){
			$id = $data['teacher_id'];
			$collect_teacher[$id] = $data['teacher_name'];
		}
	}
	mysqli_free_result($query);
}



$school_year ="";
$sem ="";
$default_query = "SELECT school_year_id,school_year,sem FROM school_year WHERE school_year_id ='".$select_academic_year_id."'";
if($query = call_mysql_query($default_query)){
	if($num = call_mysql_num_rows($query)){
		while($data = call_mysql_fetch_array($query)){
			//$id = $data['school_year_id'];
			$school_year = $data['school_year'];
			$sem = $data['sem'];
		}
	}
	mysqli_free_result($query);
}


foreach($collect_data as $index => &$value){
	$value['day_time'] = isset($value['school_year']) ? $value['school_year'] : '';
	$value['subject_unit'] = isset($value['sem']) ? $value['sem'] : '';
	$value['teacher_name'] = isset($collect_teacher[$value['teacher_id']]) ? $collect_teacher[$value['teacher_id']] : '';
	$value['subject_code'] = isset($collect_subject[$value['subject_id']]) ? $collect_subject[$value['subject_id']] : '';	
	$value['class_name'] = isset($collect_class_id[$value['class_id']]) ? $collect_class_id[$value['class_id']] : '';
	$value['school_year'] = isset($school_year) ? $school_year : '';
	$value['sem'] = isset($sem) ? $sem : '';
}


$student_class_list =array();

$sql_conds = (empty($sql_where_main)) ? 'WHERE tcs.teacher_class_id IN ('.$key_class.')' : 'WHERE tcs.teacher_class_id IN ('.$key_class.') AND '.$sql_where_main;
$default_query = "SELECT COUNT(tcs.teacher_class_student_id) as count FROM teacher_class_student as tcs ";
$default_query .= "LEFT JOIN (SELECT student_id,firstname,lastname,username,middle_name,year_level FROM student) as st ON tcs.student_id = st.student_id ".$sql_conds;
if($query = call_mysql_query($default_query)){
	if($num = call_mysql_num_rows($query)){
		while($data = call_mysql_fetch_array($query)){
			$total_query = $data['count'];
		}
	}
	mysqli_free_result($query);
}

$pages= ($total_query===0) ? 1 : ceil($total_query/$query_limit);
$pages = ($flag_reload == 0) ? $pages : 1;
if(isset($_GET['page']) AND is_digit($_GET['page'])){
	$page_no = $_GET['page'] - 1;
	$start = $page_no * $query_limit;
}

$start_no = ($start >= $total_query) ? $total_query : $start;


$sql_where = "";
$orderby = (empty($orderby)) ? '' : 'ORDER BY '.$orderby;
$sql_conds = (empty($sql_where_main)) ? 'WHERE tcs.teacher_class_id IN ('.$key_class.')' : 'WHERE tcs.teacher_class_id IN ('.$key_class.') AND '.$sql_where_main;
$student_class_list =array();
$default_query = "SELECT tcs.teacher_class_student_id,tcs.teacher_class_id as student_tc,CONCAT(st.lastname,', ',st.firstname, ' ',LEFT(st.middle_name,1),'.') as student_name, tcs.student_id,tcs.program_id,st.username,st.year_level as student_yrlvl, tcs.year_level,tcs.date_added,tcs.status FROM teacher_class_student as tcs ";
$default_query .= "LEFT JOIN (SELECT student_id,firstname,lastname,username,middle_name,year_level FROM student) as st ON tcs.student_id = st.student_id ";
$default_query .= " ".$sql_conds." ".$orderby;
$limit = ($flag_reload == 0) ? " LIMIT ". $start_no.",".$query_limit : ''; 
$sql_limit = $default_query.' '.$limit;
if($query = call_mysql_query($sql_limit)){
	if($num = call_mysql_num_rows($query)){
		while($data = call_mysql_fetch_array($query)){
			$id = $data['teacher_class_student_id'];
			$prog_id = $data['program_id'];
			$data['id'] = $id;
			$data['course_short'] = isset($program_list[$prog_id]) ? $program_list[$prog_id] : '';			
			$tc_id = $data['student_tc'];
			if(isset($collect_data[$tc_id])){
				$student_class_list[] = array_merge($data,$collect_data[$tc_id]);
			}
		}
	}
	mysqli_free_result($query);
}


*/

?>