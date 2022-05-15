<?php
$update_password_form = array(
	array('name' => 'current_password' , 'rules' => "required", 'display'=>'Current Password'),
	array('name' => 'new_password' , 'rules' => "required", 'display'=>'New Password'),
	array('name' => 'confirm_password' , 'rules' => 'required', 'display'=>'Confirm Password')
	);


$update_password_form_rules=array();
$update_password_form_labels=array();
$f_name = "";
foreach($update_password_form as $value){ 
	$f_name = $value['name'];
	$update_password_form_rules[$f_name] = $value['rules'];
	$update_password_form_labels[$f_name] = $value['display'];
}

$update_password_form_js_field = json_encode($update_password_form); 
?>