<?php

class Test extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->helper('myfunction');
		$this->load->helper('general');
		$this->load->helper('menu');
	}
	
	public function index()
	{
		$data["title"] = "สรุปข้อมูลการจัดสรรงบประมาณ";
		$data["path"] = array("งานแผน","รายงาน","สรุปข้อมูลการจัดสรรงบประมาณ");
		$data["submenu"] = Plans_menu(3);
		$this->template->load('template', 'form_view', $data);
		 //print_r(apache_get_modules());
	}
}
