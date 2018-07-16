<style>
  .pagination {
    justify-content: center;
  }
</style>
<table class="table table-fixed table-striped table-hover text-center">
  <colgroup>
    <col width="50">
    <col width="240">
    <col width="80">
  </colgroup>
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">설문날짜</th>
      <th scope="col">내역</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($lists as $val):?>
    <tr>
      <th scope="row"><?=$val['seq']?></th>
      <td class="ell"><?=print_r($val['date_regis'])?></td>
      <td><button class="btn btn-small btn-warning btn-sm" onclick="location.href='/survey/mylist_view/<?=$val['seq']?>'">내역 조회</button></td>
    </tr>
    <?php endforeach;?>
    <?php if(count($lists) < 1):?>
    <tr>
      <td colspan="3">표시할 목록이 없습니다.</td>
    </tr>
    <?php endif;?>
  </tbody>
</table>
<nav aria-label="Page navigation example" style="margin-top: 40px;">
  <ul class="pagination">
    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item"><a class="page-link" href="#">Next</a></li>
  </ul>
</nav>
