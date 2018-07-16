<?php 
class Admin_crawler extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

	// 키워드셋 총 개수
	private function count_all_list(){
		return $this->mongo_db->count('keyword_set');
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
	public function keyset_list($indexs=0, $limits=10 , $orderby='desc'){
    	$this->mongo_db->order_by(array('index'=>$orderby));
    	$this->mongo_db->offset($indexs);
    	$this->mongo_db->limit($limits);
    	$query = $this->mongo_db->get('keyword_set');

		$res = array('code' => 0, 'all_num' => $this->count_all_list(), 'num' => 0, 'data' => array());
		if(count($query) > 0){
			foreach ($query as $row)
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


	// 키워드셋 추가
	public function add_keyword_set($data){
		return $this->mongo_db->insert('keyword_set', $data);
	}
	// 키워드셋 수정
	public function modify_keyword_set($data, $_id){
		return $this->mongo_db->where(array('_id'=>new MongoId($_id)))->set($data)->update('keyword_set');
		$this->mongo_db->insert('keyword_set', $data);
	}

	// 키워드셋 삭제
	public function delete_keyword_set($_id){
		return $this->mongo_db->where(array('_id'=>new MongoId($_id)))->delete('keyword_set');
		$this->mongo_db->insert('keyword_set', $data);
	}

	// 관리자용
	public function get_keyword_set($_id){
		return $this->mongo_db->where(array('_id'=>new MongoId($_id)))->get('keyword_set');
	}

	private function enumToInt($str){
		switch ($str) {
			case 'Y':
				return 1;
				break;

			case 'N':			
			default:
				return 0;
				break;
		}
	}

}
?>