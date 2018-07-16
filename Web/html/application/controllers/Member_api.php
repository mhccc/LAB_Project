<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_api extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            header('Content-Type: application/json');
	        $this->form_validation->set_message('required', '{field} 입력은 필수입니다.');
	        $this->form_validation->set_message('matches', '{field} 입력이 확인 입력과 일치하지 않습니다.');
	        $this->form_validation->set_message('is_unique', '이미 가입된 {field}입니다.');
	        $this->form_validation->set_message('numeric', '{field}는 숫자만 입력가능합니다.');
	        $this->form_validation->set_message('valid_email', '{field}의 형식이 올바르지 않습니다.');
	        $this->form_validation->set_message('min_length', '{field}는 최소 {param}자 이상이어야 합니다.');
	        $this->form_validation->set_message('max_length', '{field}는 최대 {param}자 이하이어야 합니다.');
	        $this->form_validation->set_message('greater_than_equal_to', '{field}는 최소 {param} 이상이어야 합니다.');
	        $this->form_validation->set_message('less_than_equal_to', '{field}는 최대 {param} 이하이어야 합니다.');
			$this->load->model('Member_model');
    }



    // 가입된 이메일 조회
    public function check_joined(){
		$validation_conf = array(
		    array('field' => 'email', 'label' => '이메일 주소', 'rules' => 'required|valid_email|is_unique[p_s_mbrdata.email]')
		);
		$this->form_validation->set_rules($validation_conf);
        if ($this->form_validation->run() == FALSE){
        	$msg = explode('</p>', validation_errors()); 
        	$res = array('code' => 1, 'msg' => strip_tags($msg[0]) );
        }
        else{
        	$res = array('code' => 100 );
        }
		echo json_encode($res);
    }


    // 회원가입
	public function join()
	{
		$validation_conf = array(
		        array('field' => 'email', 'label' => '이메일 주소', 'rules' => 'required|valid_email|is_unique[p_s_mbrdata.email]'),
		        array('field' => 'pw', 'label' => '비밀번호', 'rules' => 'required|min_length[8]|max_length[20]'),
		        array('field' => 'pw_confirm', 'label' => '비밀번호 확인', 'rules' => 'required|matches[pw]'),
		        array('field' => 'tel', 'label' => '휴대폰 번호', 'rules' => 'required|numeric|min_length[8]|max_length[20]'),
		        array('field' => 'name', 'label' => '이름', 'rules' => 'required|min_length[3]|max_length[20]')
		);

		$this->form_validation->set_rules($validation_conf);
        if ($this->form_validation->run() == FALSE){
        	$msg = explode('</p>', validation_errors()); 
        	$res = array('code' => 1, 'msg' => strip_tags($msg[0]) );
        }
        else{
        	$fdata = $_POST;
        	$data = array(
			        'is_admin' => 'N',
			        'auth' => '1',
			        'email' => $fdata['email'],
			        'pw' => $fdata['pw'],
			        'name' => $fdata['name'],
			        'nic' => $fdata['name'],
			        'tel1' => $fdata['tel'],
			        'tel2' => $fdata['tel'],
			        'd_modify' => date('YmdHis'),
			        'd_regis' => date('YmdHis')
			);

			$insert = $this->Member_model->addUser($data);
			if($insert) $res = array('code' => 100, 'msg' => "가입이 정상적으로 진행되었습니다. 로그인 후 서비스 이용이 가능합니다." );
				else $res = array('code' => 2, 'msg' => "가입에 실패하였습니다. 잠시후 시도해주세요." );
        } 
		echo json_encode($res);
	}


	// 회원 로그인 처리
	public function login_check(){

		$data = $_POST;
		$validation_conf = array(
		        array('field' => 'email', 'label' => '이메일 주소', 'rules' => 'required|valid_email'),
		        array('field' => 'pw', 'label' => '비밀번호', 'rules' => 'required')
		);
		$this->form_validation->set_rules($validation_conf);

        if ($this->form_validation->run() == FALSE){
        	$msg = explode('</p>', validation_errors()); 
        	$res = array('code' => 1, 'msg' => strip_tags($msg[0]) );
        }else{
        	if($this->Member_model->login($data)) $res = array('code' => 100);
        		else $res = array('code' => 2, 'msg' => "로그인에 실패하였습니다." );
        }
		echo json_encode($res);
	}


	// 회원 정보 업데이트
	public function info_update(){
		$this->load->model('Member_model');
        $this->load->library('form_validation');

		$validation_conf = array(
		        array('field' => 'pw', 'label' => '비밀번호', 'rules' => 'required|max_length[20]'),
		        array('field' => 'change_pw', 'label' => '비밀번호', 'rules' => 'min_length[8]|max_length[20]'),
		        array('field' => 'change_pw_confirm', 'label' => '비밀번호', 'rules' => 'min_length[8]|max_length[20]|matches[change_pw]'),
		        array('field' => 'tel', 'label' => '휴대폰 번호', 'rules' => 'required|numeric|min_length[8]|max_length[20]'),
		        array('field' => 'name', 'label' => '이름', 'rules' => 'required|min_length[3]|max_length[20]')
		);
		$this->form_validation->set_rules($validation_conf);

		// 폼 검사후 문제 있다면 출력
        if ($this->form_validation->run() == FALSE){
        	$msg = explode('</p>', validation_errors()); 
        	$res = array('code' => 1, 'msg' => strip_tags($msg[0]) );
        }else{

			// 로그인 체크
			if(!$this->Member_model->is_logged){
				$res = array('code' => 1, 'msg' => "로그인이 필요합니다." );
			}else{
				// 넘어온 POST 값으로 업데이트
				$act = $this->Member_model->updateUser($this->Member_model->my['uid'], $_POST);
				if(isset($act['code']) && $act['code']=='100'){
					$res = array('code' => 100, 'msg' => "회원님의 정보가 변경되었습니다.");
				}elseif(isset($act['code']) && $act['code']=='101'){
					$this->Member_model->logout();
					$res = array('code' => 101, 'msg' => "회원님의 정보가 변경되었습니다. 암호가 변경되었으므로, 다시 로그인 후 이용해주세요.");
				}else{
					$res = array('code' => 0, 'msg' => (isset($act['msg'])?$act['msg']:"에러가 발생하였습니다."));
				}
			}
        }
        echo json_encode($res);
	}












	// 회원 비밀번호 찾기
	public function find(){

		$ldata = $_POST;
		$validation_conf = array(
		        array('field' => 'user_id', 'label' => '이메일 주소', 'rules' => 'required|valid_email'),
		        array('field' => 'user_tel', 'label' => '연락처', 'rules' => 'required|min_length[8]|numeric'),
		        array('field' => 'user_name', 'label' => '이름', 'rules' => 'required')
		);
		$this->form_validation->set_rules($validation_conf);

        if ($this->form_validation->run() == FALSE){
        	$msg = explode('</p>', validation_errors()); 
        	$res = array('code' => 1, 'msg' => strip_tags($msg[0]) );
        }else{
        	$res = $this->Member_model->find_mail($ldata);
        }

		echo json_encode($res);
	}

	// 비밀번호 찾기 인증
	public function find_pw(){
		$validation_conf = array(
		        array('field' => 'auth_key', 'label' => '인증키', 'rules' => 'required'),
		        array('field' => 'change_pw', 'label' => '비밀번호', 'rules' => 'min_length[8]|max_length[20]'),
		        array('field' => 'pw_confirm', 'label' => '비밀번호', 'rules' => 'min_length[8]|max_length[20]|matches[change_pw]')
		);
		$this->form_validation->set_rules($validation_conf);

		// 폼 검사후 문제 있다면 출력
        if ($this->form_validation->run() == FALSE){
        	$msg = explode('</p>', validation_errors()); 
        	$res = array('code' => 1, 'msg' => strip_tags($msg[0]) );
        }else{

			// 넘어온 POST 값으로 업데이트
        	$fdata = $this->input->post();
			$this->db->where('auth_key', $fdata['auth_key']);
			$this->db->where('status', 'N');
			$query = $this->db->get('member_mailfind');
			if($query->num_rows() > 0){
	        	$seq = $query->row()->m_seq;
				$act = $this->Member_model->updateUserPw($seq, $fdata['change_pw']);
				$res = array('code' => 100, 'msg' => "회원님의 암호가 변경되었습니다.");	
			}else{
				$res = array('code' => 0, 'msg' => "에러가 발생하였습니다.");
			}
        }
        echo json_encode($res);
	}
	
}
