<?php
/** 
==================================================================
 File name   : curriculum_action.php
 Version     : 1.0
 Begin       : 2022-06-04
 Last Update : 2022-06-04
 Author      : Mike Jerrson Galindez
 Description : For Research CRUD
 =================================================================
**/
require '../../config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require ISLOGIN;


if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')){ 
	include HTTP_401;
	exit();
}

if(isset($_POST['action'])){
    if($_POST['action']=="save")
    {
        // edit this to accomodate the submission of research
        $fiscalYear = escape($db_connect,$_POST['fiscalYear']);
        $programId = escape($db_connect,$_POST['program_id']);
        $title = escape($db_connect,$_POST['title']);
        $query = "INSERT INTO curriculums (curriculum_title,program_id,fiscal_year) VALUES (?, ?, ?)";
        $stmt = $db_connect->prepare($query);
        $stmt->bind_param('sis', $title, $programId, $fiscalYear);
        if($stmt->execute())
        {
            echo "Procedure Added";
        }
        else
        {
            echo "Adding procedure failed!";
        }
        db_close();
    }
    else if($_POST['action']=="edit")
    {
        $curriculum_id = escape($db_connect, $_POST['curriculum_id']);
        $subjects = ($_POST['subjects']);
        $header = $_POST['header'];
        $query = "UPDATE curriculums SET subjects=?, header=? WHERE curriculum_id=?";
        $stmt= $db_connect->prepare($query);
        $stmt->bind_param("ssi", $subjects, $header, $curriculum_id);
        if($stmt->execute())
        {
            echo "Changes Saved";
        }
        else
        {
            echo "Adding failed!";
        }
        db_close();
        
    }
}