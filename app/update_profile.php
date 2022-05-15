<?php
$update_profile_form = array(
	array('name' => 'first_name' , 'rules' => "required|valid_name", 'display'=>'First name'),
	array('name' => 'last_name' , 'rules' => "required|valid_name", 'display'=>'Last name'),
	array('name' => 'email' , 'rules' => 'required|valid_email', 'display'=>'Identification No :')
	);


$update_profile_form_rules=array();
$update_profile_form_labels=array();
$f_name = "";
foreach($update_profile_form as $value){ 
	$f_name = $value['name'];
	$update_profile_form_rules[$f_name] = $value['rules'];
	$update_profile_form_labels[$f_name] = $value['display'];
}

$update_profile_form_js_field = json_encode($update_profile_form); 
?>