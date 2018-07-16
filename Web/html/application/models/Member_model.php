<?php
class Member_model extends CI_Model {

	// 모든 페이지에 달아줄 것
	public $is_logged; // 로그인 여부를 담는다.
	public $my; // 로그인 데이터를 닮을 예정
	public $is_admin; // 관리자 여부

	private $mail_headers;

	public function __construct(){
			parent::__construct();
			$this->autologin();
			$this->my = $this->my();
			$this->is_logged = $this->my['logged_in'];
			$this->is_admin = $this->my['is_admin'];
			$this->mail_headers="MIME-Version: 1.0\n".
			"Content-Type: text/html; charset=UTF-8; format=flowed\n".
			"Content-Transfer-Encoding: 8bit\n"; // 헤더 설정
	}



	// 멤버 추가 (가입 성공시 실행)
	public function addUser($data){
		$data['pw'] = md5($data['pw']);
		$data['pw'] = $this->encrypt->encode($data['pw']);
		return $this->db->insert('p_s_mbrdata', $data);
	}


	// 멤버 로그인 처리
	public function login($data){
		$email = $data['email'];
		$pw = md5($data['pw']);
		$autologin = ( isset($data['auto'] ) && ($data['auto'] == '1'))? TRUE : FALSE;

		$this->db->where('email', $email);
		$query = $this->db->get('p_s_mbrdata');
		$row = $query->row();
		

		if($query->num_rows() > 0 && $pw == $this->encrypt->decode($row->pw)){
			$my = array(
		        'seq'  => $row->memberuid,
		        'memberuid'  => $row->memberuid,
		        'name'  => $row->name,
		        'nic'  => $row->nic,
		        'email'     => $row->email,
		        'is_admin'     => $row->is_admin,
		        'logged_in' => TRUE
			);
			$this->session->set_userdata('my', $my);
			if($autologin) {
				$key = $this->encrypt->encode($email."!@!@@".$_SERVER['HTTP_USER_AGENT']."!@!@@".md5($data['pw'])); 
				$cookie = array(
                   'name'   => 'chk_auto',
                   'value'  => $key,
                   'expire' => '0'
               	);
				set_cookie($cookie);
			}
			$this->session->set_userdata('logged', TRUE);
			return TRUE;
		}else{
			return FALSE;
		}
		return $this->db->insert('p_s_mbrdata', $data);
	}


	// 회원별 개인정보 불러오기 (로그인한 회원이 사용)
	public function my(){
		if($this->session->userdata('logged') && $this->session->has_userdata('my')) {
			$mdata = $this->session->userdata('my');
			$this->db->select('memberuid as uid, memberuid, is_admin, nic, email,name,tel2, tel1,d_lastlogin');
			$this->db->where('memberuid', $mdata['memberuid']);
			$res = $this->db->get('p_s_mbrdata')->row_array();
			$res['logged_in'] = TRUE;
		}else{
			$res = array(
				'uid' => NULL, 
				'memberuid' => NULL, 
				'is_admin' => False, 
				'email' => NULL, 
				'tel' => NULL, 
				'logged_in' => False, 
			);
		}
		return $res;
	}



    // 회원이 아니면 알림말 후 로그인 페이지로
    public function __only_member__(){
		if(!$this->is_logged){
			redirect("/member/login/");
		}
    }

    // 회원이 아니면 알림말 후 로그인 페이지로
    public function __only_admin__(){
		if($this->Member_model->my['is_admin']!='Y'){
			redirect("/");
		}
    }


	// 멤버 정보 업데이트 (정보수정)
	public function updateUser($member_seq, $data){
		// 암호가 일치하는지 검사( 나머지는 컨트롤러에서 검사 )
		$this->db->where('memberuid', $member_seq);
		$query = $this->db->get('p_s_mbrdata');
		if ($query->num_rows() <= 0)
		{
			$result_arr = array('code' => 3, 'msg' => '사용자를 구분할 수 없습니다.');
		}else{
		    $user_pw =  $this->encrypt->decode($query->row()->pw);
		    if(md5($data['pw']) == $user_pw && $data['change_pw']){
		    	if($data['change_pw'] == $data['change_pw_confirm']){
			    	$update_data = array(
						'pw' => $this->encrypt->encode(md5($data['change_pw'])), 'name' => $data['name'],
						 'tel1' => $data['tel'], 'tel2' => $data['tel'], 'nic' => $data['nic'] );
					$this->db->where('memberuid', $member_seq);
					$this->db->update('p_s_mbrdata', $update_data);
					$result_arr = array('code' => 101);	
		    	}else{
					$result_arr = array('code' => 3, 'msg' => '새 암호와 암호 확인란이 다릅니다.');
		    	}
		    } elseif(md5($data['pw']) == $user_pw){
			    	$update_data = array( 'name' => $data['name'], 'tel1' => $data['tel'], 'tel2' => $data['tel'], 'nic' => $data['nic'] );
					$this->db->where('memberuid', $member_seq);
					$this->db->update('p_s_mbrdata', $update_data);
				$result_arr = array('code' => 100);
		    }else{
				$result_arr = array('code' => 3, 'msg' => '기존 암호를 잘못 입력하셨습니다.');
		    }
		}

		return $result_arr;
	}



