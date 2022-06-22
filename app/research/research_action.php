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

require_once DOMAIN_PATH."/call_func/UploadHandler.php";

function get_request_method() {
    global $HTTP_RAW_POST_DATA;

    if(isset($HTTP_RAW_POST_DATA)) {
        parse_str($HTTP_RAW_POST_DATA, $_POST);
    }

    if (isset($_POST["_method"]) && $_POST["_method"] != null) {
        return $_POST["_method"];
    }

    return $_SERVER["REQUEST_METHOD"];
}

// if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')){ 
// 	include HTTP_401;
// 	exit();
// }

$method = get_request_method();
if ($method == "POST") {

    if(isset($_POST['action']) AND $_POST['action']== "save"){
        $uploader = new UploadHandler();

            // Specify the list of valid extensions, ex. array("jpeg", "xml", "bmp")
        $uploader->allowedExtensions = array("pdf"); // all files types allowed by default

        // Specify max file size in bytes.
        $uploader->sizeLimit = null;

        // Specify the input name set in the javascript.
        $uploader->inputName = "qqfile"; // matches Fine Uploader's default inputName value by default

        // If you want to use the chunking/resume feature, specify the folder to temporarily save parts.
        $uploader->chunksFolder = join(DIRECTORY_SEPARATOR,array(DOMAIN_PATH,'upload','chunks'));


        if (isset($_GET["done"])) {
            $result = $uploader->combineChunks(join(DIRECTORY_SEPARATOR,array(DOMAIN_PATH,'upload','files')));
            $result["uploadName"] = $uploader->getName();
        }
    
        else {
            // Call handleUpload() with the name of the folder, relative to PHP's getcwd()
            $result = $uploader->handleUpload(join(DIRECTORY_SEPARATOR,array(DOMAIN_PATH,'upload','files')));
            // To return a name used for uploaded file you can use the following line.
            $result["uploadName"] = $uploader->getUploadName();
            $result['chunked']  = false;
        }


        // kung tapos na iupload , isave na sa db ang data
        if( (isset($result["success"]) AND isset($_GET['done']))   OR ($result['chunked']==false AND isset($result["success"])) AND $result["uploadName"] !=""){ // na finish na iupload  Bboth 
           
            $error = false;
            $researchTitle = isset($_POST['research-title']) ? trim($_POST['research-title']) : "";
            $researchYear = isset($_POST['research-year']) ? trim($_POST['research-year']) : "";
            $researchAbstract = isset($_POST['research-abstract']) ? trim($_POST['research-abstract']) : "";
            $researchAuthor = isset($_POST['research-authors']) ? trim($_POST['research-authors']) : "";
            //$researchFile = isset($_POST['research-file']) ? trim($_POST['research-file']) : "";

            // VALIDATION PER FIELD
            // gumawa ng ibang error message para sa ibang fields
            if(empty(trim($_POST['research-title']))){
				$error =true;
				$response_msg['error']="Title is required!";
				$response_msg['msg'] ="";
				$response_msg['result'] ="error";		

                
			}

            if($error == true){
                $response_msg['error'] = $response_msg['error'];
                $delete = $uploader->handleDelete(join(DIRECTORY_SEPARATOR,array(DOMAIN_PATH,'upload','files')));
                echo output($response_msg);
                exit();
              }
            
            $newname = $uploader->getTargetFilePath(join(DIRECTORY_SEPARATOR,array('upload','files')));
            $researchTitle = escape($db_connect,$researchTitle);
            $researchYear = escape($db_connect,$researchYear);
            $researchAbstract = escape($db_connect,$researchAbstract);
            $researchAuthor = escape($db_connect,$researchAuthor);
            $researchFile = escape($db_connect,$newname);
            // $fiscalYear = escape($db_connect,$_POST['fiscalYear']);
            // $programId = escape($db_connect,$_POST['program_id']);
            // $title = escape($db_connect,$_POST['title']);





            //
            $query = "INSERT INTO research (title, date_year, abstract, author, file_path) VALUES ('".$researchTitle."', '".$researchYear."', '".$researchAbstract."', '".$researchAuthor."', '".$researchFile."')";
            //echo $query;
            if(call_mysql_query($query)){
				
			}else{
				$response_msg['error'] ='Unable to save in Database';
				$delete = $uploader->handleDelete(join(DIRECTORY_SEPARATOR,array(DOMAIN_PATH,'upload','files')));
				echo output($response_msg);
				exit();
				
			}


            // $stmt = $db_connect->prepare($query);
            // $stmt->bind_param('sssss', $researchTitle, $researchYear, $researchAbstract, $researchAuthor, $researchFile);
            // if($stmt->execute())
            // {
            //     echo "Procedure Added";
            // }
            // else
            // {
            //     echo "Adding procedure failed!";
            // }
            // db_close();

        }
        echo output($result);
    }










}// for delete file requests
else if ($method == "DELETE") {
   // $result = $uploader->handleDelete("files");
   // echo json_encode($result);
}
else {
    header("HTTP/1.0 405 Method Not Allowed");
}
