<?php
class Survey_model extends CI_Model {

	public function __construct(){
			parent::__construct();
	}


	// 직렬화 데이터 출력 (중복이라 추후 관리자 모델이랑 안정화 작업시 통합 예정)
	public function get_survey_serial($seq){
		$this->db->where('seq', $seq);
		$query = $this->db->get('survey_data');
		if($query){
			$data = $query->row_array();
			$serial = sprintf('%010d', $data['seq']); // 0~9 설문 고유번호
			$serial .= sprintf('%01d', $data['gender']); // 10 성별
			$serial .= sprintf('%01d', (date('Y')-$data['birth_year']+1)/10); // 11 나이대
			$serial .= sprintf('%01d', $data['day_meal']); // 12 끼니수
			$serial .= enumToInt($data['meal_regular']); // 13 규칙적 식사
			$serial .= sprintf('%01d', $data['meal_after8']); // 14 야식
			$serial .= sprintf('%01d', $data['drink_often']); // 15 음주횟수

			// 과음 기준은 2리터로 임시 처리
			if($data['drink_many'] > 2000) $drink_many = 1;
			else $drink_many = 0;
			$serial .= sprintf('%01d', $drink_many); // 16 과음여부 +++++
			$serial .= sprintf('%01d', $data['smoke']); // 17 흡연 유무 +++++
			$serial .= sprintf('%02d', $data['high_many']); // 18~19 유산소
			$serial .= sprintf('%02d', $data['low_many']); // 20~21 무산소
			$serial .= enumToInt($data['hypertension']); // 22 고혈압 여부
			$serial .= enumToInt($data['diabetes']); // 23 당뇨 여부
			$serial .= enumToInt($data['liver_cancer']); // 24 간암 여부
			$serial .= enumToInt($data['gastric_cancer']); // 25 위암 여부
			$serial .= enumToInt($data['lung_cancer']); // 26 폐암 여부
			$serial .= enumToInt($data['thyroid_cancer']); // 27 갑상선암 여부
			$serial .= enumToInt($data['breast_cancer']); // 28 유방암 여부
			$serial .= enumToInt($data['etc_cancer']); // 29 기타암 여부
			return $serial;
		} else return false;
	}


	// 진단 추가
	public function addData($data){
		return $this->db->insert('survey_data', $data);
	}

	
	// 나의 진단 내역 목록
	public function get_survey_list($user_seq,  $limits=20, $offsets=0){
		$this->db->where('user_seq', $user_seq);
		$this->db->order_by('seq DESC');
		return $this->db->get('survey_data', $limits, $offsets)->result_array();
	}

	// 나의 진단 내역 목록
	public function get_survey_select($user_seq){
		$this->db->where('seq', $user_seq);
		return $this->db->get('survey_data')->row_array();
	}


	// 나의 진단 내역 내용
	public function get_survey_detail($survey_seq){
		// 직렬화 설문 정보 담기
		$serial_string = $this->get_survey_serial($survey_seq);

		// 카테고리 요청 정보 담기(임시 다 1)
		$category_string = '11111111';

		return $this->get_contents($serial_string, $category_string);
	}


