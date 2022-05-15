            <!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu left-side-menu-detached active">
	<div class="leftbar-user active">
		<a href="javascript: void(0);">
			 <img src="<?php echo $global_profile_pic;?>" alt="user-image" height="42" class="rounded-circle shadow-sm">
				<span class="leftbar-user-name"><?php echo $user_name; ?></span>
		</a>
	</div>

	<!--- Sidemenu -->

	<ul class="metismenu side-nav side-nav-light in">
		<li class="side-nav-title side-nav-item">Navigation</li>
		 <li class="side-nav-item active">
			<a href="index.php" id="dashboard_link" class="side-nav-link " aria-expanded="false">
				<i class="fas fa-chart-area"></i>
				<span>Dashboard</span>
			</a>
		</li> 

		<li class="side-nav-item">
			<a href="admin_user.php" class="side-nav-link " aria-expanded="false">
				<i class="fas fa-user"></i>
				<span>Admin User</span>
			</a>
		</li>
		<li class="side-nav-item">
			<a href="javascript: void(0);" class="side-nav-link" aria-expanded="false">
				<i class="fas fa-history"></i>
				<span>System Logs </span>
				<span class="menu-arrow"></span>
			</a>
			<ul class="side-nav-second-level collapse" aria-expanded="false" >
				<li class="" id="admin_activity">
					<a href="activity_log.php" id="sub_admin_activity"> Admin - Activity Logs</a>
				</li>
				<li class="" id="admin_log">
					<a href="user_log.php" id="sub_admin_log">Admin - User Logs</a>
				</li>				
			</ul>
		</li>
		
	</ul>
</div>