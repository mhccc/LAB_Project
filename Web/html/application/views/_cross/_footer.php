	</div>
	<footer id="footer">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="logo fl"><a href="#">Health One</a></div>
					<div class="fl">
개인정보보호처리방침 | (우)27478 충북 충주시 충원대로 268 <br>
건국대학교 GLOCAL(글로컬)캠퍼스 / TEL. 000-000-0000<br>
COPYRIGHT 2018 HEALTH ONE CENTER. ALL RIGHT RESERVED.<br>
					</div>
				</div>
			</div>
		</div>
	</footer>
</div>
<script>
	function fullmenu_nav(){
		var obj = $('#full_menu_box');
		var active = obj.hasClass('active');
		var wraper = $('#wraper');
		if(!active){
			wraper.addClass('no-scroll');
			obj.addClass('active');
		}else{
			obj.removeClass('active');
			wraper.removeClass('no-scroll');
		}
	}

	$(function(){
		$('[data-role="full_menu_1"][data-index]').on('click', function(){
			var menu_index = $(this).data('index');
			var subbox = $('[data-role="full_menu_1"][data-index]');
			var subbox = $('[data-role="full_menu_1"]').removeClass('active');
			$('[data-role="full_menu_2"]').slideUp('slow');
			var subbox = $('[data-role="full_menu_1"][data-index="' + menu_index + '"]').addClass('active');
			$('[data-role="full_menu_2"][data-index="' + menu_index + '"]').slideDown('slow');
		});
	});

	// 메뉴 배경영역 클릭시 닫기
	$(document).mouseup(function (e){
		var container = $("#full_menu_box");
		if(container.has(e.target).length == 0) container.removeClass('active');

	});
</script>
</body>
</html>