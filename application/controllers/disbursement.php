<?php
class Disbursement extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('disbursement_model');
		$this->load->model('payment_model');
		$this->load->model('approve_model');
		$this->load->helper('myfunction');
		$this->load->helper('menu');
	}
	
	public function index()
	{
		$data["title"] = "รายการเบิกจ่ายงบประมาณ";
		$data["path"] = array("งานการเงิน","เบิกจ่ายงบประมาณ","จัดการรายการเบิกจ่ายงบประมาณ");
		$data["submenu"] = Finance_menu(2);
		$this->template->load('template', 'disbursement_view', $data);
	}
	
	public function form($approve_id = 0, $disbursement_id = 0)
	{
		$data["title"] = "แบบฟอร์มการเบิกจ่ายงบประมาณ";
		$data["path"] = array("งานการเงิน","เบิกจ่ายงบประมาณ","จัดการการเบิกจ่ายงบประมาณ");
		$data["submenu"] = Finance_menu(2);
		
		$data["app_id"] = $approve_id;
		$data["dis_id"] = $disbursement_id;
		$this->template->load('template', 'disbursement_form_view',$data);
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
		 
		 $this->disbursement_model->limit = $rows;
		 $this->disbursement_model->offset = $offset;
		 $this->disbursement_model->sort = $sort;
		 $this->disbursement_model->order = $order;
		 $result['total'] = $this->disbursement_model->num_page($where);
		 $result['rows'] = $this->disbursement_model->list_page($where);
		
		 header('Content-type: application/json');
         echo json_encode($result);
		 //print_r($result);
	   	//$this->output->enable_profiler(TRUE);
	}
	

	public function get_by($disbursement_id)
	{
		
		$data = $this->disbursement_model->get_by('trn_disbursement.id',$disbursement_id);
		header('Content-type: application/json');
        echo json_encode($data);
	}
	
	public function get_detail($approve_id)
	{
		$data = $this->approve_model->approve_by($approve_id);
		header('Content-type: application/json');
        echo json_encode($data);
       // print_r($data);
	   //	$this->output->enable_profiler(TRUE);
	}
	
	public function combobox()
	{
		 $data = $this->disbursement_model->get();
		 header('Content-type: application/json');
         echo json_encode($data);
	}
	
	public function add()
	{
	   $data = array(
	   		'approve_id' => $_REQUEST['id'],
	        'doc_number' => $_REQUEST['paydoc_number'],
	        'file_number' => $_REQUEST['payfile_number'],
            'doc_date' => formatDateToMySql($_REQUEST['pay_date']),
        	'invoice_number' => $_REQUEST['invoice_number'],
            'detail' => $_REQUEST['paydetail']);

       $id = $this->disbursement_model->save($data);
	   
	   // Update Approve Status
	   $this->approve_model->save(array('status' => 2),$_REQUEST['id']);
	   
	   // Add Payment
	   if(isset($id)){
		    $pid = 0;	
		    $arrPayer = array_combine($_REQUEST['ccpayer'], $_REQUEST['sum']);
	   	  	
	   	  	foreach ($arrPayer as $code => $value) {
				$data = array(
			        'disbursement_id' => $id,
			        'payer_code' => $code,
					'amount' => $value);
				$pid = $this->payment_model->save($data);	 
			}
			if(isset($pid)){
	   	        echo json_encode(array('success'=>true));
			}else {
				echo json_encode(array('msg'=>'Some errors occured.'));
			}
	   }
	   else {
		   echo json_encode(array('msg'=>'Some errors occured.'));
	   }
	}
	
	
	public function update($eid)
	{
	  if(isset($eid)){
		  $data = array(
	        'doc_number' => $_REQUEST['paydoc_number'],
	        'file_number' => $_REQUEST['payfile_number'],
            'doc_date' => formatDateToMySql($_REQUEST['pay_date']),
        	'invoice_number' => $_REQUEST['invoice_number'],
            'detail' => $_REQUEST['paydetail']);
			 			
	        $id = $this->disbursement_model->save($data,$eid);
	      
		    // Update Payment
		    if(isset($id)){
		   	    $pid = 0;
				$arrCount = 1;
				$arrID = $_REQUEST['payerid'];
			    $arrPayer = array_combine($_REQUEST['ccpayer'], $_REQUEST['sum']);
				
		   	  	foreach ($arrPayer as $code => $value) {
					
					if(empty($arrID[$arrCount])){
					 	$data = array(
				                'disbursement_id' => $eid,
				                'payer_code' => $code,
						        'amount' => $value);
					    $pid = $this->payment_model->save($data);
					}else{
						$data = array(
				                'payer_code' => $code,
						        'amount' => $value);	
					    $pid = $this->payment_model->save($data,$arrID[$arrCount]);
					}
					$arrCount++;
				}
				if(isset($pid)){
		   	        echo json_encode(array('success'=>true));
				}else {
					echo json_encode(array('msg'=>'Some errors occured.'));
				}
		    }
		   else {
			   echo json_encode(array('msg'=>'Some errors occured.'));
		    }
		  
	  }
	}
	
	public function delete() {
       if(isset($_REQUEST['id'])){
       	$id = intval($_REQUEST['id']);	  
        
		//Delete Payment
        $this->payment_model->delete_by('trn_payment.disbursement_id',$id);
		
        $this->disbursement_model->delete($id);
		
		 // Update Approve Status
		if(isset($_REQUEST['app_id'])){
			$app_id = intval($_REQUEST['app_id']);
	        $this->approve_model->save(array('status' => 1),$app_id);
		}
		echo json_encode(array('success'=>true));
	  }
    }

}