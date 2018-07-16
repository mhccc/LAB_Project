<?php 
class Admin_cs extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

	// 모든 게시글 수 (관리자용)
	private function count_all_list($bbsid=''){
		if($bbsid){
			$this->db->where('bbsid', $bbsid);
		}
		$this->db->from('p_s_board');
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
	public function board_list($bbsid, $indexs=0, $limits=10 , $orderby='desc'){
		$this->db->where('bbsid', $bbsid);
		$this->db->order_by('seq', $orderby);
		$query = $this->db->get('p_s_board', $limits, $indexs);
		$res = array('code' => 0, 'all_num' => $this->count_all_list($bbsid), 'num' => 0, 'data' => array());
		if($query->num_rows() > 0){
			foreach ($query->result_array() as $row)
			{
				$tmp = $row;
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
	public function get_board_data($seq){
		$this->db->where('seq', $seq);
		$query = $this->db->get('p_s_board');
		if($query && $seq){
			$data = $query->row_array();
			$data['mode'] = 'edit';
			$data['code'] = 100;
			return $data;
		} else return array('code' => 0, 'title' => '', 'contents' => '', 'mode' => 'new');
	}


	// 글쓰기
	public function board_write($bbsid, $data){
		$data['bbsid'] = $bbsid;
		$data['d_regis'] = date('Y-m-d H:i:s');
		$data['d_modify'] = date('Y-m-d H:i:s');

		unset($data['mode']);
		return $this->db->insert('p_s_board', $data);
	}

	// 글수정
	public function board_update($data){
		$data['d_modify'] = date('Y-m-d H:i:s');
		if($data['seq']){
			$this->db->where('seq', $data['seq']);
			unset($data['mode']);
			return $this->db->update('p_s_board', $data);
		} 
	}

	// 글삭제
	public function board_delete($seq){
		$this->db->where('seq', $seq);
		return $this->db->delete('p_s_board');
	}




}
?>