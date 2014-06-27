<?php
class Report_Approve extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('approve_model');
		$this->load->helper('myfunction');
		$this->load->helper('general');
		$this->load->helper('menu');
		
		Accesscontrol_helper::is_logged_in();
	}
	
	public function index()
	{
		$data["title"] = "สรุปภาพรวมการขออนุมัติ";
		$data["path"] = array("งานการเงิน","ขออนุมัติใช้งบประมาณ","สรุปภาพรวมการขออนุมัติ");
		$data["submenu"] = Finance_menu(1);
		$this->template->load('template', 'report_approve_view', $data);
	}
	
	public function get()
	{
		 $where = isset($_POST['budget_main_id']) ? mysql_real_escape_string($_POST['budget_main_id']) : '';
		 $result['rows'] = $this->approve_model->approve_plans_report($where);
		
		 header('Content-type: application/json');
         echo json_encode($result);
		 
		//dump($result['rows']);
	   //$this->output->enable_profiler(TRUE);
	}
	
	public function get_detail($budget_main_ID, $mgt_plans_ID)
	{
		 $result['rows'] = $this->approve_model->approve_costs_report($budget_main_ID, $mgt_plans_ID);
		 
		 //dump($result['rows']);
		 header('Content-type: application/json');
         echo json_encode($result);
		 
	}
	

}