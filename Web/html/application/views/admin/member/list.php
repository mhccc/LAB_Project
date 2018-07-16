<div class="row">
   <div class="col-xs-12">
      <div class="box">
         <!-- /.box-header -->
         <div class="box-body" style="overflow-x: auto;">
            <table class="table table-bordered table-hover text-center" style="min-width: 700px;">
                <colgroup>
                    <col width="90">
                    <col width="250">
                    <col width="100">
                    <col width="100">
                    <col width="100">
                    <col width="100">
                    <col width="190">
                </colgroup>
               <thead>
                  <tr>
                     <th>UID</th>
                     <th>메일주소</th>
                     <th>이름</th>
                     <th>닉네임</th>
                     <th>가입일</th>
                     <th>수정일</th>
                     <th>관리</th>
                  </tr>
               </thead>
               <tbody>
                  <?php foreach ($list['data'] as $key => $val):?>
                  <tr>
                     <td><?=$val['memberuid']?></td>
                     <td><?=$val['email']?></td>
                     <td><?=$val['name']?></td>
                     <td><?=$val['nic']?></td>
                     <td><?=$val['d_regis']?></td>
                     <td><?=$val['d_modify']?></td>
                     <td><a href="/admin/member_edit/<?=$val['memberuid']?>">수정</a></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
            </table>
         </div>
         <!-- /.box-body -->
         <div class="box-footer text-center">
             <?=$pagin?>
         </div>
      </div>
      <!-- /.box -->
   </div>
   <!-- /.col -->
</div>