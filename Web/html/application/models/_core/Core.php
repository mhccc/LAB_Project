<?php 
class Core extends CI_Model {
	private $menus;
	public $common_data;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Member_model');

		$this->menus = array(
    		array('서비스', 'show', array(
    			array('/intro','개 요')
    		)),
    		array('진단', 'show', array(
    			array('/survey/','문진표 작성'),
    			array('/survey/mylist','진단 내역'),
    			array('/survey/me','맞춤 정보')
    		)),
    		array('고객센터', 'show', array(
    			array('/cs/notice','공지사항'),
    			array('/cs/faq','자주묻는 질문'),
    			array('/cs/policy','정책 안내'),
    			array('/cs/qna','1:1 문의')
    		)),
    		array('회원', 'hide', array(
    			array('/member/join_agree','가입약관'),
    			array('/member/join','가입'),
    			array('/member/login','로그인'),
    			array('/member/info','정보 수정')
    		)),
    		array('사이트', 'hide', array(
    			array('/','메인')
    		))
    	);

		$this->common_data = array(
			'is_logged' => $this->Member_model->is_logged,
			'my' => $this->Member_model->my,
			'fullpage_mode' => false,
			'page_fullmenu' => $this->menus,
			'page_title' => ''
		);

    }

    public function get_full_menus(){
    	return $this->menus;
    }

    public function get_menus($group_num, $menu_num){
    	$submenu_tag = '';
    	foreach ($this->menus[$group_num][2] as $key => $val) {
	    	$submenu_tag .= "<li".(($menu_num == $key)?' class="active"':'')."><a href='".$val[0]."'>".$val[1]."</a></li>";
    	}
    	return array('group_num' => $group_num, 'menu_num' => $menu_num, 'title' => $this->menus[$group_num][0], 'subtitle' => $this->menus[$group_num][2][$menu_num][1], 'submenu_tag' => $submenu_tag);
    }

		
}
?>