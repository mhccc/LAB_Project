<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {


	public function index()
	{
		print_r('test');
	}

	public function get_category(){
		if($this->uri->segment(3) && $this->uri->segment(4)){
			// This is the data you want to pass to Python
			$command = escapeshellcmd('python3 /project/categoryset/category.py '.$this->uri->segment(3).' '.$this->uri->segment(4));
			$output = shell_exec($command);
			echo json_encode(json_decode(str_replace("'", "\"", $output)));
		}else echo json_encode(array('code' => 10, 'msg' => '없음'));
	}


	public function get_contents(){
		$survey_str = $this->input->get('survey_str'); // 설문 직렬화 번호
		$cate_str = $this->input->get('cate_str'); // 카테고리 번호

		$this->load->model('Survey_model');
		$results = $this->Survey_model->get_contents($survey_str, $cate_str);
		echo json_encode($results);
	}



}
