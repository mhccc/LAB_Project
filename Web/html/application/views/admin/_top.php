	<!-- Main Header -->
	<header class="main-header">
	   <!-- Logo -->
	   <a href="/admin" class="logo">
	      <!-- mini logo for sidebar mini 50x50 pixels -->
	      <span class="logo-mini"><b>H</b>O</span>
	      <!-- logo for regular state and mobile devices -->
	      <span class="logo-lg"><b>Health</b> One</span>
	   </a>
	   <!-- Header Navbar -->
	   <nav class="navbar navbar-static-top" role="navigation">
	      <!-- Sidebar toggle button-->
	      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
	      <span class="sr-only">Toggle navigation</span>
	      </a>
	      <!-- Navbar Right Menu -->
	      <div class="navbar-custom-menu">
	         <ul class="nav navbar-nav">
	            <!-- User Account Menu -->
	            <li class="dropdown user user-menu">
	               <!-- Menu Toggle Button -->
	               <a href="#" class="dropdown-toggle" data-toggle="dropdown">
	                  <!-- The user image in the navbar-->
	                  <img src="/assets/admin_dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
	                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
	                  <span class="hidden-xs"><?=$my['name']?></span>
	               </a>
	               <ul class="dropdown-menu">
	                  <!-- The user image in the menu -->
	                  <li class="user-header">
	                     <img src="/assets/admin_dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
	                     <p>
	                        <?=$my['name']?>
	                        <small>관리자</small>
	                     </p>
	                  </li>
	                  <!-- Menu Footer-->
	                  <li class="user-footer">
	                     <div class="pull-left">
	                        <a href="/admin/member_edit/<?=$my['uid']?>" class="btn btn-default btn-flat">정보수정</a>
	                     </div>
	                     <div class="pull-right">
	                        <a href="/member/logout" class="btn btn-default btn-flat">로그아웃</a>
	                     </div>
	                  </li>
	               </ul>
	            </li>
	         </ul>
	      </div>
	   </nav>
	</header>