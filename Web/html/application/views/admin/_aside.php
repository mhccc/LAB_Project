	<!-- Left side column. contains the logo and sidebar -->
	<aside class="main-sidebar">
	   <!-- sidebar: style can be found in sidebar.less -->
	   <section class="sidebar">
	      <!-- Sidebar user panel (optional) -->
	      <div class="user-panel">
	         <div class="pull-left image">
	            <img src="/assets/admin_dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
	         </div>
	         <div class="pull-left info">
	            <p><?=$my['name']?></p>
	            <!-- Status -->
	            <a href="#"><i class="fa fa-circle text-success"></i> 온라인</a>
	         </div>
	      </div>
	      <!-- search form (Optional) -->
	      <form action="#" method="get" class="sidebar-form">
	         <div class="input-group">
	            <input type="text" name="q" class="form-control" placeholder="Search...">
	            <span class="input-group-btn">
	            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
	            </button>
	            </span>
	         </div>
	      </form>
	      <!-- /.search form -->
	      <!-- Sidebar Menu -->
	      <ul class="sidebar-menu" data-widget="tree">
	         <li class="header">HEADER</li>
	         <!-- Optionally, you can add icons to the links -->
	         <li data-menu1="1"><a href="/admin"><i class="fa fa-dashboard"></i> <span>대시보드</span></a></li>
	         <li class="treeview" data-menu1="2">
	            <a href="#"><i class="fa fa-wrench"></i> <span>시스템</span>
	            <span class="pull-right-container">
	            <i class="fa fa-angle-left pull-right"></i>
	            </span>
	            </a>
	            <ul class="treeview-menu">
	               <li data-menu2="1"><a href="#">환경설정</a></li>
	               <li data-menu2="2"><a href="#">사이트방문자</a></li>
	            </ul>
	         </li>
	         <li class="treeview" data-menu1="3">
	            <a href="/admin/member_list"><i class="fa fa-user"></i> <span>회원</span>
	            <span class="pull-right-container">
	            <i class="fa fa-angle-left pull-right"></i>
	            </span>
	            </a>
	            <ul class="treeview-menu">
	               <li data-menu2="1"><a href="/admin/member_list">회원목록</a></li>
	            </ul>
	         </li>
	         <li class="treeview" data-menu1="4">
	            <a href="/admin/member_list"><i class="fa fa-user"></i> <span>문진표</span>
	            <span class="pull-right-container">
	            <i class="fa fa-angle-left pull-right"></i>
	            </span>
	            </a>
	            <ul class="treeview-menu">
	               <li data-menu2="1"><a href="/admin/survey_list">설문목록</a></li>
	            </ul>
	         </li>
	         <li class="treeview" data-menu1="5">
	            <a href="/admin/member_list"><i class="fa fa-user"></i> <span>웹크롤러 봇</span>
	            <span class="pull-right-container">
	            <i class="fa fa-angle-left pull-right"></i>
	            </span>
	            </a>
	            <ul class="treeview-menu">
	               <li data-menu2="1"><a href="#">웹크롤러 설정</a></li>
	               <li data-menu2="2"><a href="/admin/crawler_keyset">조건별 키워드셋</a></li>
	            </ul>
	         </li>
	         <li class="treeview" data-menu1="6">
	            <a href="/admin/member_list"><i class="fa fa-user"></i> <span>고객센터</span>
	            <span class="pull-right-container">
	            <i class="fa fa-angle-left pull-right"></i>
	            </span>
	            </a>
	            <ul class="treeview-menu">
	               <li data-menu2="1"><a href="/admin/cs_notice">공지사항</a></li>
	               <li data-menu2="2"><a href="/admin/cs_faq">자주묻는 질문</a></li>
	            </ul>
	         </li>
	      </ul>
	      <!-- /.sidebar-menu -->
	   </section>
	   <!-- /.sidebar -->
	</aside>

	<script>
		$(function(){
			<?php if(isset($menu1)):?>
			$('li[data-menu1="<?=$menu1?>"]').addClass('active');
			<?php endif; if(isset($menu2)):?>
			$('li[data-menu2="<?=$menu2?>"]').addClass('active');
			<?php endif; ?>
		});
	</script>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	   <!-- Content Header (Page header) -->
	   <section class="content-header">
	      <h1>
	         <?=$nav_title?>
	         <small><?=$nav_subtitle?></small>
	      </h1>
	      <ol class="breadcrumb">
	         <li><i class="fa fa-dashboard"></i> <?=$top_menu?></li>
	         <?php if(isset($nav_title)):?><li class="active"><?=$nav_title?></li><?php endif; ?>
	      </ol>
	   </section>
	   <!-- Main content -->
	   <section class="content container-fluid">