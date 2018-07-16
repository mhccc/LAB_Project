<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->load->model('_admin/Admin_member');
		$this->Admin_member->__only_admin__();

        $this->form_validation->set_message('required', '{field} 입력은 필수입니다.');
        $this->form_validation->set_message('matches', '{field} 입력이 확인 입력과 일치하지 않습니다.');
        $this->form_validation->set_message('is_unique', '이미 가입된 {field}입니다.');
        $this->form_validation->set_message('numeric', '{field}는 숫자만 입력가능합니다.');
        $this->form_validation->set_message('valid_email', '{field}의 형식이 올바르지 않습니다.');
        $this->form_validation->set_message('min_length', '{field}는 최소 {param}자 이상이어야 합니다.');
        $this->form_validation->set_message('max_length', '{field}는 최대 {param}자 이하이어야 합니다.');
        $this->form_validation->set_message('greater_than_equal_to', '{field}는 최소 {param} 이상이어야 합니다.');
        $this->form_validation->set_message('less_than_equal_to', '{field}는 최대 {param} 이하이어야 합니다.');
    }

	public function index()
	{
		$this->load->model('_admin/Admin_main');
		$this->load->view('admin/_header', $this->Core->common_data);

		$top_data = array(
			'top_menu' => "대시보드", 
			'nav_title' => "대시보드", 
			'nav_subtitle' => "Dash Board"
		);
		$this->load->view('admin/_top', $top_data);

		$data['view_num'] = $this->Admin_main->main_view();
 		$this->load->view('admin/_aside', $this->Core->common_data);
		$this->load->view('admin/main', $data);
		$this->load->view('admin/_foot');
		$this->load->view('admin/_footer');
	}

	public function member_list(){
		$this->load->view('admin/_header', $this->Core->common_data);
		$top_data = array(
			'current' => "member_list", 
			'top_menu' => "회원", 
			'nav_title' => "회원목록", 
			'nav_subtitle' => "Member List"
		);
		$this->load->view('admin/_top', $top_data);

		$aside_data = $this->Core->common_data;
		$aside_data['menu1'] = '3'; // 1차 카테고리
		$aside_data['menu2'] = '1'; // 2차 카테고리
		$this->load->view('admin/_aside', $aside_data);

		// 컨텍츠 영역 준비
		$nowpage = $this->uri->segment(3)?$this->uri->segment(3):1;
		$limits = 20;

		$data['list'] = $this->Admin_member->member_list(($nowpage-1)*$limits, $limits);

		// 페이지네이션
		$this->load->library('pagination');
		$config['base_url'] = '/admin/'.$top_data['current'].'/';
		$config['total_rows'] = $data['list']['all_num'];
		$config['per_page'] = $limits;
		$this->pagination->initialize($config);
		$data['pagin'] = $this->pagination->create_links();
		$data['pageid'] = $this->uri->segment(2);
		$this->load->view('admin/member/list', $data);

		$this->load->view('admin/_foot');
		$this->load->view('admin/_footer');
	}


	public function member_edit()
	{

		$this->load->view('admin/_header', $this->Core->common_data);

		$top_data = array(
			'current' => "member_list", 
			'top_menu' => "회원", 
			'nav_title' => "회원목록", 
			'nav_subtitle' => "Member List"
		);
		$this->load->view('admin/_top', $top_data);

		$aside_data = $this->Core->common_data;
		$aside_data['menu1'] = '3'; // 1차 카테고리
		$aside_data['menu2'] = '1'; // 2차 카테고리
		$this->load->view('admin/_aside', $aside_data);

		// 컨텐츠 영역 준비
		$data['seq'] = $seq = $this->uri->segment(3);

		// 모드별 삭제 및 수정
		if($this->input->post('mode') == 'edit'){
			/* 양식 검사 */
			$validation_conf = array(
		        array('field' => 'change_pw', 'label' => '비밀번호', 'rules' => 'min_length[8]|max_length[20]'),
		        array('field' => 'change_pw_confirm', 'label' => '비밀번호', 'rules' => 'min_length[8]|max_length[20]|matches[change_pw]'),
		        array('field' => 'tel', 'label' => '휴대폰 번호', 'rules' => 'required|numeric|min_length[8]|max_length[20]'),
		        array('field' => 'name', 'label' => '이름', 'rules' => 'required|min_length[3]|max_length[20]'), 
		        array('field' => 'nic', 'label' => '닉네임', 'rules' => 'required|min_length[3]|max_length[20]')
			);
			$this->form_validation->set_rules($validation_conf);
            if ($this->form_validation->run() == FALSE) 
            	$data['act'] = array('code' => 1, 'msg' => validation_errors() );
            else{
            	$updata = $_POST;
	        	$updata['date_modify'] = date('Y-m-d H:i:s');
			    $updata['modify_ip'] = $this->input->ip_address();
	    		$data['act'] = $act = $this->Admin_member->update_user_data($seq, $updata);
            }
		}


		$data['data'] = $this->Admin_member->get_data($data['seq']);
		$this->load->view('admin/member/edit', $data);
		$this->load->view('admin/_foot');
		$this->load->view('admin/_footer');

	}


	public function survey_list(){
		$this->load->model('_admin/Admin_survey');
		$this->load->view('admin/_header', $this->Core->common_data);
		$top_data = array(
			'current' => "survey_list", 
			'top_menu' => "문진표", 
			'nav_title' => "설문목록", 
			'nav_subtitle' => "Survey List"
		);
		$this->load->view('admin/_top', $top_data);

		$aside_data = $this->Core->common_data;
		$aside_data['menu1'] = '4'; // 1차 카테고리
		$aside_data['menu2'] = '1'; // 2차 카테고리
		$this->load->view('admin/_aside', $aside_data);

		// 컨텍츠 영역 준비
		$nowpage = $this->uri->segment(3)?$this->uri->segment(3):1;
		$limits = 20;

		$data['list'] = $this->Admin_survey->survey_list(($nowpage-1)*$limits, $limits);

		// 페이지네이션
		$this->load->library('pagination');
		$config['base_url'] = '/admin/'.$top_data['current'].'/';
		$config['total_rows'] = $data['list']['all_num'];
		$config['per_page'] = $limits;
		$this->pagination->initialize($config);
		$data['pagin'] = $this->pagination->create_links();
		$data['pageid'] = $this->uri->segment(2);
		$this->load->view('admin/survey/list', $data);

		$this->load->view('admin/_foot');
		$this->load->view('admin/_footer');
	}




	public function survey_view()
	{

		$this->load->view('admin/_header', $this->Core->common_data);

		$top_data = array(
			'current' => "survey_view", 
			'top_menu' => "문진표", 
			'nav_title' => "설문목록", 
			'nav_subtitle' => "Survey List"
		);
		$this->load->view('admin/_top', $top_data);

		$aside_data = $this->Core->common_data;
		$aside_data['menu1'] = '4'; // 1차 카테고리
		$aside_data['menu2'] = '1'; // 2차 카테고리
		$this->load->view('admin/_aside', $aside_data);

		// 컨텐츠 영역 준비
		$data['seq'] = $seq = $this->uri->segment(3);

		$this->load->model('_admin/Admin_survey');
		$data['data'] = $this->Admin_survey->get_data($data['seq']);
		$this->load->view('admin/survey/view', $data);
		$this->load->view('admin/_foot');
		$this->load->view('admin/_footer');

	}


	public function crawler_keyset(){
		$this->load->model('_admin/Admin_crawler');
		$this->load->view('admin/_header', $this->Core->common_data);
		$top_data = array(
			'current' => "crawler_keyset", 
			'top_menu' => "웹크롤러 봇", 
			'nav_title' => "조건별 키워드셋", 
			'nav_subtitle' => "Survey List"
		);
		$this->load->view('admin/_top', $top_data);

		$aside_data = $this->Core->common_data;
		$aside_data['menu1'] = '5'; // 1차 카테고리
		$aside_data['menu2'] = '2'; // 2차 카테고리
		$this->load->view('admin/_aside', $aside_data);

		// 컨텍츠 영역 준비
		$nowpage = $this->uri->segment(3)?$this->uri->segment(3):1;
		$limits = 10;

		$data['form'] = array(
			'mode' => 'add',
			'_id' => '',
			'category' => '',
			'index' => '',
			'scope' => '',
			'keyword_set_title' => '',
			'keyword_set' => array('')
		);

		if($this->input->get('id')){
		 	$tmp = $this->Admin_crawler->get_keyword_set($this->input->get('id'))[0];
			$data['form'] = array(
				'mode' => 'modify',
				'_id' => $tmp['_id'],
				'category' => $tmp['category_index'],
				'index' => $tmp['survey_index'],
				'scope' => $tmp['scope'],
				'keyword_set_title' => $tmp['keyword_title'],
				'keyword_set' => $tmp['keyword_list']
			);
		}

		$data['list'] = $this->Admin_crawler->keyset_list(($nowpage-1)*$limits, $limits);
		// 페이지네이션
		$this->load->library('pagination');
		$config['base_url'] = '/admin/'.$top_data['current'].'/';
		$config['total_rows'] = $data['list']['all_num'];
		$config['per_page'] = $limits;
		$this->pagination->initialize($config);
		$data['pagin'] = $this->pagination->create_links();
		$data['pageid'] = $this->uri->segment(3)?$this->uri->segment(3):'1';
		$this->load->view('admin/crawler/keyset_list', $data);
		$this->load->view('admin/_foot');
		$this->load->view('admin/_footer');
	}



	public function crawler_keyset_update(){
		header("Content-Type: text/html; charset=UTF-8");
    	if($this->Member_model->is_admin){
    		$validation_conf = array(
	        	array('field' => 'mode', 'label' => '실행 정보', 'rules' => 'required'),
				array('field' => 'keyword_set_category', 'label' => '카테고리 인덱스', 'rules' => 'required|numeric'),
				array('field' => 'keyword_set_index', 'label' => '해당 인덱스', 'rules' => 'required|numeric'),
				array('field' => 'keyword_set_title', 'label' => '대표 단어', 'rules' => 'required')
	        );

    		if($this->input->post('mode') == 'modify') array_push($validation_conf, array('field' => 'keyword_set_id', 'label' => '정보', 'rules' => 'required'));

	        $this->form_validation->set_rules($validation_conf);

	        if($this->form_validation->run() == FALSE){
	        	$msg = explode('</p>', validation_errors()); 
	        	$res = array('code' => 1, 'msg' => strip_tags($msg[0]) );
	        }
	        else{
				$data = array(
					'survey_index' => $this->input->post('keyword_set_index'),
					'keyword_title' => $this->input->post('keyword_set_title'),
					'category_index' => $this->input->post('keyword_set_category'),
					'scope' => $this->input->post('keyword_set_scope'),
					'last_update' => time()
				);

				$keyset_word = array_filter($this->input->post('keyword_set_word'));
				if(count($keyset_word) > 0){
					$data['keyword_list'] = $keyset_word;
				}

				$this->load->model('_admin/Admin_crawler');
				if($this->input->post('mode') == 'modify'){
					$act = $this->Admin_crawler->modify_keyword_set($data, $this->input->post('keyword_set_id'));	
				}else{
					$act = $this->Admin_crawler->add_keyword_set($data);	
				}

				if($act && $this->input->post('mode') == 'modify') {
					$res = array('code' => 100, 'msg' => "정상적으로 수정되었습니다.", '_id' => $this->input->post('keyword_set_id') );
				}else if($act) {
					$res = array('code' => 100, 'msg' => "정상적으로 등록되었습니다." );
				}
				else{
					$res = array('code' => 2, 'msg' => "데이터베이스 연결에 실패하였습니다. 잠시후 시도해주세요." );
				}
			}
			echo json_encode($res);
		}else{
			$res = array('code' => 3, 'msg' => "권한이 없습니다." );
			echo json_encode($res);
		}
	}

	public function crawler_keyset_delete(){
		header("Content-Type: text/html; charset=UTF-8");
    	if($this->Member_model->is_admin){
    		$validation_conf = array(
	        	array('field' => 'mode', 'label' => '실행 정보', 'rules' => 'required'),
				array('field' => 'keyword_set_id', 'label' => '정보', 'rules' => 'required')
	        );

	        $this->form_validation->set_rules($validation_conf);

	        if($this->form_validation->run() == FALSE){
	        	$msg = explode('</p>', validation_errors()); 
	        	$res = array('code' => 1, 'msg' => strip_tags($msg[0]) );
	        }
	        else{
				$this->load->model('_admin/Admin_crawler');
				$act = $this->Admin_crawler->delete_keyword_set($this->input->post('keyword_set_id'));	

				if($act) {
					$res = array('code' => 100, 'msg' => "정상적으로 삭제 되었습니다." );
				}
				else{
					$res = array('code' => 2, 'msg' => "데이터베이스 연결에 실패하였습니다. 잠시후 시도해주세요." );
				}
			}
			echo json_encode($res);
		}else{
			$res = array('code' => 3, 'msg' => "권한이 없습니다." );
			echo json_encode($res);
		}
	}



	public function cs_notice(){
		$top_data = array(
			'current' => "cs_notice", 
			'top_menu' => "고객센터", 
			'nav_title' => "공지사항", 
			'nav_subtitle' => "notice",
			'menu1' => 6,
			'menu2' => 1
		);
		$this->board_list($top_data);
	}


	public function cs_notice_edit(){
		$top_data = array(
			'current' => "cs_notice", 
			'top_menu' => "고객센터", 
			'nav_title' => "공지사항", 
			'nav_subtitle' => "notice",
			'menu1' => 6,
			'menu2' => 1
		);
		$this->board_edit($top_data);
	}




	public function cs_faq(){
		$top_data = array(
			'current' => "cs_faq", 
			'top_menu' => "고객센터", 
			'nav_title' => "자주묻는 질문", 
			'nav_subtitle' => "faq",
			'menu1' => 6,
			'menu2' => 2
		);
		$this->board_list($top_data);
	}


	public function cs_faq_edit(){
		$top_data = array(
			'current' => "cs_faq", 
			'top_menu' => "고객센터", 
			'nav_title' => "자주묻는 질문", 
			'nav_subtitle' => "faq",
			'menu1' => 6,
			'menu2' => 2
		);
		$this->board_edit($top_data);
	}




	public function board_list($top_data){
		$this->load->model('_admin/Admin_cs');
		$this->load->view('admin/_header', $this->Core->common_data);
		$this->load->view('admin/_top', $top_data);

		$aside_data = $this->Core->common_data;
		$aside_data['menu1'] = $top_data['menu1']; // 1차 카테고리
		$aside_data['menu2'] = $top_data['menu2']; // 1차 카테고리
		$this->load->view('admin/_aside', $aside_data);

		// 컨텍츠 영역 준비
		$nowpage = $this->uri->segment(3)?$this->uri->segment(3):1;
		$limits = 10;

		$data = $top_data;
		$data['list'] = $this->Admin_cs->board_list($top_data['current'], ($nowpage-1)*$limits, $limits);
		// 페이지네이션
		$this->load->library('pagination');
		$config['base_url'] = '/admin/'.$top_data['current'].'/';
		$config['total_rows'] = $data['list']['all_num'];
		$config['per_page'] = $limits;
		$this->pagination->initialize($config);
		$data['pagin'] = $this->pagination->create_links();
		$data['pageid'] = $this->uri->segment(3)?$this->uri->segment(3):'1';
		$this->load->view('admin/cs/board_list', $data);
		$this->load->view('admin/_foot');
		$this->load->view('admin/_footer');
	}



	public function board_edit($top_data)
	{

		$this->load->model('_admin/Admin_cs');
		$this->load->view('admin/_header', $this->Core->common_data);

		$this->load->view('admin/_top', $top_data);

		$aside_data = $this->Core->common_data;
		$aside_data['menu1'] = '6'; // 1차 카테고리
		$aside_data['menu2'] = '1'; // 2차 카테고리
		$this->load->view('admin/_aside', $aside_data);

		// 컨텐츠 영역 준비
		$data = $top_data;
		$data['seq'] = $seq = $this->uri->segment(3);
		$data['mode'] = $seq?'edit':'new';
		$data['bbsid'] = $top_data['current'];

		$this->load->model('_admin/Admin_survey');
		$data['data'] = $this->Admin_cs->get_board_data($data['seq']);
		
		$post = $this->input->post();
		if(isset($post['seq']) && $post['seq'] && isset($post['mode']) && $post['mode'] == 'edit'){
			$this->Admin_cs->board_update($post);
			$data['data'] = $this->Admin_cs->get_board_data($data['seq']);
		}elseif(isset($post['mode']) && $post['mode']='new'){
			$this->Admin_cs->board_write($top_data['current'], $post);
			redirect('admin/'.$top_data['current']);
		}
		$this->load->view('admin/cs/board_edit', $data);		
		$this->load->view('admin/_foot');
		$this->load->view('admin/_footer');

	}

	public function board_delete(){
		$this->load->model('_admin/Admin_cs');
		$seq = $this->input->post('seq');
		if($this->Admin_cs->board_delete($seq)){
			$res = array('code' => 100, 'msg' => '삭제가 완료되었습니다.' );
		} else {
			$res = array('code' => 1, 'msg' => '처리 실패' );
		} 
		echo json_encode($res);
	}

}
