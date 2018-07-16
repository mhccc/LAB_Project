<?php
class Cs_model extends CI_Model {

	public function __construct(){
			parent::__construct();
	}

	// 모든 게시글 수
	private function count_all_list($bbsid=''){
		if($bbsid){
			$this->db->where('bbsid', $bbsid);
		}
		$this->db->from('p_s_board');
		return $this->db->count_all_results();
	}


	// 나의 진단 내역 목록
	public function board_lists($bbsid, $indexs=0, $limits=10 , $orderby='desc'){
		$this->db->select('seq, title, hit, d_regis');
		$this->db->where('bbsid', $bbsid);
		$this->db->order_by('seq', $orderby);
		$lists = $this->db->get('p_s_board', $limits, $indexs)->result_array();
		return $res = array('data' => $lists, 'all_num' => $this->count_all_list($bbsid) );
	}


	// 관리자용
	public function get_board_data($seq){
		$this->db->where('seq', $seq);
		$query = $this->db->get('p_s_board');
		if($query && $seq){
			$data = $query->row_array();
			$data['code'] = 100;
			return $data;
		} else return array('code' => 0);
	}


	// 나의 진단 내역 목록
	public function faq_lists($indexs=0, $limits=10 , $orderby='desc'){
		$this->db->where('bbsid', 'cs_faq');
		$this->db->order_by('seq', $orderby);
		return $this->db->get('p_s_board', $limits, $indexs)->result_array();
	}


}
?>