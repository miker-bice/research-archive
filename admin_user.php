<?php
require 'config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require ISLOGIN;// check kung nakalogin

if(!($g_user_role[0] == "ADMIN")){ 
    header("Location: ".BASE_URL); //balik sa login then sa login aalamain kung anung role at saang page landing dapat
    exit();
}
$page_title ="ADD USER";

$error = false;
$response_msg ="";
$title_form = "Add User";
$action_form = "save";

$get_id = isset($_POST['get_id']) ? $_POST['get_id'] :'';

$input =array();
$input['id_no'] = "";
$input['lastname'] = "";
$input['firstname'] = "";
$input['user_role'] = "";


if (isset($_POST['save']) AND $_POST['save']=="save"){
	$required_field = array("get_id","id_no","firstname","lastname","user_role","email");
    foreach ($required_field as $key) {
        if('get_id' == $key ){
            continue;
        }
         if(isset($_POST[$key])){
			$_POST[$key] = trim($_POST[$key]);
            if($_POST[$key] === ""){
				$error =  true;
				break;
		    }
        }else{
			$error = true;
			break;
		}
    }

    if($error){
        $session_class->setValue('error',"Input Invalid!");
        $response_msg ="Input Invalid!<br>";
    }else{
		$username = $input['id_no'] = $_POST['id_no'];
		$firstname = $input['firstname'] = $_POST['firstname'];
		$lastname = $input['lastname'] = $_POST['lastname'];
		$userrole = $input['user_role']  = $_POST['user_role'];
		$email = $input['email'] = $_POST['email'];

		/*$password = $_POST['password'];*/
		if(!in_array($userrole, array(1,2,3))){
			$error =true;
			$session_class->setValue('error',"User Role Invalid!");
			$response_msg ="User Role Invalid<br>";
		}

		$query1 = call_mysql_query("SELECT Username FROM users WHERE username = '".escape($db_connect,$username)."'");
		$count1 = call_mysql_num_rows($query1);
		if ($count1 > 0){
			$error =true;
			$session_class->setValue('error',"User ID Already Exist!");
			$msg ="Already Exist<br>";
		}

		$query = call_mysql_query("SELECT username,firstname,lastname FROM users WHERE username = '".escape($db_connect,$username)."' AND lastname = '".escape($db_connect,$lastname)."' AND firstname = '".escape($db_connect,$firstname)."'");
		$count = call_mysql_num_rows($query);
		if ($count > 0){
			$error =true;
			$session_class->setValue('error',"User Name and ID  Already Exist!");
			$msg ="Already Exist<br>";
		}

		

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$error = true;
			$session_class->setValue('error',"Email Invalid Format!");
			$msg = "Email Invalid Format";
		}
		$query_email = call_mysql_query("SELECT username FROM users WHERE email_address = '".$email."'");
		$count_email = call_mysql_num_rows($query_email);
		if($count_email > 0 ){
			$error = true;
			$session_class->setValue('error',"Email Already Exist!");
			$msg = "Email Already Exist!";
		}	
    }
    if($error!=true){
            $password = set_password($username);
            $nusername = escape($db_connect,$username);
            $firstname = escape($db_connect,$firstname);
            $lastname = escape($db_connect,$lastname);
            $userrole =escape($db_connect,$userrole);
            $email = escape($db_connect,$email);

            if(call_mysql_query("INSERT INTO users (username,password,firstname,lastname,id_no,user_role,email_address) values('".$nusername."','".$password."','".$firstname."','".$lastname."','".$nusername."','".$userrole."','".$email."')")){
				$last_id = mysqli_insert_id($db_connect);
				$log = json_encode(array('USER_ID'=>$last_id,'USERNAME'=>$nusername,'FIRST_NAME'=>$firstname,'LAST_NAME'=>$lastname,'USER_ROLE'=>$userrole,'EMAIL'=>$email));
                activity_log_new("Add User ".$username." Details::".$log);
                $response_msg ="Successfully Saved!";
                $session_class->setValue('success',"Successfully Saved!");
                header("Location: admin_user.php");
                exit();
            }
    }

}else if (isset($_POST['save']) AND $_POST['save']=="update" AND  is_digit($get_id)){ //update

	$required_field = array("get_id","id_no","firstname","lastname","user_role","email");
    foreach ($required_field as $key) {
         if(isset($_POST[$key])){
			$_POST[$key] = trim($_POST[$key]);
            if($_POST[$key] === ""){
				$error =  true;
				break;
		    }
        }else{
			$error = true;
			break;
		}
    }

    if($error){
        $response_msg ="Input Invalid!<br>";
    }else{
		$id_no = $_POST['id_no'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$userrole = $_POST['user_role'];
		$email = $_POST['email'];

		/*$password = $_POST['password'];*/
		if(!in_array($userrole, array(1,2,3))){
			$error =true;
			$response_msg ="User Role Invalid<br>";
		}


		$query = call_mysql_query("SELECT username,id_no FROM users WHERE  id_no = '".$id_no."' AND user_id != '".$get_id."'");
		$count = call_mysql_num_rows($query);
		if ($count > 0){
			$error =true;
			$response_msg ="Already Exist<br>";
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$error = true;
			$response_msg = "Email Invalid Format";
		}
		$query_email = call_mysql_query("SELECT username FROM users WHERE email_address = '".$email."' AND user_id != '".$get_id."'" );
		$count_email = call_mysql_num_rows($query_email);
		if($count_email > 0 ){
			$error = true;
			$response_msg = "Email Already Exist!";
		}
    }
    if($error!=true){

            $nid_no = escape($db_connect,$id_no);
            $firstname = escape($db_connect,$firstname);
            $lastname = escape($db_connect,$lastname);
            $userrole =escape($db_connect,$userrole);
            $email = escape($db_connect,$email);

			$old_data = "{}";
			$query_user = call_mysql_query("SELECT * FROM users WHERE user_id = '".$get_id."'" );
			$number = call_mysql_num_rows($query_user);
			if($number > 0 ){
				$data = mysqli_fetch_assoc($query_user);
				$old_data = array('USER_ID'=>$get_id,'USER_NO'=>$data['id_no'],'FIRST_NAME'=>$data['firstname'],'LAST_NAME'=>$data['lastname'],'USER_ROLE'=>$data['user_role'],'EMAIL'=>$data['email_address']);
			}

            if(call_mysql_query("UPDATE users SET id_no = '".$nid_no."',username = '".$nid_no."', firstname = '".$firstname."',lastname = '".$lastname."', user_role = '".$userrole."', email_address = '".$email."' WHERE user_id = '".$get_id."'")){
				if($num = call_mysql_affected_rows()){
					
					$to_log = array('USER_ID'=>$get_id,'USER_NO'=>$nid_no,'FIRST_NAME'=>$firstname,'LAST_NAME'=>$lastname,'USER_ROLE'=>$userrole,'EMAIL'=>$email);
					$change_array  = get_array_changes($old_data,$to_log);
					activity_log_new("Update User ".$id_no." USER_ID:".$get_id." - FROM Details ".json_encode($change_array['old_data'])." TO ".json_encode($change_array['new_data']));
					$response_msg ="Successfully Saved!";
					$session_class->setValue('success',"Successfully Saved!");
					header("Location: admin_user.php");
					exit();
				}
            }
    }

}


?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
    include DOMAIN_PATH."/app/global/meta_data.php";
    include DOMAIN_PATH."/app/global/include_top.php";

?>

</head>

<body data-layout="detached">
    <!-- HEADER -->
  <?php include DOMAIN_PATH."/app/global/top_bar.php"; ?>     <!--topbar -->
    <div class="container-fluid active">
        <div class="wrapper in">
            <!-- BEGIN CONTENT -->
            <!-- SIDEBAR -->
            <?php include DOMAIN_PATH."/app/global/sidebar.php"; ?>
            <!--END SIDEBAR-->
            <!-- PAGE CONTAINER-->
            <div class="content-page">
                <div class="content">
                    <!-- BEGIN PlACE PAGE CONTENT HERE -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-3">ADD USER</h4>
                                        <div class="table-responsive-sm mt-4">
                                        <div class="row ">
                                            <div class="col-xl-4">
                                                <div class="card">
                                                    <div class="card-body">
                                                       <?php include ('add_user.php'); ?>
                                                                
                                                    </div> <!-- end card body-->
                                                </div> <!-- end card -->
                                            </div>
                                        <div class="col-xl-8">
                                            <div class="card">
                                                <div class="card-body">
                                                       <h4 class="mb-3 header-title">USER LIST</h4>
                                                        <div class="m-2">
														<a href="#" id="add_new"  class="btn btn-outline-dark btn-rounded btn-sm ml-1" > <i class="fas fa-plus" ></i> Add</a>
														<a href="#" id="delete_sel_btn"  class="btn btn-outline-dark btn-rounded btn-sm ml-1" > <i class="fas fa-trash" ></i> Delete</a>
														<a href="import_user.php"  class="btn btn-outline-primary btn-rounded alignToTitle"><i class=""></i>Bulk Add/Update User</a>
														</div>
                                                       <div id="example-table"></div>
                                                         <button id="download-csv">Download CSV</button>
                                                        <button id="download-json">Download JSON</button>
                                                        <button id="download-xlsx">Download XLSX</button>
                                                        <button id="print-table">Print</button>
                                                </div>
											</div>
                                        </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>

                            </div> <!-- end col-->
                        </div>



                    <!-- END PLACE PAGE CONTENT HERE -->
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
    </div>
    <!-- all the js files -->
    <!-- bundle -->
<?php  include FOOTER_PATH; ?>
</body>
<?php include DOMAIN_PATH."/app/global/include_bottom.php"; ?>
<script>
(function(){
var total_record =0;
var global_id = 0;
var global_action ="save";
var collection_select = [];

function user_role(cell,formatterParams,onRendered){
        if(cell.getValue() == 1){
             return "Admin"
        }else{
            return "Registrar"
        }
    }
	
function record_details(values, data, calcParams) { 
	if (values && values.length) {
       
	
      return values.length + ' of '+total_record;
	}
 }
var table = new Tabulator("#example-table", {
    ajaxSorting:true,  
    ajaxFiltering:true,
    height:"500px",
    tooltips:true,
    printAsHtml:true,
    headerFilterPlaceholder:"",
     layout:"fitDataFill",
    placeholder:"No Data Found",
    movableColumns:true,
    selectable:true, 
    ajaxURL:"<?php echo BASE_URL;?>app/admin_user_table.php", 
    ajaxProgressiveLoad:"scroll",
    ajaxProgressiveLoadScrollMargin:1,
    printConfig:{
        columnGroups:false, 
        rowGroups:false,
    },
    ajaxLoader: true,
    ajaxLoaderLoading: 'Fetching data from Database..',
    selectableRollingSelection:false,
    paginationSize:<?php echo QUERY_LIMIT; ?>, 

    columns:[
        {formatter:"rowSelection",width:50, hozAlign:"center", headerSort:false,download:false,print:false, cellClick:function(e, cell){
            cell.getRow().toggleSelect();
        }},

        {title:"Name", field:"name",formatter:"textarea",bottomCalc:record_details, titlePrint:"Name", sorter:"string",headerFilter:"input",headerFilterLiveFilter: false},
        {title:"Username", field:"username", titlePrint:"ID Number", sorter:"string",headerFilter:"input",headerFilterLiveFilter: false}, 
        {title:"User Type", field:"user_role", titlePrint:"User Type", sorter:"string",headerFilter:"select",headerFilterParams:{0:"",1:"Admin",2:"Registrar"},formatter:user_role}, 
		{title:"Email Address", field:"email_address", titlePrint:"Email Address", sorter:"string",headerFilter:"input",headerFilterLiveFilter: false},
         {formatter:buttonFormatter, width:100, headerSort: false,headerFilter: false,download:false,print:false,hozAlign:"center",cellClick:function(e, cell){
             cell.getRow().toggleSelect();
        }},
		{formatter:buttonReset, width:200, headerSort: false,headerFilter: false,download:false,print:false,hozAlign:"center",cellClick:function(e, cell){
			cell.getRow().toggleSelect();
        }}, 
    ],ajaxResponse:function(url, params, response){ 
		if(response.total_record){
			total_record = response.total_record;
		}	
        return response; 
    },renderComplete:function(){
        var table =this;
        this.selectRow(collection_select);  
    },
    rowSelected:function(row){
        if(collection_select.indexOf(row.getData().id) === -1){
			collection_select.push(row.getData().id);
		}
    },
    rowDeselected:function(row){
        if(collection_select.indexOf(row.getData().id) !== -1){
            collection_select.splice(collection_select.indexOf(row.getData().id), 1);
        }
    },
	ajaxRequesting: function (url, params) {
		if(typeof this.modules.ajax.showLoader() != "undefined" ){
			this.modules.ajax.showLoader();
		}
	},
});

var add_new  = document.getElementById('add_new');
addListener(add_new,"click", function(){
var username = document.querySelector('input[name=id_no]');
	var firstname = document.querySelector('input[name=firstname]');
	var lastname = document.querySelector('input[name=lastname]');
	var user_role = document.querySelector('select[name=user_role]');
	var email = document.querySelector('input[name=email]');
	var get_id = document.querySelector('#get_id');
	if(username){
		username.value ="";
	}
	if(user_role){
		user_role.value = "";
	}
	if(firstname){
		firstname.value = "";
	}
	if(lastname){
		lastname.value = "";
	}
	if(email){
		email.value= "";
	}
	if(get_id){
		get_id.value = "";
		global_id = 0;
	}
	var title = document.querySelector('.header-title');
	if(title){
		title.innerHTML = "ADD USER";
	}
	var save = document.querySelector('button[name=save]');
	if(save){
		save.value = "save";
		save.innerHTML ="Add New User";
		global_action ="save";
	}
});


function buttonReset(cell,formatterParams){
    var cellEl = cell.getElement(); //get cell DOM element
	var linkBut = document.createElement("span");
	var id = cell.getData().id; 
	linkBut.innerHTML = "<a href='#' class='btn btn-outline-dark btn-rounded btn-sm ml-1' >RESET PASSWORD</a>";
	addListener(linkBut,"click", function(){
		Swal.fire({
		  title: 'Are you sure to Reset Password?',
		  text: "You won't be able to revert this!",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, reset it!'
		}).then((result) => {
		  if (result.isConfirmed) {
			$.post("<?php echo BASE_URL;?>app/ajax_reset_password.php", { action : 'RESET_PASSWORD',user_id: cell.getData().id,type:"ADMINS"}, 
				function(returnedData){
					var obj = returnedData;// JSON.parse(returnedData);
					if(obj.result == "success"){
						Swal.fire({
						  title: '<strong>New Password</strong>',
						  padding: '3em',
						   icon: 'info',
						  html:'<b>'+obj.msg+'</b>',
						  showCancelButton: false,
						  allowOutsideClick: false,
						  allowEscapeKey: false,
						  confirmButtonText:'<i class="fas fa-clipboard"></i> Copy',
						  preConfirm: (login) => {
							copyToClipboard(obj.msg);
							success_notif('Copy to Clipboard');
							return false;
						  },
						  allowOutsideClick: () => !Swal.isLoading()
						})
					}else{
						warning_notif("Error: "+obj.errors);                    
					}
			}).fail(function(){
				  warning_notif("Error Encounter");
			});	
		  }
		})
	});
	
	return cellEl.appendChild(linkBut);
}

function copyToClipboard(value) {
  const str = value;
  const el = document.createElement('textarea')
  el.value = str
  el.setAttribute('readonly', '')
  el.style.position = 'absolute'
  el.style.left = '-9999px'
  document.body.appendChild(el)
  el.select()
  document.execCommand('copy')
  document.body.removeChild(el)
}


function buttonFormatter(cell,formatterParams){
    var cellEl = cell.getElement(); //get cell DOM element
	var linkBut = document.createElement("span");
	var id = cell.getData().id; 
	linkBut.innerHTML = "<a href='#' class='btn btn-outline-dark btn-rounded btn-sm ml-1' ><i class='fas fa-pencil-alt' title='update'></i> EDIT</a>";
	addListener(linkBut,"click", function(){
		var username = document.querySelector('input[name=id_no]');
		var firstname = document.querySelector('input[name=firstname]');
		var lastname = document.querySelector('input[name=lastname]');
		var user_role = document.querySelector('select[name=user_role]');
		var email = document.querySelector('input[name=email]');
		var get_id = document.querySelector('#get_id');
		if(username){
			username.value = cell.getData().username;
		}
		if(user_role){
			user_role.value = cell.getData().user_role;
		}
		if(firstname){
			firstname.value = cell.getData().firstname;
		}
		if(lastname){
			lastname.value = cell.getData().lastname;
		}
		if(email){
			email.value=cell.getData().email_address;
		}
		if(get_id){
			get_id.value = cell.getData().id;
			global_id = cell.getData().id;
		}
		var title = document.querySelector('.header-title');
		if(title){
			title.innerHTML = "EDIT USER INFO";
		}
		var save = document.querySelector('button[name=save]');
		if(save){
			save.value = "update";
			save.innerHTML ="Update";
			global_action ="update";
		}

	});
	return cellEl.appendChild(linkBut);
}


var form =  document.getElementById('form_submit');
addListener(form, "submit", function(e) {
	var username = document.querySelector('input[name=id_no]');
	var firstname = document.querySelector('input[name=firstname]');
	var lastname = document.querySelector('input[name=lastname]');
	var user_role = document.querySelector('select[name=user_role]');
	var email = document.querySelector('input[name=email]');
	var get_id = document.querySelector('#get_id');
	var save = document.querySelector('button[name=save]');
	var error=false;
	if(!(username && firstname && lastname && user_role && email && get_id && save)){
		error =true;
	}
	if(error){
		try {
			warning_notif('Error: Data was Altered!');
			e.preventDefault(); 
		} catch(ex) {
			console.log('An error occurred in submitting form');
		}
	}

	if(username.value.trim()==""){ error= 'ID Number is required!'; username.focus();}
	else if(firstname.value.trim()==""){ error= 'First Name is required!'; firstname.focus();}
	else if(lastname.value.trim()==""){ error= 'Last Name is required!'; lastname.focus();}
	else if(ValidateEmail(email.value.trim())==false){ error= 'Email must be valid!'; email.focus();}
	else if(isNaN(user_role.value) || user_role.value.trim()==""){ error= 'Select Role is required!';  } else{ error = false; };
	

	if(global_action == "save"){
		global_id =0;
	}else if(global_id != 0 && global_action == "update"){
		//none
	}else{
		try {
			warning_notif('Error:Data was Altered!')
			e.preventDefault(); 
		} catch(ex) {
			console.log('An error occurred in submitting form');
		}
	}
	
	if(error !=false){
		if(error==true){
			warning_notif('Error: Data was Altered!');
		}else{
			warning_notif('Error: '+ error);
		}
		try {
			e.preventDefault(); 
		} catch(ex) {
			console.log('An error occurred in submitting form');
		}
		
	}else if(get_id && save){
		get_id.value = global_id;
		save.value = global_action;
	}
});



addListener(document.getElementById('delete_sel_btn'), "click", function() {
	if(collection_select.length == 0){
		warning_notif('Please select Item in the table!');
	}else{
		Swal.fire({
		  title: 'Are you sure?',
		  text: "You won't be able to revert this!",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		  if (result.isConfirmed) {
				
				var json_id = JSON.stringify(collection_select);
				$.post("<?php echo BASE_URL;?>app/ajax_delete_user.php", { action : 'DELETE_USER',user_ids:json_id}, 
					function(returnedData){
						var obj = returnedData;// JSON.parse(returnedData);
						if(obj.result == "success"){
								table.deleteRow(collection_select);
								var len = collection_select.length;
								total_record = total_record - len;
								collection_select=[];
								table.recalc();
								Swal.fire(
								  'Deleted!',
								  'Data has been deleted.',
								  'success'
								);
						}else{
							warning_notif("Error: "+obj.errors);                    
						}
				}).fail(function(){
					  warning_notif("Error Encounter");
				});
		  }
		})
	}
});

addListener(document.getElementById('download-csv'), "click", function() {
        table.download("csv", "users_"+getFormattedTime()+".csv");
});
addListener(document.getElementById('download-json'), "click", function() {
        table.download("json", "users_"+getFormattedTime()+".json");
});
addListener(document.getElementById('download-xlsx'), "click", function() {
        table.download("xlsx", "users_"+getFormattedTime()+".xlsx");
});
addListener(document.getElementById('print-table'), "click", function() {
         table.print(false, true);

});



function add_overlay(){
	var body = document.querySelector('body');	
	var overlay = document.querySelector('.overlay');	
	if(overlay){
	}else{
		var div = document.createElement('div');
		div.className = "overlay";
		body.appendChild(div);
	}
}
add_overlay();
$(document).on({
	ajaxStart: function(){
		addClass(document.querySelector('body'),'loading');
		isPaused = true;
	},
	ajaxStop: function(){ 
		removeClass(document.querySelector('body'),"loading");
		isPaused = false;
	}    
});

})();
<?php 
    $msg = $session_class->getValue('success');
    if(isset($msg) AND $msg !=""){
          echo "success_notif('".$msg."');";
          $session_class->dropValue('success');
    }
    $msg = $session_class->getValue('error');
    if(isset($msg) AND $msg !=""){
          echo "warning_notif('".$msg."');";
          $session_class->dropValue('error');
    }

?>
</script>
</html>