	// 로그아웃
	public function logout(){
		$this->session->set_userdata('logged', FALSE);
		$this->session->unset_userdata('my');
		delete_cookie("chk_auto");
		unset($_SESSION['logged']);
		unset($_SESSION['my']);
		return TRUE;
	}










    public function autologin(){
		if(!$this->session->userdata('logged') && !$this->session->has_userdata('my') && isset($_COOKIE['chk_auto']) && $_COOKIE['chk_auto']){
			$auto_code = explode('!@!@@', $this->encrypt->decode($_COOKIE['chk_auto']));

			// 회원 정보 불러오기
			$this->db->select('*');
			$this->db->where('email', $auto_code[0]);
			$mdatas = $this->db->get('p_s_mbrdata')->row_array();

			// 일치시
			if($auto_code[2] == $this->encrypt->decode($mdatas['pw'])){
				$my = array(
			        'uid'  => $mdatas['seq'],
			        'name'  => $mdatas['name'],
			        'email'     => $mdatas['email'],
			        'is_admin'     => $mdatas['is_admin'],
			        'logged_in' => TRUE
				);
				$this->session->set_userdata('my', $my);
				$this->session->set_userdata('logged', TRUE);
			}

		}
    }


	// 랜덤 문자열
	private function randomString($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	// 인증 메일 전송
	public function send_auth_mail($mseq, $email){
		$this->load->helper('email');

		$random = $this->randomString(60);
		$data = array(
			'm_seq' => $mseq, 
			'auth_key' => $random, 
			'status' => 'N', 
			'date_expired' => date("Y/m/d H:i:s", time()+60*60*24)
		);
		$insert = $this->db->insert('member_mailcheck', $data);
		if($insert){
			$subject = '[인증메일] 에이큐브에 가입하신 것을 환영합니다.';
			$subject = "=?UTF-8?B?".base64_encode($subject)."?=";
			$message = '<html><body>';
			$message .= '<h1 style="color:#f40;">에이큐브 가입을 환영합니다!</h1>';
			$message .= '<a href="'.base_url("member/auth_mail/".$random).'">인증하러가기</a>';
			$message .= '</body></html>';
			return mail($email, $subject, $message, $this->mail_headers);
		}		
	}

	public function auth_mail($auth_key){
		// 메일체크 업데이트 
		$this->db->where('status', 'N');
		$this->db->where('auth_key', $auth_key);
		$act1 = $this->db->update('member_mailcheck', array('status' => 'Y'));
		if(!$act1) return False;
		
		// 회원 정보 업데이트
		$this->db->select('m_seq');
		$this->db->where('auth_key', $auth_key);
		$this->db->where('status', 'Y');
		$query = $this->db->get('member_mailcheck');
		$result = $query->row_array();
		if(!$result['m_seq']) return False;

		// 회원정보 업데이트
		$this->db->where('seq', $result['m_seq']);
		$act2 = $this->db->update('p_s_mbrdata', array('is_mailagree' => 'Y'));
		return $act1 && $act2;
	}



	// 멤버 로그인 처리
	public function find_mail($data){
		define('CRLF', "\r\n");
		$email = $data['user_id'];
		$tel = $data['user_tel'];
		$name = $data['user_name'];
		$random = $this->randomString(60);

		$this->db->where('email', $email);
		$this->db->where('u_tel', $tel);
		$this->db->where('name', $name);
		$query = $this->db->get('p_s_mbrdata');
		$row = $query->row();

		if($query->num_rows() > 0){
			$data = array(
				'm_seq' => $row->seq, 
				'auth_key' => $random, 
				'status' => 'N', 
				'date_expired' => date("Y/m/d H:i:s", time()+60*60*24)
			);
			$insert = $this->db->insert('member_mailfind', $data);

			$subject = '[인증메일] 에이큐브에 암호 찾기 메일입니다.';
			$subject = "=?UTF-8?B?".base64_encode($subject)."?=";
			$message = '<html><body>';
			$message .= '<h1 style="color:#f40;">에이큐브 암호 찾기 메일입니다.</h1>';
			$message .= '<a href="'.base_url("member/find_auth/".$random).'">비밀번호 변경</a>';
			$message .= '</body></html>';
			$act = mail($email, $subject, $message, $this->mail_headers);

			if($act) return $res = array('code' => 100, 'msg' => "본인 메일주소로 암호 변경 메일이 발송되었습니다. 메일을 확인해주세요.");
				else return $res = array('code' => 2, 'msg' => "에러가 발생하였습니다.");

		}else{
			return $res = array('code' => 1, 'msg' => "가입된 정보가 없습니다.");
		}
		return $this->db->insert('p_s_mbrdata', $data);
	}



	public function check_find($auth_key){
		// 메일체크 업데이트 
		$this->db->where('status', 'N');
		$this->db->where('auth_key', $auth_key);
		$query = $this->db->get('member_mailfind');
		if($query->num_rows() > 0){
			return $this->get_data_for_admin($query->row()->m_seq);
		}

	}



	// 멤버 정보 업데이트 (정보수정)
	public function updateUserPw($m_seq, $pw){
		// 암호가 일치하는지 검사( 나머지는 컨트롤러에서 검사 )
		$this->db->where('seq', $m_seq);
		$query = $this->db->get('p_s_mbrdata');
		if ($query->num_rows() > 0)
		{
			$this->db->where('seq', $m_seq);
			if( $this->db->update('p_s_mbrdata', array('pw' => $this->encrypt->encode(md5($pw)))));
				return $this->expiredFindPw($m_seq);
		}
		return false;
	}
	// 암호찾기 다 만료시키기
	public function expiredFindPw($m_seq){
		$this->db->where('m_seq', $m_seq);
		return $this->db->update('member_mailfind', array('status' => 'Y', 'date_expired' => date('Y-m-d H:i:s')));
	}

	// 멤버 정보 업데이트 (정보수정)
	public function updateUser_for_admin($member_seq, $data){
		// 암호가 일치하는지 검사( 나머지는 컨트롤러에서 검사 )
		$this->db->where('memberuid', $member_seq);
		$query = $this->db->get('p_s_mbrdata');
		if ($query->num_rows() <= 0)
		{
			$result_arr = array('code' => 3, 'msg' => '사용자를 구분할 수 없습니다.');
		}else{

			$result_arr = array('code' => 4, 'msg' => 'DB 오류가 발생하였습니다.');	
			$update_data = array( 
				'name' => $data['name'],
				'tel1' => $data['tel'] ,
				'tel2' => $data['tel'] ,
				'modify_ip' => $this->input->ip_address(),
				'modify_seq' => $this->Member_model->my['uid'],
				'admin_memo' => $data['admin_memo']
			);

		    $user_pw =  $this->encrypt->decode($query->row()->pw);

	    	if(trim($data['change_pw']) && $data['change_pw'] == $data['change_pw_confirm']){
		    	$update_data['pw'] = $this->encrypt->encode(md5($data['change_pw']));
		    	$update_data['name'] = $data['name'];
		    	$update_data['tel1'] = $data['tel'];
		    	$update_data['tel2'] = $data['tel'];
			}
			$this->db->where('memberuid', $member_seq);
			$act = $this->db->update('p_s_mbrdata', $update_data);
			if($act) $result_arr = array('code' => 100);	
		}
		return $result_arr;
	}


	// 회원정보 가져오기(회원이 사용하는 기능용)
	public function get_data_for_user(){
			if($this->my['uid']){
				$this->db->where('seq', $this->my['uid']);
				$query = $this->db->get('p_s_mbrdata');
				if($query){
					$data = $query->row_array();
					$data['code'] = 100;
					unset($data['pw']);
				}else{
					$data = array('code' => 2, 'login_status' => False, 'msg' => 'DB연결에 실패하였습니다.');
				}
			}else{
				$data = array('code' => 1, 'login_status' => False, 'msg' => '에러가 발생하였습니다.');
			}
		return $data;
	}

	// 관리자에서 리스트에 필요한 최소한의 데이터
	public function get_simple_data($seq){
		$this->db->where('seq', $seq);
		$query = $this->db->get('p_s_mbrdata')->row_array();
		$res = array(
			'name' => $query['name'],
			'tel' => $query['u_tel'],
			'is_admin' => $query['is_admin']
		);
		return $res;
	}

	// 모든 회원 수 (관리자용)
	private function count_all_list(){
		$this->db->from('p_s_mbrdata');
		return $this->db->count_all_results();
	}
	
	public function admin_member_list($indexs=0, $limits=10 , $orderby='desc'){
		$this->db->order_by('seq', $orderby);
		$query = $this->db->get('p_s_mbrdata', $limits, $indexs);
		$res = array('code' => 0, 'all_num' => $this->count_all_list(), 'num' => 0, 'data' => array());
		if($query->num_rows() > 0){
			foreach ($query->result_array() as $row)
			{
				$tmp = $row;
				unset($tmp['pw']);
				$res['data'][] = $tmp;
			}
				$res['num'] = count($res['data']);
		}else{
			$res['code'] = 1;
			$res['msg'] = '마지막 목록입니다.';
		}
		return $res;
	}


	// 관리자용
	public function get_data_for_admin($seq){
		$this->db->where('seq', $seq);
		$query = $this->db->get('p_s_mbrdata');
		if($query){
			$data = $query->row_array();
			$data['code'] = 100;
			unset($data['pw']);
			return $data;
		} else return false;
	}


	// 글삭제
	public function delete($seq){
		$this->db->where('seq', $seq);
		$data = array('is_out' => 'Y', 'email' => 'out_'.$seq, 'u_tel' => '0', 'name' => '탈퇴회원', 'date_modify' => date('Y-m-d H:i:s'));
		return $this->db->update('p_s_mbrdata', $data);
	}




}
?>