          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">회원 정보 수정</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body"><?php if(isset($act['msg'])):?>
        		<div class="alert <?=($act['code'] == 100 ? 'alert-success':'alert-warning')?> alert-dismissible">
	                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                <h4><i class="icon fa fa-check"></i><?=($act['code'] == 100 ? '성공':'실패')?></h4>
	                <?=$act['msg']?>
              	</div><?php endif; ?>
              <form role="form" method="POST">
				<input type="hidden" name="mode" value="edit">
				<input type="hidden" name="seq" value="<?=$seq?>">
                <!-- text input -->
                <div class="form-group">
                  <label>이메일</label>
                  <input type="text" class="form-control" placeholder="<?=$data['email']?>" disabled>
                </div>
                <div class="form-group">
                  <label>이름</label>
                  <input type="text" name="name" class="form-control" value="<?=$data['name']?>" placeholder="">
                </div>
                <div class="form-group">
                  <label>닉네임</label>
                  <input type="text" name="nic" class="form-control" value="<?=$data['nic']?>" placeholder="">
                </div>
                <div class="form-group">
                  <label>새 비밀번호</label>
                  <input type="password" name="change_pw" class="form-control" placeholder="새 암호 입력">
                </div>
                <div class="form-group">
                  <label>새 비밀번호 확인</label>
                  <input type="password" name="change_pw_confirm" class="form-control" placeholder="새 암호 확인">
                </div>
                <div class="form-group">
                  <label>휴대폰 번호</label>
                  <input type="text" name="tel" class="form-control" value="<?=$data['tel2']?>" placeholder="- 없이 입력">
                </div>

                <!-- textarea -->
                <div class="form-group">
                  <label>관리자 메모</label>
                  <textarea class="form-control" name="admin_memo" rows="3" placeholder="관리자에게만 보여집니다."><?=$data['admin_memo']?></textarea>
                </div>

                <div class="form-group text-center">
					<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
					  <button type="submit" class="btn btn-primary">수정하기</button>
					  <button type="button" class="btn btn-secondary" onclick="location.href='/admin/member_list';">목록으로</button>
					  <button type="button" class="btn btn-danger" onclick="member_delete();">탈퇴처리</button>
					</div>
				</div>
              </form>
            </div>
            <!-- /.box-body -->
          </div>


<script>

function form_submit(formobj){
	var form_data = $(formobj).serialize();
	if(confirm('회원 정보를 수정하시겠습니까?')){
		$.ajax({
			type: "POST",
			url: "/admin_api/member_modify",
			data: form_data,
			success: function(results) {
				if(results.msg) alert(results.msg);
				if(results.code == 100) location.reload();
			}
		});
	}
	return false;
}

function member_delete(){
	if(confirm('회원을 탈퇴시키겠습니까?') && confirm('최종확인입니다. 삭제시 복구가 불가능합니다. 탈퇴시키시겠습니까?')){
		$.ajax({
			type: "POST",
			url: "/admin_api/member_delete",
			data: {
				seq : '<?=$seq?>'
			},
			success: function(results) {
				if(results.msg) alert(results.msg);
				if(results.code == 100) location.href="/admin/member/";
			}
		});
	}
	return false;
}
</script>