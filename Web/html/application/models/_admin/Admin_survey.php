<?php 
class Admin_survey extends CI_Model {
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
	public function survey_list($indexs=0, $limits=10 , $orderby='desc'){
		$this->db->order_by('seq', $orderby);
		$query = $this->db->get('survey_data', $limits, $indexs);
		$res = array('code' => 0, 'all_num' => $this->count_all_list(), 'num' => 0, 'data' => array());
		if($query->num_rows() > 0){
			foreach ($query->result_array() as $row)
			{
				$tmp = $row;
				$tmp['serial'] = $this->get_serial($tmp['seq']);
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
		$this->db->where('seq', $seq);
		$query = $this->db->get('survey_data');
		if($query){
			$data = $query->row_array();
			$data['code'] = 100;
			return $data;
		} else return array('code' => 0);
	}


	// 직렬화 데이터 출력
	public function get_serial($seq){
		$this->db->where('seq', $seq);
		$query = $this->db->get('survey_data');
		if($query){
			$data = $query->row_array();
			$serial = sprintf('%010d', $data['seq']); // 0~9
			$serial .= sprintf('%01d', $data['gender']); // 10
			$serial .= sprintf('%02d', (date('Y')-$data['birth_year']+1)/10); // 11~12
			$serial .= sprintf('%01d', $data['day_meal']); // 13
			$serial .= enumToInt($data['meal_regular']); // 14
			$serial .= sprintf('%01d', $data['meal_after8']); // 15
			$serial .= sprintf('%01d', $data['meal_after8_often']); // 16
			$serial .= sprintf('%01d', $data['drink_often']); // 16 음주 횟수
			$serial .= sprintf('%03d', $data['drink_many']/100); // 17 ~ 19 음주 횟수
			$serial .= sprintf('%02d', $data['smoke']); // 20 흡연 유무
			$serial .= "00"; // 21~22 흡연 기간
			$serial .= "00"; // 23~24 하루 흡연 개피수
			$serial .= "00"; // 25~26 현재 흡연량
			$serial .= sprintf('%01d', $data['high_many']); // 27 고강도 운동
			$serial .= sprintf('%01d', $data['low_many']); // 28 저강도 운동
			$serial .= enumToInt($data['hypertension']); // 29 고혈압 여부
			$serial .= enumToInt($data['diabetes']); // 30 당뇨 여부
			$serial .= enumToInt($data['liver_cancer']); // 31 간암 여부
			$serial .= enumToInt($data['gastric_cancer']); // 32 위암 여부
			$serial .= enumToInt($data['lung_cancer']); // 33 폐암 여부
			$serial .= enumToInt($data['thyroid_cancer']); // 34 갑상선암 여부
			$serial .= enumToInt($data['breast_cancer']); // 35 유방암 여부
			$serial .= enumToInt($data['etc_cancer']); // 36 기타암 여부
			return $serial;
		} else return false;
	}




}
?>