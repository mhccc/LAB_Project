<style>
   #board_view {border-top: solid 5px #ddd;}
</style>
<table id="board_view" class="table table-bordered table_view">
   <colgroup>
      <col width="20%">
      <col width="80%">
   </colgroup>
   <tbody>
      <tr>
         <td colspan="2" class="board_view_title"><?=$data['title']?></td>
      </tr>
      <tr>
         <td colspan="2">
            <div class="row">
               <div class="col-sm-10 col-xs-8">
                  <span>관리자</span><em class="bar"> | </em><span><?=$data['d_regis']?></span>
               </div>
               <div class="col-sm-2 col-xs-4 text-right">
                  <!-- Single button -->
                  <div class="btn-group">
                  </div>
               </div>
            </div>
         </td>
      </tr>
      <tr>
         <td colspan="2">
            <?=$data['contents']?>
         </td>
      </tr>
   </tbody>
</table>
<!-- btn -->
<div class="text-right">
   <button onclick="location.href='/<?=$url_list?><?php if(isset($pageNum)):?>?pageNum=<?=$pageNum?><?php endif; ?>'">목록</button>
</div>