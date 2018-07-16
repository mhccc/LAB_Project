<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survey extends CI_Controller {

	public function index()
	{
		$this->main();
	}

	public function main()
	{

		$header_data = $this->Core->common_data;
		$header_data['group_num'] = 1;
		$header_data['menu_num'] = 0;
		$header_data['page_menu'] = $this->Core->get_menus($header_data['group_num'], $header_data['menu_num']);
		$this->load->view('_cross/_header', $header_data);
		$this->load->view('_cross/_header_sub', $header_data);
		$data['is_logged'] = $this->Member_model->is_logged;
		$this->load->view('survey/main', $data);
		$this->load->view('_cross/_footer_sub');
		$this->load->view('_cross/_footer');
	}

	public function redirect_url(){
		$url = $this->input->get('to');
		$command = escapeshellcmd('python3 /project/update/update_hit.py '.$url);
		$output = shell_exec($command);

        redirect($url);
	}
	public function update_like(){
		$url = $this->input->post('url');
		$command = escapeshellcmd('python3 /project/update/update_pheromone.py '.$url);
		$output = shell_exec($command);
		return $output;
	}

	public function insert(){
		header("Content-Type: text/html; charset=UTF-8");
    	if($this->Member_model->is_logged){
			$this->load->library('form_validation');
    		$this->form_validation->set_message('required', '{field} 입력은 필수입니다.');
    		$validation_conf = array(
	        	array('field' => 'agree', 'label' => '동의', 'rules' => 'required'),
				array('field' => 'birth_year', 'label' => '생년월일(년)', 'rules' => 'required|numeric'),
				array('field' => 'birth_month', 'label' => '생년월일(월)', 'rules' => 'required|numeric'),
				array('field' => 'birth_day', 'label' => '생년월일(일)', 'rules' => 'required|numeric'),
				array('field' => 'gender', 'label' => '성별', 'rules' => 'required'),
				array('field' => 'day_meal', 'label' => '평균 하루 몇 끼 섭취', 'rules' => 'required'),
				array('field' => 'meal_regular', 'label' => '규칙적 식사 여부', 'rules' => 'required'),
				array('field' => 'meal_after8', 'label' => '8시 이후 야식 여부', 'rules' => 'required'),
				array('field' => 'meal_after8_often', 'label' => '야식 주기', 'rules' => 'required'),
				array('field' => 'drink_often', 'label' => '음주 주기', 'rules' => 'required'),
				array('field' => 'drink_many', 'label' => '음주량', 'rules' => 'required|numeric'),
				array('field' => 'smoke', 'label' => '흡연 여부', 'rules' => 'required'),
				array('field' => 'high_many', 'label' => '고강도 운동 시간', 'rules' => 'required|numeric'),
				array('field' => 'low_many', 'label' => '저강도 운동 시간', 'rules' => 'required|numeric'),
				array('field' => 'hypertension', 'label' => '고혈압 여부', 'rules' => 'required'),
				array('field' => 'diabetes', 'label' => '당뇨 여부', 'rules' => 'required'),
				array('field' => 'liver_cancer', 'label' => '간암 여부', 'rules' => 'required'),
				array('field' => 'gastric_cancer', 'label' => '위암 여부', 'rules' => 'required'),
				array('field' => 'lung_cancer', 'label' => '폐암 여부', 'rules' => 'required'),
				array('field' => 'thyroid_cancer', 'label' => '갑상선암 여부', 'rules' => 'required'),
				array('field' => 'breast_cancer', 'label' => '유방암 여부', 'rules' => 'required'),
				array('field' => 'etc_cancer', 'label' => '기타 여부', 'rules' => 'required')
	        );

	        $this->form_validation->set_rules($validation_conf);

	        if($this->form_validation->run() == FALSE){
	        	$msg = explode('</p>', validation_errors()); 
	        	$res = array('code' => 1, 'msg' => strip_tags($msg[0]) );
	        }
	        else{
	        	$fdata = $_POST;
				$data = array(
					'user_seq' => $this->Member_model->my['uid'],
					'birth_year' => $fdata['birth_year'],
					'birth_month' => $fdata['birth_month'],
					'birth_day' => $fdata['birth_day'],
					'gender' => $fdata['gender'],
					'day_meal' => $fdata['day_meal'],
					'meal_regular' => $fdata['meal_regular'],
					'meal_after8' => $fdata['meal_after8'],
					'meal_after8_often' => $fdata['meal_after8_often'],
					'drink_often' => $fdata['drink_often'],
					'drink_many' => $fdata['drink_many'],
					'smoke' => $fdata['smoke'],
					'high_many' => $fdata['high_many'],
					'low_many' => $fdata['low_many'],
					'hypertension' => $fdata['hypertension'],
					'diabetes' => $fdata['diabetes'],
					'liver_cancer' => $fdata['liver_cancer'],
					'gastric_cancer' => $fdata['gastric_cancer'],
					'lung_cancer' => $fdata['lung_cancer'],
					'thyroid_cancer' => $fdata['thyroid_cancer'],
					'breast_cancer' => $fdata['breast_cancer'],
					'etc_cancer' => $fdata['etc_cancer'],
					'date_regis' => date('Y-m-d H:i:s'),
					'date_modify' => date('Y-m-d H:i:s')
				);

				$this->load->model('Survey_model');
				$insert = $this->Survey_model->addData($data);

				if($insert) {
					$res = array('code' => 100, 'msg' => "설문 성공" );
				}
				else{
					$res = array('code' => 2, 'msg' => "데이터베이스 연결에 실패하였습니다. 잠시후 시도해주세요." );
				}
			}
			echo json_encode($res);
		}else{
			$res = array('code' => 3, 'msg' => "로그인 상태가 아닙니다." );
			echo json_encode($res);
		}
	}

	public function mylist()
	{

		$header_data = $this->Core->common_data;
		$header_data['group_num'] = 1;
		$header_data['menu_num'] = 1;
		$header_data['page_menu'] = $this->Core->get_menus($header_data['group_num'], $header_data['menu_num']);
		$this->load->view('_cross/_header', $header_data);
		$this->load->view('_cross/_header_sub', $header_data);
		$data['referer'] = $this->input->get('referer');

		$this->load->model('Survey_model');
		$data['lists'] = $this->Survey_model->get_survey_list($header_data['my']['uid'], 20, 0);

		$this->load->view('survey/mylist', $data);
		$this->load->view('_cross/_footer_sub');
		$this->load->view('_cross/_footer');
	}
	public function mylist_view()
	{

		$header_data = $this->Core->common_data;
		$header_data['group_num'] = 1;
		$header_data['menu_num'] = 1;
		$header_data['page_menu'] = $this->Core->get_menus($header_data['group_num'], $header_data['menu_num']);
		$this->load->view('_cross/_header', $header_data);
		$this->load->view('_cross/_header_sub', $header_data);
		$data['referer'] = $this->input->get('referer');

		$this->load->model('Survey_model');

		$survey_seq = $this->uri->segment(3);


		$data['datas'] = $this->Survey_model->get_survey_select($survey_seq);

		$this->load->view('survey/mylist_view', $data);
		$this->load->view('_cross/_footer_sub');
		$this->load->view('_cross/_footer');
	}

	public function me()
	{

		$header_data = $this->Core->common_data;
		$header_data['group_num'] = 1;
		$header_data['menu_num'] = 2;
		$header_data['page_menu'] = $this->Core->get_menus($header_data['group_num'], $header_data['menu_num']);
		$this->load->view('_cross/_header', $header_data);
		$this->load->view('_cross/_header_sub', $header_data);

		if($this->uri->segment(3)) $this->db->where('seq', $this->uri->segment(3));
		$this->db->where('user_seq', $this->Member_model->my['uid']);
		$this->db->order_by('seq', 'DESC');
		$this->db->limit(1, 0);
		$result = $this->db->get('survey_data');
		if(!$this->Member_model->is_logged){
			$data['code'] = 1;
		}else if ($result->num_rows() <= 0){
			$data['code'] = 2;
		}else{
		    $row = $result->row_array();
			$survey_seq = $row['seq'];
			$this->load->model('Survey_model');
			$data['code'] = 100;
			$data['survey_serial'] = $this->Survey_model->get_survey_serial($survey_seq);
			$data['vote_datas'] = $row;
			$data['datas'] = $this->Survey_model->get_survey_detail($survey_seq);
		}

		$this->load->view('survey/me', $data);
		$this->load->view('_cross/_footer_sub');
		$this->load->view('_cross/_footer');
	}

}
?>