	// 설문 결과 링크 연겨랳서 콘텐츠 가져오기
	public function get_contents($survey_str, $cate_str){
		$keyword_title_set = array(); // 설문 기반으로 뽑아낸 keyword_title_id 들의 모임
		$res['keyword_set'] = array(); // keyword_title_id 들로 불러온
		$result = array(); // 결과 조회

		$this->mongo_db->order_by(array('survey_index'=>'asc'));
    	$que1 = $this->mongo_db->get('keyword_set');

		if(count($que1) > 0){
			$res['code'] = 100;
			$tmp = array();
			$tmp_arr = array();
			$tmp_arr2 = array();
			foreach ($que1 as $row)
			{
				// 키워드 셋에서 키워드 타이틀 뽑아서 $keyword_title_set 변수에 모음
				if(substr($row['scope'], 0,2) == "==" && substr($survey_str, $row['survey_index'], $this->stringSpace[$row['survey_index']]) == substr($row['scope'], 2)) {
					$tmp = array('_id' => $row['_id'], 'keyword_title' => $row['keyword_title'] , 'oper' => substr($row['scope'], 2)."==".substr($survey_str, $row['survey_index'], $this->stringSpace[$row['survey_index']]));
					$tmp_arr['data'][] = $tmp;
				} else if(substr($row['scope'], 0,2) == ">=" && substr($survey_str, $row['survey_index'], $this->stringSpace[$row['survey_index']]) >= substr($row['scope'], 2)){
					$tmp = array('_id' => $row['_id'], 'keyword_title' => $row['keyword_title'], 'oper' => substr($row['scope'], 2).">=".substr($survey_str, $row['survey_index'], $this->stringSpace[$row['survey_index']]));
					$tmp_arr['data'][] = $tmp;
				} else if(substr($row['scope'], 0,2) == "<=" && substr($survey_str, $row['survey_index'], $this->stringSpace[$row['survey_index']]) <= substr($row['scope'], 2)){
					$tmp = array('_id' => $row['_id'], 'keyword_title' => $row['keyword_title'] , 'oper' => substr($row['scope'], 2)."<=".substr($survey_str, $row['survey_index'], $this->stringSpace[$row['survey_index']]));
					$tmp_arr['data'][] = $tmp;
				}



			}
		}else{
			$res['code'] = 1;
			$res['msg'] = '마지막 목록입니다.';
		}

		// $keyword_title_set 에 담겨있는 대표 키워드 object_id로 페이지 렝크 담기
			foreach ($tmp_arr['data'] as &$val) {
				$this->mongo_db->where(array('keyword_title_id'=>$val['_id']));
		    	$que2 = $this->mongo_db->get('pagerank');
		    	foreach ($que2 as &$val2) {
		    		$que2['category'] = 1;
		    		$que2['keyword_title'] = $val['keyword_title'];
		    		if(isset($val2['new1_id'])) $val2['new1_id'] = $this->objectToLink($val2['new1_id']);
		    		if(isset($val2['new2_id'])) $val2['new2_id'] = $this->objectToLink($val2['new2_id']);
		    		if(isset($val2['top1_id'])) $val2['top1_id'] = $this->objectToLink($val2['top1_id']);
		    		if(isset($val2['top2_id'])) $val2['top2_id'] = $this->objectToLink($val2['top2_id']);
		    		if(isset($val2['top3_id'])) $val2['top3_id'] = $this->objectToLink($val2['top3_id']);
		    		if(isset($val2['top4_id'])) $val2['top4_id'] = $this->objectToLink($val2['top4_id']);
		    		if(isset($val2['top5_id'])) $val2['top5_id'] = $this->objectToLink($val2['top5_id']);
		    		if(isset($val2['ran1_id'])) $val2['ran1_id'] = $this->objectToLink($val2['ran1_id']);
		    		if(isset($val2['ran2_id'])) $val2['ran2_id'] = $this->objectToLink($val2['ran2_id']);
		    		unset($val2['_id'], $val2['keyword_title_id']);
		    	}
		    	$res['keyword_set'][] = $que2;
			}


		return $res;
	}

	// 설문 string 인덱스별 글자수
	private $stringSpace = array(0 => 10, 10 => 1, 11 => 1, 12 => 1, 13 => 1, 14 => 1, 15 => 1, 16 => 1, 17 => 1, 18 => 2, 20 => 2, 22 => 1, 23 => 1, 24 => 1, 25 => 1, 26 => 1, 27 => 1, 28 => 1, 29 => 1);

	// objectID로 link 컬렉션에서 찾아 반환
	private function objectToLink($keyword_title_id){
		$this->mongo_db->where(array('_id'=>$keyword_title_id));
		if($this->mongo_db->count('link') > 0){
			$this->mongo_db->where(array('_id'=>$keyword_title_id));
	    	$que = $this->mongo_db->get('link');
	    	foreach ($que as &$val) {
	    		unset($val['_id']);
	    	}
		}else{
			$que = array();	
		}
    	return $que;
	}



}
?>