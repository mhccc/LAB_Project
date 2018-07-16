<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cs extends CI_Controller {

	public function index()
	{
		$this->main();
	}

	private function board_list($bbsid, $header_data)
	{
		$this->load->model('Cs_model');

		$header_data['page_menu'] = $this->Core->get_menus($header_data['group_num'], $header_data['menu_num']);
		$this->load->view('_cross/_header', $header_data);
		$this->load->view('_cross/_header_sub', $header_data);

		// 컨텍츠 영역 준비
		$nowpage = $this->uri->segment(3)?$this->uri->segment(3):1;
		$limits = 15;

		$data = $header_data;
		$data['list'] = $this->Cs_model->board_lists($bbsid, ($nowpage-1)*$limits, $limits);
		// 페이지네이션
		$this->load->library('pagination');
		$config['base_url'] = '/'.$header_data['url_list'];
		$config['total_rows'] = $data['list']['all_num'];
		$config['per_page'] = $limits;
		$this->pagination->initialize($config);
		$data['pagin'] = $this->pagination->create_links();
		$data['pageid'] = $this->uri->segment(3)?$this->uri->segment(3):'1';

		$this->load->view('board/list', $data);


		$this->load->view('_cross/_footer_sub');
		$this->load->view('_cross/_footer');
	}

	private function board_view($seq, $header_data)
	{
		$this->load->model('Cs_model');

		$header_data['page_menu'] = $this->Core->get_menus($header_data['group_num'], $header_data['menu_num']);
		$this->load->view('_cross/_header', $header_data);
		$this->load->view('_cross/_header_sub', $header_data);

		$data = $header_data;
		$data['data'] = $this->Cs_model->get_board_data($seq);
		$this->load->view('board/view', $data);

		$this->load->view('_cross/_footer_sub');
		$this->load->view('_cross/_footer');
	}

	public function notice()
	{

		$header_data = $this->Core->common_data;
		$header_data['group_num'] = 2;
		$header_data['menu_num'] = 0;
		$header_data['url_list'] = 'cs/notice';
		$this->board_list('cs_notice', $header_data);
	}

	public function notice_view()
	{

		$header_data = $this->Core->common_data;
		$header_data['group_num'] = 2;
		$header_data['menu_num'] = 0;
		$header_data['url_list'] = 'cs/notice';
		$this->board_view($this->uri->segment(3), $header_data);
	}


	public function faq()
	{

		$header_data = $this->Core->common_data;
		$header_data['group_num'] = 2;
		$header_data['menu_num'] = 1;
		$header_data['page_menu'] = $this->Core->get_menus($header_data['group_num'], $header_data['menu_num']);
		$this->load->view('_cross/_header', $header_data);
		$this->load->view('_cross/_header_sub', $header_data);
		$data = array();
		$this->load->model('Cs_model');
		$data['lists'] = $this->Cs_model->faq_lists(20, 0);
		$this->load->view('cs/faq', $data);
		$this->load->view('_cross/_footer_sub');
		$this->load->view('_cross/_footer');
	}

	public function policy()
	{

		$header_data = $this->Core->common_data;
		$header_data['group_num'] = 2;
		$header_data['menu_num'] = 2;
		$header_data['page_menu'] = $this->Core->get_menus($header_data['group_num'], $header_data['menu_num']);
		$this->load->view('_cross/_header', $header_data);
		$this->load->view('_cross/_header_sub', $header_data);
		$data = array();
		$this->load->view('cs/policy', $data);
		$this->load->view('_cross/_footer_sub');
		$this->load->view('_cross/_footer');
	}

	public function qna()
	{

		$header_data = $this->Core->common_data;
		$header_data['group_num'] = 2;
		$header_data['menu_num'] = 3;
		$header_data['page_menu'] = $this->Core->get_menus($header_data['group_num'], $header_data['menu_num']);
		$this->load->view('_cross/_header', $header_data);
		$this->load->view('_cross/_header_sub', $header_data);
		if($this->uri->segment(3)){
			$data = array();
			$this->load->view('cs/qna_view', $data);
		}else{
			$data = array('pageNum'=>1);
			$this->load->view('cs/qna_list', $data);
		}
		$this->load->view('_cross/_footer_sub');
		$this->load->view('_cross/_footer');
	}
}
?>