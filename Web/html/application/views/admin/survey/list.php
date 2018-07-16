<div class="row">
   <div class="col-xs-12">
      <div class="box">
         <!-- /.box-header -->
         <div class="box-body" style="overflow-x: auto;">
            <table class="table table-bordered table-hover text-center" style="min-width: 700px;">
                <colgroup>
                    <col width="90">
                    <col width="90">
                    <col width="120">
                    <col width="300">
                    <col width="100">
                    <col width="100">
                    <col width="50">
                </colgroup>
               <thead>
                  <tr>
                     <th>Seq</th>
                     <th>회원#</th>
                     <th>생년월일</th>
                     <th>직렬화 데이터</th>
                     <th>가입일</th>
                     <th>수정일</th>
                     <th>자세히</th>
                  </tr>
               </thead>
               <tbody>
                  <?php foreach ($list['data'] as $key => $val):?>
                  <tr>
                     <td><?=$val['seq']?></td>
                     <td><?=$val['user_seq']?></td>
                     <td><?=$val['birth_year']."-".sprintf('%02d', $val['birth_month'])."-".sprintf('%02d', $val['birth_day'])?></td>
                     <td><?=$val['serial']?></td>
                     <td><?=$val['date_regis']?></td>
                     <td><?=$val['date_modify']?></td>
                     <td><a href="/admin/survey_view/<?=$val['seq']?>">보기</a></td>
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