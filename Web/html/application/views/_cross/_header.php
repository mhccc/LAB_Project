<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Health One</title>
	<link rel="stylesheet" href="/assets/css/reset.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="/assets/css/common.css">
	<script src="/assets/js/jquery-3.3.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
<div class="wraper" id="wraper">
	<div id="full_menu_box" class="full_menu_box">
		<div class="inbox">
			<ul><?php if($my['uid'] && $my['name']) :?>
				<li class="title"><?=$my['name']?>님 <span style="float: right;"><a href="/member/logout" style="color:#FFF;">로그아웃</a></span></li>
				<li<?php if(uri_string() == 'member/info'):?> class="active"<?php endif;?> onclick="location.href='/member/info';">마이페이지</a></li>
				<?php else: ?>
				<li class="title" onclick="location.href='/member/login';">로그인</li>
				<li class="title" onclick="location.href='/member/join';">회원가입</li>
				<?php endif; ?>
				<?php foreach ($page_fullmenu as $key => $val):?>
				<?php if($val[1] != 'hide'):?>
				<li data-role="full_menu_1" data-index="<?=$key?>"<?=($key == $group_num?' class="active"':'')?>><?=$val[0]?></li>
				<li data-role="full_menu_2" data-index="<?=$key?>" class="child_zone<?=($key == $group_num?' active':'')?>">
					<ul>
						<?php foreach ($val[2] as $key2 => $val2){?>
						<li<?=(($key == $group_num) && ($key2 == $menu_num)?' class="active"':'')?>><a href="<?=$val2[0]?>"><?=$val2[1]?></a></li>
						<?php } ?>
					</ul>
				</li>
				<?php endif;?>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
	<header id="header">
		<div class="container">
			<div class="row">
				<div class="col-12 col-md-12">
					<div class="logo fl"><a href="/">Health One</a></div>
					<div class="topnav fl">
						<ul class="text-center col-md-remove">
							<?php foreach ($page_fullmenu as $key => $val):?>
								<?php if($val[1] != 'hide'):?>
								<li><a href="<?=$val[2][0][0]?>"><?=$val[0]?></a>
									<div class="subbox">
										<ul>
											<?php foreach ($val[2] as $key2 => $val2){?>
											<li><a href="<?=$val2[0]?>"><?=$val2[1]?></a></li>
											<?php } ?>
										</ul>
									</div>
								</li>
								<?php endif;?>
							<?php endforeach; ?>
						</ul>
					</div>
					<span class="fullbtn fr hide col-md-show btn_fullmenu" onclick="fullmenu_nav();">
						<i class="fa fa-align-justify text-white btn_fullmenu"></i>
					</span>
					<?php if(isset($is_logged) && $is_logged): ?>
					<a href="/member/logout">
						<span class="fullbtn fr">
							<i class="fa fa-unlock text-white"></i>
						</span>
					</a>
					<a href="/member/info">
						<span class="fullbtn fr">
							<i class="fa fa-user text-white"></i>
						</span>
					</a>
					<?php else: ?>
					<a href="/member/login">
						<span class="fullbtn fr">
							<i class="fa fa-user text-white"></i>
						</span>
					</a>
					<?php endif; ?>
					<span class="fullbtn fr">
						<i class="fa fa-search text-white"></i>
					</span>
				</div>
			</div>
		</div>
	</header>
	<!-- 고객센터 -->
	<?php if(isset($fullpage_mode) && !$fullpage_mode):?>
	<div class="page_title">
		<div class="zone">
			<div class="container">
				<?=$page_menu['title']?>
			</div>
		</div>
	</div>
	<div class="navigations">
		<div class="container">
			<div class="row text-right">
				<div class="col-md-12">
					<a href="#">Home</a> > <a href="#"><?=$page_menu['title']?></a><?php if(isset($page_menu['subtitle'])):?> > <a href="#"><?=$page_menu['subtitle']?><?php endif;?></a>
				</div>
			</div>
		</div>
	</div>
	<?php endif;?>
	<div class="content container">