<main role="main" class="container">	
	<!-- global css -->
	<article id="pages-signup">
	  	<form name="procForm" action="/member/join" method="get">
		<input type="hidden" name="page" value="step2" />
		<input type="hidden" name="comp" value="0" />

		<div class="page-header">
			<h2>약관동의 <small>약관 및 안내를 읽고 동의해 주세요.</small></h2>
		</div>
	<!-- 	<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<i class="fa fa-info-circle fa-lg"></i> 회원으로 가입을 원하실 경우, [홈페이지 약관 및 개인정보 수집·이용]에 동의 하셔야 합니다.
		</div> -->

		<section class="page-section" id="agreement">
			<h4><i class="fa fa-file-text-o"></i> 이용약관</h4>
			<p>
			<textarea readonly="readonly" class="form-control" rows="12">약관1</textarea>
			</p>
		</section>
<section class="page-section mt-5" id="privacy">
		<h4 class="mb-3"><i class="fa fa-file-text-o"></i> 개인정보 취급방침</h4>
		<ul class="nav nav-tabs mb-2">
		  <li class="nav-item"><a class="nav-link active show" href="#agree-privacy-1" data-toggle="tab">개인정보수집 및 이용목적</a></li>
		  <li class="nav-item"><a class="nav-link" href="#agree-privacy-2" data-toggle="tab">수집하는 개인정보의 항목</a></li>
		  <li class="nav-item"><a class="nav-link" href="#agree-privacy-3" data-toggle="tab">개인정보보유 및 이용기간</a></li>
		  <li class="nav-item"><a class="nav-link" href="#agree-privacy-4" data-toggle="tab">개인정보의 위탁처리</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade active show" id="agree-privacy-1"><textarea readonly="readonly" class="form-control" rows="12">1</textarea></div>
			<div class="tab-pane" id="agree-privacy-2"><textarea readonly="readonly" class="form-control" rows="12">2</textarea></div>
			<div class="tab-pane" id="agree-privacy-3"><textarea readonly="readonly" class="form-control" rows="12">3</textarea></div>
			<div class="tab-pane" id="agree-privacy-4"><textarea readonly="readonly" class="form-control" rows="12">4</textarea></div>
		</div>
	</section>
	   <br >
		<div class="form-group checkbox has-error">
			<label>
				<input type="checkbox" name="agreecheckbox"> 위의 <strong>'홈페이지 이용약관 및 개인정보 수집·이용'</strong>에 동의 합니다.
			</label>

		</div>

		<div class="page-footer">
			<button type="button" class="btn btn-primary" onclick="return nextStep(0);"><i class="fa fa-male fa-lg"></i> 개인 회원가입</button>
			<button type="button" class="btn btn-primary" onclick="return nextStep(1);"><i class="fa fa-building-o fa-lg"></i> 기업 회원가입</button>
			<button type="button" class="btn btn-primary" onclick="return nextStep(0);">다음단계로</button>
		</div>
	 </form>
	</article>
</main>

<script type="text/javascript">
//<![CDATA[
function nextStep(n)
{
	var f = document.procForm;

	if (f.agreecheckbox.checked == false)
	{
		alert('회원으로 가입을 원하실 경우,\n\n[홈페이지 약관 및 개인정보 수집·이용]에 동의하셔야 합니다.');
		return false;
	}

	f.comp.value = n;
	f.submit();
}
function tabShow(n)
{
	var i;

	for (i = 1; i < 5; i++)
	{
		getId('tagree'+i).style.borderBottom = '#dfdfdf solid 1px';
		getId('tagree'+i).style.background = '#f9f9f9';
		getId('tagree'+i).style.color = '#666666';
		getId('bagree'+i).style.display = 'none';
	}
	getId('tagree'+n).style.borderBottom = '#ffffff solid 1px';
	getId('tagree'+n).style.background = '#ffffff';
	getId('tagree'+n).style.color = '#000000';
	getId('bagree'+n).style.display = 'block';
}
//]]>
</script>
