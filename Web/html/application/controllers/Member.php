<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {

	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function join_agree()
	{
		$header_data = $this->Core->common_data;
		$header_data['group_num'] = 3;
		$header_data['menu_num'] = 0;
		$header_data['page_menu'] = $this->Core->get_menus($header_data['group_num'], $header_data['menu_num']);
		$this->load->view('_cross/_header', $header_data);
		$this->load->view('member/join/agree');
		$this->load->view('_cross/_footer');
	}
	public function join()
	{
		$header_data = $this->Core->common_data;
		$header_data['group_num'] = 3;
		$header_data['menu_num'] = 1;
		$header_data['page_menu'] = $this->Core->get_menus($header_data['group_num'], $header_data['menu_num']);
		$this->load->view('_cross/_header', $header_data);
		$this->load->view('member/join/form');
		$this->load->view('_cross/_footer');
	}
	public function login()
	{
		$header_data = $this->Core->common_data;
		$header_data['group_num'] = 3;
		$header_data['menu_num'] = 2;
		$header_data['page_menu'] = $this->Core->get_menus($header_data['group_num'], $header_data['menu_num']);
		$this->load->view('_cross/_header', $header_data);
		$data['referer'] = $this->input->get('referer');
		$this->load->view('member/login', $data);
		$this->load->view('_cross/_footer');
	}

	public function info()
	{
		$this->Member_model->__only_member__();
		$header_data = $this->Core->common_data;
		$header_data['group_num'] = 3;
		$header_data['menu_num'] = 3;
		$header_data['page_menu'] = $this->Core->get_menus($header_data['group_num'], $header_data['menu_num']);
		$this->load->view('_cross/_header', $header_data);
		$this->load->view('member/info/form', $this->Core->common_data);
		$this->load->view('_cross/_footer');
	}

	public function logout(){
		$this->Member_model->logout();
		redirect('/member/login');
	}

}
