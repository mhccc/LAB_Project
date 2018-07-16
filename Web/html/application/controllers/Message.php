<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		header("Content-Type: text/html; charset=UTF-8");
    }
    
	public function index()
	{
		$data = array(
			"message" => array(
			    "text" => "귀하의 차량이 성공적으로 등록되었습니다. 축하합니다!",
			    "photo" => array(
					"url" => "https =>//photo.src",
					"width" => 640,
					"height" => 480
		    	),
			    "message_button" => array(
					"label" => "주유 쿠폰받기",
					"url" => "https =>//coupon/url"
				)
			),
		"keyboard" => array(
			"type" => "buttons",
			"buttons" => array(
				"처음으로",
				"다시 등록하기",
				"취소하기"
				)
  			)
		);
		echo json_encode($data);
	}
}
