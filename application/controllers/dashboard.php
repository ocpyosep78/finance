<?php
class Dashboard extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('dashboard_model');
		$this->load->helper('myfunction');
		$this->load->helper('general');
		$this->load->helper('menu');
		
		Accesscontrol_helper::is_logged_in();
	}
	
	public function index()
	{
		$data["title"] = "Dashboard";
		$data["path"] = array("หน้าหลัก","dashboard");
		$data["submenu"] = array();
		
		$budget_id = $this->session->userdata('budget_year_id');
		$data["arr_pie1"] = $this->get_pie1($budget_id);
		$data["arr_pie2"] = $this->get_pie2($budget_id);
		$data["arr_pie3"] = $this->get_pie3($budget_id);
		$data["arr_pie4"] = $this->get_pie4($budget_id);
		$data["arr_pie5"] = $this->get_pie5($budget_id);
		$data["arr_pie6"] = $this->get_pie6($budget_id);
		
		$data["arr_bar_data1"] = $this->get_approve_barchart($budget_id);
		$data["arr_bar_data2"] = $this->get_payment_barchart($budget_id);
		
		$this->template->load('template', 'dashboard_view',$data);
	}
	
	public function get_pie1($budget_main_id)
	{
		$data = $this->dashboard_model->total_chart($budget_main_id);
		
		$useable = $data[0]["payment"];
		$balance = $data[0]["budget"]-$data[0]["payment"];
		
		$arr = array(array("label" => "ไม่ใช้",  "data" => $balance, "color" => "#4572A7"),
		             array("label" => "ใช้",  "data" => $useable, "color" => "#AA4643"));
		
		return $arr;
		
		//dump($arr);
	    //$this->output->enable_profiler(TRUE);
	    
	}
	
	public function get_pie2($budget_main_id)
	{
		
		$data = $this->dashboard_model->mgt_plan_chart($budget_main_id);
		
		$arr = array();
		$sum = 0.00;
		foreach ($data as $key => $value) {
			$arr[] = array("label" => $value["name"],  "data" => $value["amount"]);
			$sum +=  $value["amount"];
		}
		
		$sum = $this->session->userdata('budget_year_amount') - $sum;
	    $arr[] = array("label" => "ไม่ได้จัดสรร",  "data" => $sum);
		
		return $arr;
		
	//	dump($arr);
	    //$this->output->enable_profiler(TRUE);
	    
	}
	
	public function get_pie3($budget_main_id)
	{
		$data = $this->dashboard_model->approve_plans_chart($budget_main_id);
		
		$arr = array();
		if (count($data) > 0) {
			foreach ($data as $key => $value) {
			   $arr[] = array("label" => $value["name"],  "data" => $value["amount"]);
		   }
		}
		else {
			  $arr[] = array("label" => "ไม่มีการอนุมัติ",  "data" => 100, "color" => "#4572A7");
		}
		
		return $arr;
		
		//dump($data);
	   // $this->output->enable_profiler(TRUE);
	    
	}
	
	public function get_pie4($budget_main_id)
	{
		$data = $this->dashboard_model->payment_plans_chart($budget_main_id);
		
		$arr = array();
		if (count($data) > 0) {
			foreach ($data as $key => $value) {
			   $arr[] = array("label" => $value["name"],  "data" => $value["amount"]);
		   }
		}
		else {
			  $arr[] = array("label" => "ไม่มีการเบิกจ่าย",  "data" => 100, "color" => "#4572A7");
		}
		
		return $arr;
	
		//dump($data);
	   //$this->output->enable_profiler(TRUE);
	    
	}
	
	public function get_pie5($budget_main_id)
	{
		$data = $this->dashboard_model->approve_costs_chart($budget_main_id);
		
		$arr = array();
		if (count($data) > 0) {
			foreach ($data as $key => $value) {
			   $arr[] = array("label" => $value["name"],  "data" => $value["amount"]);
		   }
		}
		else {
			  $arr[] = array("label" => "ไม่มีการอนุมัติ",  "data" => 100, "color" => "#4572A7");
		}
		
		return $arr;
		
		//dump($arr);
	   // $this->output->enable_profiler(TRUE);
	    
	}
	
	public function get_pie6($budget_main_id)
	{
		$data = $this->dashboard_model->payment_costs_chart($budget_main_id);
		
	    $arr = array();
		if (count($data) > 0) {
			foreach ($data as $key => $value) {
			   $arr[] = array("label" => $value["name"],  "data" => $value["amount"]);
		   }
		}
		else {
			  $arr[] = array("label" => "ไม่มีการเบิกจ่าย",  "data" => 100, "color" => "#4572A7");
		}
		
		return $arr;
		
		//dump($data);
	    //$this->output->enable_profiler(TRUE);
	    
	}
	
	public function get_approve_barchart($budget_main_id)
	{
		$data = $this->dashboard_model->approve_bar_chart($budget_main_id);
		
		$str = "";
		if (count($data) > 0) {
			foreach ($data as $key => $value) {
				$timespan = strtotime($value["doc_date"])."000";
			    
			    if($key == 0){
			        $str .= "[".$timespan.",".$value["total"]."]";
			    }
				else {
					$str .= ",[".$timespan.",".$value["total"]."]";
				}
		   }
		}
		
		return $str;
	
		//dump($arr);
	   // $this->output->enable_profiler(TRUE);
	    
	}
	
	public function get_payment_barchart($budget_main_id)
	{
		$data = $this->dashboard_model->payment_bar_chart($budget_main_id);
		
		$str = "";
		if (count($data) > 0) {
			foreach ($data as $key => $value) {
				$timespan = strtotime($value["doc_date"])."000";
			    
			    if($key == 0){
			        $str .= "[".$timespan.",".$value["total"]."]";
			    }
				else {
					$str .= ",[".$timespan.",".$value["total"]."]";
				}
		   }
		}

		return $str;
	   
		//dump($data);
	   // $this->output->enable_profiler(TRUE);
	    
	}

}