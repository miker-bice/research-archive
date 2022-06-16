<?php
require '../config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require VALIDATOR_PATH; // library for form validation
require ISLOGIN;// check kung nakalogin


$g_user_role = $session_class->getValue('role_id');
include "redirect.php";

$csrf = new CSRF($session_class); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        include DOMAIN_PATH."/app/global/meta_data.php";
        include DOMAIN_PATH."/app/global/include_top.php";
    ?>

</head>
<body class="bg-white py-0">
    <!-- insert here the topbar -->
    <?php include DOMAIN_PATH."/app/global/top_bar.php"; ?>     <!--topbar -->

    <!-- insert here the navbar -->
    <?php  include MAIN_NAVBAR; ?>

    <!-- insert here the main content of the page -->
    <div class="main-content mt-3 container">
        <?php  include UPLOAD_ARCHIVE; ?>
    </div>
    
    <!-- insert here the footer -->
    <?php  include BOTTOM_BAR; ?>
    
</body>
<?php include DOMAIN_PATH."/app/global/include_bottom.php"; ?>
</html>

<script>
    // initialize summernote for ehader
    var div_header = document.getElementById('header_text');
    var div_header_editor = $(div_header).summernote({
        height: 200,
        dialogsFade: true,
        prettifyHtml: true,
        width: '100%',	
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['backcolor','forecolor']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert',['picture','link','video','hr','math']],
            ['table', ['table']],
            ['view', [ 'undo','redo','help']],
            ['height', ['height']]
        ]
    });	
    var header_text = $(div_header).summernote('code');
    $.post("url/to/process.php",{header:header_text,date:variable},function(){

    })
</script>