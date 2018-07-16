<style>
.custom-select.is-invalid, .form-control.is-invalid, .was-validated .custom-select:invalid, .was-validated .form-control:invalid {
	border-color: #dc3545;
}
.invalid-feedback {display: block;}
</style>
<main role="main" class="container">
	<div class="bg-shade-gradient">
		<article class="page-wrapper">
			<div class="page-main">
				<form name="signupForm" role="form" method="post" id="signupForm" novalidate autocomplete="off" onsubmit="join_submit(); return false;">
					<div class="form-group">
						<label for="email">이메일</label>
						<input type="email" class="form-control" name="email" id="email" value="" placeholder="" required>
						<div class="invalid-feedback" id="email-feedback"></div>
					</div>
					<div class="form-group">
						<label for="name">닉네임</label>
						<input type="text" class="form-control" name="nic" id="nic" value="" placeholder="닉네임을 입력해 주세요."  required >
						<div class="invalid-feedback" id="nic-feedback"></div>
						<small class="form-text text-muted">2~12자로 사용할 수 있습니다.</small>
					</div>
					<div class="form-group">
						<label for="name">이름</label>
						<input type="text" class="form-control" name="name" id="name" value="" placeholder="실명을 입력해 주세요."  required autocomplete="off">
						<div class="invalid-feedback"></div>
						<span class="help-block"></span>
					</div>
					<div class="form-group">
						<label for="tel">전화번호</label>
						<input type="text" class="form-control" name="tel" id="tel" value="" placeholder="하이픈(-) 없이 입력해주세요."  required autocomplete="off">
						<div class="invalid-feedback"></div>
						<span class="help-block"></span>
					</div>
					<div class="form-group">
						<label for="pw1">비밀번호</label>
						<input type="password" class="form-control" name="pw" id="pw" value="" placeholder="" required onblur="pw1Check();" autocomplete="off">
						<div class="invalid-feedback" id="pw1-feedback"></div>
						<small class="form-text text-muted">8~16자의 영문/숫자/특수문자중 2개이상의 조합으로 만드셔야 합니다.</small>
					</div>
					<div class="form-group">
						<label for="pw2">비밀번호 확인</label>
						<input type="password" class="form-control" name="pw_confirm" id="pw_confirm" placeholder="" required onkeyup="pw2Check();" autocomplete="off">
						<div class="invalid-feedback" id="pw2-feedback"></div>
					</div>


					<p class="form-info">아래의 '회원가입' 버튼을 클릭하면
					  <a href="/terms" target="_blank">이용약관</a> 과
					  <a href="/privacy" target="_blank">개인정보취급방침</a>에 동의하게 됩니다.
					</p>

					<button class="btn btn-primary" type="submit" id="rb-submit">
						<span class="not-loading">회원가입</span>
						<span class="is-loading"><i class="fa fa-spinner fa-lg fa-spin fa-fw"></i> 회원가입 중 ...</span>
					</button>

				</form>
			</div><!-- .page-main -->
		</article><!-- .page-wrapper -->
	</div><!-- /.bg-shade-gradient -->

</main>

<script type="text/javascript">
//<![CDATA[

function join_submit(){
	var form_data = $('form#signupForm').serialize();
	$.ajax({
		type: "POST",
		url: "/member_api/join",
		data: form_data,
		success: function(response) {
			if(response.msg) alert(response.msg);
			if(response.code == '100') {
				location.href = "/member/login";
			}
			return false;
		}
	});
}

//]]>
</script>
