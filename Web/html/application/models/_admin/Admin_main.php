<?php 
class Admin_main extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

	// 모든 게시글 수 (관리자용)
	public function main_view(){
		$res = array('survey' => 0, 'tmp' => 1, 'member' => 2, 'keyword_set' => 3 );
		$res['survey'] = $this->db->count_all('survey_data');
		$res['member'] = $this->db->count_all('p_s_mbrdata');
		$res['keyword_set'] = $this->mongo_db->count('keyword_set');
		return $res;
	}

}
?>