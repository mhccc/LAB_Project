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
				<form name="signupForm" role="form" method="post" id="signupForm" novalidate autocomplete="off" onsubmit="modify_submit(); return false;">
					<div class="form-group">
						<label for="email">이메일</label>
						<input type="email" class="form-control" name="email" id="email" value="<?=$my['email']?>" placeholder="" disabled>
						<div class="invalid-feedback" id="email-feedback"></div>
					</div>
					<div class="form-group">
						<label for="name">이름</label>
						<input type="text" class="form-control" name="name" id="name" value="<?=$my['name']?>" placeholder="실명을 입력해 주세요."  required autocomplete="off">
						<div class="invalid-feedback"></div>
						<span class="help-block"></span>
					</div>
					<div class="form-group">
						<label for="name">닉네임</label>
						<input type="text" class="form-control" name="nic" id="nic" value="<?=$my['nic']?>" placeholder="닉네임을 입력해 주세요."  required >
						<div class="invalid-feedback" id="nic-feedback"></div>
						<small class="form-text text-muted">2~12자로 사용할 수 있습니다.</small>
					</div>
					<div class="form-group">
						<label for="tel">전화번호</label>
						<input type="text" class="form-control" name="tel" id="tel" value="<?=$my['tel2']?>" placeholder="하이픈(-) 없이 입력해주세요."  required autocomplete="off">
						<div class="invalid-feedback"></div>
						<span class="help-block"></span>
					</div>
					<div class="form-group">
						<label for="pw">비밀번호</label>
						<input type="password" class="form-control" name="pw" id="pw" value="" placeholder="" required onblur="pw1Check();" autocomplete="off">
						<div class="invalid-feedback" id="pw-feedback"></div>
						<small class="form-text text-muted">8~16자의 영문/숫자/특수문자중 2개이상의 조합으로 만드셔야 합니다.</small>
					</div>
					<div class="form-group">
						<label for="change_pw">변경 비밀번호</label>
						<input type="password" class="form-control" name="change_pw" id="change_pw" value="" placeholder="" required onblur="change_pw_Check();" autocomplete="off">
						<div class="invalid-feedback" id="change_pw-feedback"></div>
						<small class="form-text text-muted">8~16자의 영문/숫자/특수문자중 2개이상의 조합으로 만드셔야 합니다.</small>
					</div>
					<div class="form-group">
						<label for="change_pw_confirm">변경 비밀번호 확인</label>
						<input type="password" class="form-control" name="change_pw_confirm" id="change_pw_confirm" value="" placeholder="" required onblur="change_pw_confirm_Check();" autocomplete="off">
						<div class="invalid-feedback" id="change_pw_confirm-feedback"></div>
						<small class="form-text text-muted">8~16자의 영문/숫자/특수문자중 2개이상의 조합으로 만드셔야 합니다.</small>
					</div>

					<button class="btn btn-primary" type="submit" id="rb-submit">수정하기</button>

				</form>
			</div><!-- .page-main -->
		</article><!-- .page-wrapper -->
	</div><!-- /.bg-shade-gradient -->

</main>

<script type="text/javascript">
//<![CDATA[

function modify_submit(){
	var form_data = $('form#signupForm').serialize();
	$.ajax({
		type: "POST",
		url: "/member_api/info_update",
		data: form_data,
		success: function(response) {
			if(response.msg) alert(response.msg);
			if(response.code == '100') {
				location.reload();
			}else if(response.code == '101') {
				location.href="/member/login";
			}
			return false;
		}
	});
}

//]]>
</script>
