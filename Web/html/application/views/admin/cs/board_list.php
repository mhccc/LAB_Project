<style>
  .ell {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
</style>
<div class="row">
   <div class="col-xs-12">
      <div class="box">
         <!-- /.box-header -->
         <div class="box-body" style="overflow-x: auto;">
            <table class="table table-bordered table-hover text-center" style="min-width: 700px;">
                <colgroup>
                    <col width="50">
                    <col width="250">
                    <col width="100">
                    <col width="190">
                </colgroup>
               <thead>
                  <tr>
                     <th>#</th>
                     <th>제목</th>
                     <th>수정일</th>
                     <th>관리</th>
                  </tr>
               </thead>
               <tbody>
                  <?php foreach ($list['data'] as $key => $val):?>
                  <tr>
                     <td><?=$val['seq']?></td>
                     <td class="ell"><?=$val['title']?></td>
                     <td><?=$val['d_regis']?></td>
                     <td><a href="/admin/<?=$current?>_edit/<?=$val['seq']?>">수정</a></td>
                  </tr>
                  <?php endforeach; ?>
                  <?php if(!count($list['data'])):?>
                    <tr>
                      <td colspan="4" class="text-center">표시할 목록이 없습니다.</td>
                    </tr>
                  <?php endif;?>
                </tbody>
            </table>
         </div>
         <!-- /.box-body -->
         <div class="box-footer text-center">
          <div class="text-right"><button class="btn btn-default" onclick="location.href='/admin/<?=$current?>_edit/'">글쓰기</button></div>
             <?=$pagin?>
         </div>
      </div>
      <!-- /.box -->
   </div>
   <!-- /.col -->
</div>