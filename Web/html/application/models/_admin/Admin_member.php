<?php 
class Admin_member extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

	// 모든 회원 수 (관리자용)
	private function count_all_list(){
		$this->db->from('p_s_mbrdata');
		return $this->db->count_all_results();
	}

    // 회원이 아니면 알림말 후 로그인 페이지로
    public function __only_admin__(){
		if(!$this->Member_model->is_logged){
			redirect("/member/login");
		}
		if($this->Member_model->my['is_admin']!='Y'){
			redirect("/");
		}
    }
	
    // 관리자 화면에서 멤버리스트 출력
	public function member_list($indexs=0, $limits=10 , $orderby='desc'){
		$this->db->order_by('memberuid', $orderby);
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
	public function get_data($seq){
		$this->db->where('memberuid', $seq);
		$query = $this->db->get('p_s_mbrdata');
		if($query){
			$data = $query->row_array();
			$data['code'] = 100;
			unset($data['pw']);
			return $data;
		} else return false;
	}



	// 멤버 정보 업데이트 (정보수정)
	public function update_user_data($member_seq, $data){
		// 암호가 일치하는지 검사( 나머지는 컨트롤러에서 검사 )
		$this->db->where('memberuid', $member_seq);
		$query = $this->db->get('p_s_mbrdata');
		if ($query->num_rows() <= 0)
		{
			$result_arr = array('code' => 3, 'msg' => '사용자를 구분할 수 없습니다.');
		}else{

			$result_arr = array('code' => 4, 'msg' => 'DB 오류가 발생하였습니다.');	
			$update_data = array( 
				'name' => $data['name'] ,
				'nic' => $data['nic'] ,
				'tel1' => $data['tel'] ,
				'tel2' => $data['tel'] ,
				'modify_ip' => $this->input->ip_address(),
				'modify_seq' => $this->Member_model->my['uid'],
				'admin_memo' => $data['admin_memo']
			);

	    	if(trim($data['change_pw']) && $data['change_pw'] == $data['change_pw_confirm']){
		    	$update_data['pw'] = $this->encrypt->encode(md5($data['change_pw']));
		    	$update_data['tel1'] = $data['tel'];
		    	$update_data['tel2'] = $data['tel'];
			}
			$this->db->where('memberuid', $member_seq);
			$act = $this->db->update('p_s_mbrdata', $update_data);
			if($act) $result_arr = array('code' => 100, 'msg' => '완료되었습니다.');	
		}
		return $result_arr;
	}



}
?>