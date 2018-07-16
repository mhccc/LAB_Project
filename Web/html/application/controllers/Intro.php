<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Intro extends CI_Controller {

	public function index()
	{
		$this->main();
	}

	public function main()
	{

		$header_data = $this->Core->common_data;
		$header_data['group_num'] = 0;
		$header_data['menu_num'] = 0;
		$header_data['page_menu'] = $this->Core->get_menus($header_data['group_num'], $header_data['menu_num']);
		$this->load->view('_cross/_header', $header_data);
		$this->load->view('home/intro');
		$this->load->view('_cross/_footer');
	}
}
?>