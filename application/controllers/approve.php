<?php
class Approve extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('approve_model');
		$this->load->model('mgt_costs_model');
		$this->load->helper('myfunction');
		$this->load->helper('general');
		$this->load->helper('menu');
		
		Accesscontrol_helper::is_logged_in();
	}
	
	public function index()
	{
		$data["title"] = "รายการขออนุมัติงบประมาณ";
		$data["path"] = array("งานการเงิน","ขออนุมัติใช้งบประมาณ","จัดการรายการขออนุมัติงบประมาณ");
		$data["submenu"] = Finance_menu(1);
		$this->template->load('template', 'approve_view', $data);
	}
	
	public function get()
	{
		 $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		 $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		 $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';  
         $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc'; 
		 $offset = ($page-1)*$rows;
		 
		 $budget_main_ID = $this->session->userdata('budget_year_id');
		 $where = isset($budget_main_ID) ? mysql_real_escape_string($budget_main_ID) : '';
		 
		 $this->approve_model->limit = $rows;
		 $this->approve_model->offset = $offset;
		 $this->approve_model->sort = $sort;
		 $this->approve_model->order = $order;
		 $result['total'] = $this->approve_model->num_page($where);
		 $result['rows'] = $this->approve_model->list_page($where);
		
		header('Content-type: application/json');
        echo json_encode($result);
		 
		// dump($result);
	    // $this->output->enable_profiler(TRUE);
	}
	
	public function get_by($approve_id)
	{
		$data = $this->approve_model->get_by('trn_approve.id',$approve_id);
		header('Content-type: application/json');
        echo json_encode($data);
	}
	
	public function get_detail($approve_id)
	{
		$data = $this->approve_model->approve_detail($approve_id);
		header('Content-type: application/json');
        echo json_encode($data);
       // print_r($data);
	   // $this->output->enable_profiler(TRUE);
	}

	public function get_real($mgt_costs_id)
	{
		if ($this->approve_model->num_balance($mgt_costs_id) == 0) {
		   $data = $this->mgt_costs_model->get_by('trn_mgt_costs.id',$mgt_costs_id);
		}
		else{
		   $data = $this->approve_model->real_balance($mgt_costs_id);
		}
		header('Content-type: application/json');
        echo json_encode($data);
        
        //print_r($data);
	    //$this->output->enable_profiler(TRUE);
	}
	
	public function get_total($mgt_costs_id)
	{
	   $data = $this->approve_model->approve_total($mgt_costs_id);
	   header('Content-type: application/json');
       echo json_encode($data);     
	   
	  //  dump($data);
	  //   $this->output->enable_profiler(TRUE);
	}
	
    public function check_document($document_number)
	{
        $budget_main_ID = $this->session->userdata('budget_year_id');
        
        $document_number = str_replace("_", "/", $document_number);
        $data = $this->approve_model->approve_check($document_number, $budget_main_ID);
        
        header('Content-type: application/json');
        echo json_encode($data);     
 
      //   dump($data);
       //    $this->output->enable_profiler(TRUE);
	}
	
	public function combobox()
	{
		 $data = $this->approve_model->get();
		 header('Content-type: application/json');
         echo json_encode($data);
	}
	
	public function add()
	{
	   $data = array(
	        'doc_number' => $_REQUEST['doc_number'],
	        'file_number' => $_REQUEST['file_number'],
            'doc_date' => formatDateToMySql($_REQUEST['doc_date']),
            'faculty_code' => $_REQUEST['ccfaculty'],
            'department_id' => $_REQUEST['ccdepartment'],
            'division_id' => $_REQUEST['ccdivision'],
            'subject' => $_REQUEST['subject'],
            'detail' => $_REQUEST['detail'],
            'budget_main_id' => $this->session->userdata('budget_year_id'),
            'amount' => $_REQUEST['amount']);
		print_r($data);
	
      /* 
        		
       $id = $this->approve_model->save($data);
	   
	   if(isset($id)){
	   	  echo json_encode(array('success'=>true));
	   }
	   else {
		   echo json_encode(array('msg'=>'Some errors occured.'));
	   }*/
	 
	}
	
	public function update($eid)
	{
	  if(isset($eid)){
		$data = array(
	        'doc_number' => $_REQUEST['doc_number'],
	        'file_number' => $_REQUEST['file_number'],
            'doc_date' => formatDateToMySql($_REQUEST['doc_date']),
            'faculty_code' => $_REQUEST['ccfaculty'],
            'department_id' => $_REQUEST['ccdepartment'],
            'division_id' => $_REQUEST['ccdivision'],
            'subject' => $_REQUEST['subject'],
            'detail' => $_REQUEST['detail'],
            'budget_main_id' => $_REQUEST['ccbudget'],
            'mgt_plans_id' => $_REQUEST['ccplans'],
            'mgt_product_id' => $_REQUEST['ccproduct'],
            'mgt_costs_id' => $_REQUEST['cccosts'],
            'project_id' => $_REQUEST['ccproject'],
            'activity_id' => $_REQUEST['ccactivity'],
            'amount' => $_REQUEST['amount'],
            'status' => 1);
		//print_r($_REQUEST);
			
	        $id = $this->approve_model->save($data,$eid);
		   
		    if(isset($id)){
		   	  echo json_encode(array('success'=>true));
		    }
		   else {
			   echo json_encode(array('msg'=>'Some errors occured.'));
		    } 
	  }
	}
	
	public function delete() {
       if(isset($_REQUEST['id'])){
       	$id = intval($_REQUEST['id']);	  
        $this->approve_model->delete($id);
		echo json_encode(array('success'=>true));
	  }
    }

}
