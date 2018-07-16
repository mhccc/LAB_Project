<style>
  .pagination {
    justify-content: center;
  }
</style>
<table class="table table-fixed table-striped table-hover text-center">
  <colgroup>
    <col width="50">
    <col>
    <col width="120">
    <col width="80">
  </colgroup>
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">제목</th>
      <th scope="col">날짜</th>
      <th scope="col">조회수</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($list['data'] as $key => $val):?>
    <tr>
      <th scope="row"><?=$val['seq']?></th>
      <td class="ell text-left"><a href="/<?=$url_list?>_view/<?=$val['seq']?>"><?=$val['title']?></a></td>
      <td><?=substr($val['d_regis'],2,8)?></td>
      <td><?=$val['hit']?></td>
    </tr>
    <?php endforeach;?>
    <?php if(!$list['all_num']):?>
    <tr>
      <td colspan="4">표시할 목록이 없습니다.</td>
    </tr>
    <?php endif;?>
  </tbody>
</table>
<nav aria-label="Page navigation example" style="margin-top: 40px;">
  <?=$pagin?>
</nav>
