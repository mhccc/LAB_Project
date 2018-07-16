<style>
  [data-role="faq_sub"] {display: none;}
</style>
<table class="table table-fixed table-striped table-fixed text-center word-break-all">
  <colgroup>
    <col>
  </colgroup>
  <thead>
    <tr>
      <th scope="col">자주 묻는 질문</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($lists as $val):?>
    <tr data-role="faq_title" data-index="<?=$val['seq']?>">
      <td class="ell text-left"><a href="#"><?=$val['title']?></a></td>
    </tr>
    <tr data-role="faq_sub" data-index="<?=$val['seq']?>">
      <td class="text-left"><?=$val['contents']?></td>
    </tr>
    <?php endforeach;?>
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

<script>
  $(function(){
    $('[data-role="faq_title"]').on('click', function(){
      var selected_num = $(this).data('index');
      $('[data-role="faq_sub"]').hide();
      $('[data-role="faq_sub"][data-index="' + selected_num + '"]').slideDown();
    })
  });
</script>