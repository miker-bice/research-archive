<?php
require '../config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require VALIDATOR_PATH; // library for form validation


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
<body class="bg-white">
    <!-- insert here the topbar -->
    <?php  include TOPBAR; ?>

    <!-- insert here the navbar -->
    <?php  include MAIN_NAVBAR; ?>

    <!-- insert here the main content of the page -->
    <div class="main-content container-fluid">
        <h1>this is the main page</h1>
    </div>
    
    <!-- insert here the footer -->
    <?php  include FOOTER_PATH; ?>
    
</body>
<?php include DOMAIN_PATH."/app/global/include_bottom.php"; ?>
</html>