          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title"><?=($seq?'수정하기':'글쓰기')?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body"><?php if(isset($act['msg'])):?>
        		<div class="alert <?=($act['code'] == 100 ? 'alert-success':'alert-warning')?> alert-dismissible">
	                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                <h4><i class="icon fa fa-check"></i><?=($act['code'] == 100 ? '성공':'실패')?></h4>
	                <?=$act['msg']?>
              	</div><?php endif; ?>
              <form role="form" method="POST">
				<input type="hidden" name="mode" value="<?=$mode?>">
				<input type="hidden" name="seq" value="<?=$seq?>">
				<input type="hidden" name="bbsid" value="<?=$bbsid?>">
                <!-- text input -->
                <div class="form-group">
                  <label>제목</label>
                  <input type="text" name="title" class="form-control" value="<?=$data['title']?>" placeholder="">
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>내용</label>
                  <textarea class="form-control" name="contents" rows="3"><?=$data['contents']?></textarea>
                </div>

                <div class="form-group text-center">
					<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
					  <button type="submit" class="btn btn-primary"><?=($seq?'수정하기':'글쓰기')?></button>
					  <button type="button" class="btn btn-secondary" onclick="location.href='/admin/cs_faq';">목록으로</button>
					  <button type="button" class="btn btn-danger" onclick="board_delete();">삭제하기</button>
					</div>
				</div>
              </form>
            </div>
            <!-- /.box-body -->
          </div>


<script>


function board_delete(){
	if(confirm('삭제하시겠습니까?')){
        $.ajax({
			type: "POST",
            url:'/admin/board_delete',
            dataType:'json',
			data: {
				seq : '<?=$seq?>'
			},
            success:function(data){
				if(data.msg) alert(data.msg);
				if(data.code == 100) location.href="/admin/cs_faq/";
            }
        });
	}
	return false;
}
</script>