<div class="row">
   <div class="col-md-4">
      <div class="box">
         <div class="box-header with-border">
            <div class="box-header ui-sortable-handle" style="cursor: move;">
              <i class="ion ion-clipboard"></i>

              <h3 class="box-title">키워드셋</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-default btn-small" onclick="location.href='/admin/crawler_keyset/<?=$pageid?>';">추가하기</button>
              </div>
            </div>
         </div>
         <!-- /.box-header -->
         <div class="box-body">
            <table class="table table-bordered text-center">
               <tbody>
                  <tr>
                     <th style="width: 80px">단어(연관)</th>
                     <th style="width: 10px">IDX</th>
                     <th style="width: 60px">조건</th>
                     <th style="width: 40px">관리</th>
                  </tr>
                  <?php foreach ($list['data'] as $val):?>
                  <tr<?php if($val['_id'] == $form['_id']):?> class="bg-gray"<?php endif;?>>
                     <td><?=isset($val['keyword_title'])?$val['keyword_title']:''?>(<?=isset($val['keyword_list'])?count($val['keyword_list']):0?>)</td>
                     <td><?=isset($val['survey_index'])?$val['survey_index']:''?></td>
                     <td><?=isset($val['scope'])?$val['scope']:''?></td>
                     <td>
                        <a href="/admin/crawler_keyset/<?=$pageid?>?id=<?=$val['_id']?>"><span class="badge bg-blue">M</span></a>
                        <a href="#" onclick="delete_set('<?=$val['_id']?>');"><span class="badge bg-red">D</span></a>
                     </td>
                  </tr>
                  <?php endforeach;?>
                  <?php if(count($list['data']) == 0):?>
                    <tr>
                        <td colspan="4" class="text-center">표시할 목록이 없습니다.</td>
                    </tr>
                  <?php endif; ?>
               </tbody>
            </table>
         </div>
         <!-- /.box-body -->
         <div class="box-footer clearfix text-center">
            <?=$pagin?>
         </div>
      </div>
      <!-- /.box -->
   </div>
   <!-- /.col -->
   <div class="col-md-8">
      <div class="box <?=($form['mode']=='modify')?'box-warning':'box-info'?>">
         <div class="box-header with-border">
            <h3 class="box-title">키워드셋 <?=($form['mode']=='modify')?'수정':'등록'?></h3>
         </div>
         <!-- /.box-header -->
         <!-- form start -->
         <?php $cateset = array('성별','나이대','규칙적인 식사(야식 포함)','음주','흡연','운동(유산소 운동,무산소 운동)','질병(고혈압,당뇨)','암(간암,위암,폐암,갑상선암,유방암,기타암)');?>
         <form method="POST" class="form-horizontal" onsubmit="return submit_form(this, '<?=$form['mode']?>');">
            <input type="hidden" name="mode" value="<?=$form['mode']?>">
            <input type="hidden" name="keyword_set_id" value="<?=$form['_id']?>">
            <div class="box-body">
               <?php if($form['mode']=='modify'):?>
               <div class="form-group">
                  <label for="keyword_set_id" class="col-sm-2 control-label">고유 ID</label>
                  <div class="col-sm-10">
                     <?=$form['_id']?>
                  </div>
               </div>
               <?php endif; ?>
               <div class="form-group">
                  <label for="keyword_set_category" class="col-sm-2 control-label">카테고리</label>
                  <div class="col-sm-10">
                     <select class="form-control" name="keyword_set_category" id="keyword_set_category">
                        <option>선택</option>
                        <?php foreach ($cateset as $key => $value):?>
                         <option value="<?=$key?>"<?php if($form['category'] && $key == $form['category']):?> selected="selected"<?php endif;?>><?=$value?></option>
                        <?php endforeach?>
                     </select>
                  </div>
               </div>
               <div class="form-group">
                  <label for="keyword_set_index" class="col-sm-2 control-label">해당 인덱스</label>
                  <div class="col-sm-10">
                     <input type="number" class="form-control" id="keyword_set_index" name="keyword_set_index" value="<?=$form['index']?>">
                  </div>
               </div>
               <div class="form-group">
                  <label for="keyword_set_scope" class="col-sm-2 control-label">조건</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" id="keyword_set_scope" name="keyword_set_scope" value="<?=$form['scope']?>">
                  </div>
               </div>
               <div class="form-group">
                  <label for="keyword_set_title" class="col-sm-2 control-label">대표단어</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" id="keyword_set_title" name="keyword_set_title" value="<?=$form['keyword_set_title']?>">
                  </div>
               </div>
               <hr>
               <div class="keyword_set" data-role="word_set">
                  <?php foreach ($form['keyword_set'] as $key => $val):?>
                  <div class="form-group">
                     <label class="col-sm-2 control-label"><?=($key==0)?'연관단어':''?></label>
                     <div class="col-sm-10">
                        <div class="input-group">
                           <input type="text" name="keyword_set_word[]" class="form-control" value="<?=$val?>">
                           <span class="input-group-addon" data-role="more_word"><i class="fa fa-plus"></i></span>
                        </div>
                     </div>
                  </div>
                  <?php endforeach; ?>
               </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
               <button type="button" class="btn btn-default" onclick="location.href='/admin/crawler_keyset/<?=$pageid?>';">취소</button>
               <button type="submit" class="btn btn-<?=($form['mode']=='modify')?'warning':'info'?> pull-right"><?=($form['mode']=='modify')?'수정':'등록'?>하기</button>
            </div>
            <!-- /.box-footer -->
         </form>
      </div>
   </div>
   <!-- /.col -->
</div>
<script>
   function submit_form(f){
     var form_data = $(f).serialize();

     // ajax 전송
     $.ajax({
       type: "POST",
       url: '/admin/crawler_keyset_update',
       data: form_data,
       success: function(response) {
         results = JSON.parse(response);
         if(results.msg) alert(results.msg);
         if(results.code == 100 && results._id) location.href="/admin/crawler_keyset/<?=$pageid?>?id="+results._id;
         else if(results.code == 100) location.href="/admin/crawler_keyset/";
       }
     });
     return false;
   }
   
   function delete_set(set_id){
     var form_data = {
        mode : 'delete',
        keyword_set_id : set_id
     };
     if(confirm('정말로 해당 키워드셋을 삭제하시겠습니까?')){
         // ajax 전송
         $.ajax({
           type: "POST",
           url: '/admin/crawler_keyset_delete',
           data: form_data,
           success: function(response) {
             results = JSON.parse(response);
             if(results.msg) alert(results.msg);
             if(results.code == 100) location.href="/admin/crawler_keyset/<?=$pageid?>";
           }
         });
     }
     return false;
   }
   
   
   $(function(){
       $(document).on('click', '[data-role="del_word"]', function(){
         $(this).parent().parent().parent().remove();
       });
       $(document).on('click', '[data-role="more_word"]', function(){
         var more_form = '<div class="form-group"><label class="col-sm-2 control-label"></label><div class="col-sm-10"><div class="input-group"><input type="text" name="keyword_set_word[]" class="form-control"><span class="input-group-addon" data-role="del_word"><i class="fa fa-times"></i></span></div></div></div>';
         $('[data-role="word_set"]').append(more_form);
       });
   });
</script>