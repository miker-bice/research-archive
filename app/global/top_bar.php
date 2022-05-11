 <!-- Topbar Start -->
<?php
$badge_count = '';
?> 
<div class="navbar-custom topnav-navbar topnav-navbar-dark">
    <div class="container-fluid">

        <!-- LOGO -->
        <a href="#" class="topnav-logo" style="min-width: unset;">
            <span class="topnav-logo-lg">
                <img src="<?php echo BASE_URL;?>images/logo-light.png" alt="" height="50">
            </span>
            <span class="topnav-logo-sm">
                <img src="<?php echo BASE_URL;?>images/logo-light-sm.png" alt="" height="50">
            </span>
        </a>

        <ul class="list-unstyled topbar-right-menu float-right mb-0">

            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle nav-user arrow-none mr-0" data-toggle="dropdown" id="topbar-userdrop" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <span class="account-user-avatar">
                    <img src="<?php echo $global_profile_pic;?>" alt="user-image" class="rounded-circle">
					<?php echo '<span class="badge badge-notify-name">'.$badge_count.'</span>'; ?>
                </span>
                <span style="color: #fff;">
                    <span class="account-user-name"><?php  echo $g_user_name; ?></span>
                    <span class="account-position"><?php echo $g_user_role[0]; ?></span>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu profile-dropdown" aria-labelledby="topbar-userdrop">
            <!-- item-->
            <div class=" dropdown-header noti-title" style="display:none;">
                <h6 class="text-overflow m-0"></h6>
            </div>

            <!-- Account -->

			<a href="manage_profile_student.php" class="dropdown-item notify-item">
                <i class="fas fa-user-circle mr-1"></i>
                <span>My account</span>
            </a>
			<a href="notif.php" class="dropdown-item notify-item">
			<i class="fas fa-bell mr-1"></i>
            <span>Notification</span>
			<span class="badge badge-notify"></span>
            <!-- Logout-->
			</a>
			<a href="<?php echo BASE_URL;?>logout.php" class="dropdown-item notify-item">
            <i class="fas fa-sign-out-alt mr-1"></i>
            <span>Logout</span>
            </a>

        </div>
    </li>

</ul>
<a class="button-menu-mobile disable-btn">
    <div class="lines">
        <span></span>
        <span></span>
        <span></span>
    </div>
</a>
<div class="visit_website" >
	<!--
    <h4 style="color: #fff; float: left;font-family:inkfree;"> <span>e-GURO (Learning Management System)</span></h4>
	 <h6 style="font-family: Arial, sans-serif;color: #fff; float: right;"><span id="clock"><?php //echo date('D | F j, Y h:i:s A') ?></span></h6>
	-->
</div>


</div>
</div>
<!-- end Topbar -->