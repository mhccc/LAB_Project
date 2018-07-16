<style>
	ul.link_box {}
	ul.link_box li.website > dl > dt > a { font-weight: normal; }
	ul.link_box li.website > dl > dt > a:hover { color: #007bff; }
	ul.link_box li.website > dl > dd.title_block > .web_url > a { color: green; }
	ul.link_box li.website > dl > dd.web_vote { color: #777; font-size: 11px; }
	ul.link_box li.website > dl > dd.web_vote > a { color: green }
	ul.link_box li.website > dl > dd.web_vote > a:hover { color: orange }
</style>
<?php if($code == 100):?>
	<div class="data_wrap border">
		진단 날짜 : <?=$vote_datas['date_regis']?> 에 실시하신 설문을 내용을 바탕으로 추천된 정보입니다.
	</div>
	<div class="info_wrap">
		<?php foreach ($datas['keyword_set'] as $key => $val) :?>
		<h4><?=$val['keyword_title']?></h4>
		<ul class="link_box">
		<?php foreach ($val[0] as $val2):  ?>
			<?php foreach ($val2 as $info):  ?>
			<li class="website">
				<dl>
				   <dt> 
					   	<a href="/survey/redirect_url?to=<?=$info['url']?>" target="_blank" class="title_link"><?=$info['title']?></a> 
					   	<span class="ico_area"></span>
				   	</dt>
				   <dd class="title_block">
				      <div class="web_url ell">
				         <a href="/survey/redirect_url?to=<?=$info['url']?>" target="_blank" class="txt_url" onclick="return goOtherCR(this, 'a=web_all*w.url&amp;r=1&amp;i=a00000fa_bdadbe41c7c4af4da634e254&amp;u='+urlencode(this.href ? this.href : location.href))"><?=$info['url']?></a> 
				      </div>
				   </dd>
				   <dd class="web_passage">Take this quick scientific quiz to determine the size of your English vocabulary.</dd>
				   <dd class="web_vote">이 정보가 맘에 드시나요? <a href="#" onclick="update_like('<?=$info['url']?>');"><span>만족</span></a></dd>
				</dl>
			</li>
			<?php endforeach; ?>
		<?php endforeach;?>
		</ul>
		<hr>
		<?php endforeach;?>
	</div>
<?php elseif($code == 2):?>
	<div class="data_wrap border">
		진단 내역이 존재 하지 않습니다. <br>
		문진표 작성 후 이용해주세요. <br><br>
		<a href="/survey/">문진표 작성하기</a>
	</div>
<?php elseif($code == 1):?>
	<div class="data_wrap border">
		로그인이 필요합니다.
	</div>
<?php else:?>
	<div class="data_wrap border">
		에러가 발생하였습니다.
	</div>
<?php endif;?>




<script>
	function update_like(link_url){
		$.ajax({
			type: "POST",
			url: "/survey/update_like",
			data: {
				url : link_url
			},
			success: function(response) {
				alert('만족처리되었습니다.');
				// results = JSON.parse(response);
				// if(results.msg) alert(results.msg);
				// if(results.code == 100) location.href="/survey";
			}
		});
		return false;
	}
</script>