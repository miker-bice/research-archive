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
			<a href="splash_admin.php" id="splash_admin" class="side-nav-link " aria-expanded="false">
				<i class="fas fa-bolt"></i>
				<span>Bulletin Board</span>
			</a>
		</li> 
		<li class="side-nav-item">
			<a href="calendar_events.php" class="side-nav-link " aria-expanded="false">
				<i class="fas fa-calendar"></i>
				<span>Calendar of Events</span>
			</a>
		</li>
		<li class="side-nav-item">
			<a href="class_list.php" id="class_list_link" class="side-nav-link " aria-expanded="false">
				<i class="fas fa-list"></i>
				<span>Class List</span>
			</a>
		</li>
		<li class="side-nav-item">
			<a href="study_load.php" id="study_load_link" class="side-nav-link " aria-expanded="false">
				<i class="fas fa-file-alt"></i>
				<span>Student Load</span>
			</a>
		</li>

		<li class="side-nav-item">
			<a href="program.php" class="side-nav-link " aria-expanded="false">
				<i class="fas fa-building"></i>
				<span>Program</span>
			</a>
		</li>
		<li class="side-nav-item">
			<a href="#" class="side-nav-link" aria-expanded="false">
				<i class="fas fa-database"></i>
				<span>Registrar</span>
				<span class="menu-arrow"></span>
			</a>
			<ul class="side-nav-second-level collapse" aria-expanded="false" >
				<li class="" id="regs_student_link">
					<a href="students.php" id="sub_regs_student_link">Students</a>
				</li>
				<li class="" id="regs_course_link">
					<a href="course.php" id="sub_regs_course_link">Courses</a>
				</li>
				<li class="" id="regs_section_link">
					<a href="section.php" id="sub_regs_section_link">Section</a>
				</li>
				<li class="" id="regs_enroll_link">
					<a href="enroll.php" id="sub_regs_enroll_link">Enrollment End Date</a>
				</li>
				<li class="" id="regs_grade_display">
					<a href="grade_display.php" id="sub_regs_grade_display">Viewing Grades Date</a>
				</li>
				<li class="" >
					<a href="fy.php">Fiscal Year</a>
				</li>
				<li class="" id="">
					<a href="grade_submission.php">Grade Submission</a>
				</li>
			</ul>
		</li>	
	</ul>
</div>