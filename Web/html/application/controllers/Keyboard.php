<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keyboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		header("Content-Type: text/html; charset=UTF-8");
    }
    
	public function index()
	{
		$data = array(
			"type" => "text"
		);
		echo json_encode($data);
	}
}
