<?php 
if($get_id > 0)	{
?>
<a href="admin_user.php"></a>
<?php 
}
?>

<div id="profile_form_msg" class="alert alert-warning alert-dismissable" style="display: block;"> <?php //<!-- id='add_instructor_form_msg' - id ng msg div - change_this --> ?>
<span style="color: red">**identification no. is the default Username and Password</span>
</div>
<form id="form_submit" method="post">
<div class="form-group">
<label>Select Role</label>
<select class="form-control"  name ="user_role"  placeholder="User Role" required>
<option></option>
<?php

$user_role =array(1=>"Admin",2=>"Registrar",3=>"VPAA");
foreach($user_role as $id => $text) {
$selected ="";
if($id==$input['user_role']){
$selected ="selected";
}
echo "<option value='".$id."' ".$selected .">".$text."</option>";
}


?>
</select>
</div>
<div class="form-group">
<label>ID Number</label>
<input type="text" class="form-control" name="id_no" value="<?php echo $input['id_no'];?>" required>
</div>

<div class="form-group">
<label>First Name</label>
<input type="text" class="form-control" name="firstname" value="<?php echo $input['firstname'];?>" required>
</div>

<div class="form-group">
<label>Last Name</label>
<input type="text" class="form-control" name="lastname" value="<?php echo $input['lastname'];?>" required="">
</div>
<div class="form-group">
<label>Email Address</label>
<input type="email" class="form-control" name="email" value="<?php echo $input['email'];?>" required="">
</div>
<input type="hidden" value="" id="get_id" name="get_id">
<div class="row justify-content-center">
<button name="save" value ="<?php echo $action_form;?>"  class="btn btn-outline-primary btn-rounded btn-sm ml-1">Add New User</button>
</div>
</form>	