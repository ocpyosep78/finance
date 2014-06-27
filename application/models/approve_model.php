<?php
class Approve_model extends MY_Model{
     	
     function __construct (){
        parent::__construct();
        $this->table_name = 'trn_approve';
        $this->primary_key = 'trn_approve.id';
		$this->order_by = 'trn_approve.id ASC';
    }
	 
	public $limit;
    public $offset; 
	public $sort;
	public $order;
	
	public function list_page($budget_main_ID) {
		
		$this->db->select('trn_approve.id, trn_approve.doc_number, trn_approve.file_number, trn_approve.subject, trn_approve.detail, trn_approve.status');
		$this->db->select('trn_approve.faculty_code, trn_approve.department_id, trn_approve.division_id, trn_approve.project_id, trn_approve.activity_id');
		$this->db->select('trn_approve.budget_main_id, trn_approve.mgt_plans_id, trn_approve.mgt_product_id, trn_approve.mgt_costs_id, trn_mgt_product.product_id');
			
		$this->db->select('IF(trn_approve.status = 1, trn_approve.amount, SUM(trn_payment.amount)) AS amount',FALSE);
		
		$this->db->select('mst_costs.name AS costs, mst_costs_type.name AS coststype, mst_costs_lists.name AS costslists');
		$this->db->select("CONCAT(DATE_FORMAT(trn_approve.doc_date, '%d'),'/',DATE_FORMAT(trn_approve.doc_date, '%m'),'/',DATE_FORMAT(trn_approve.doc_date, '%Y' ) +543) AS doc_date", FALSE);
		
		$this->db->join('trn_disbursement','trn_disbursement.approve_id = trn_approve.id','LEFT OUTER');
		$this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
			
		$this->db->join('trn_mgt_costs','trn_mgt_costs.id = trn_approve.mgt_costs_id');
		$this->db->join('trn_mgt_product','trn_mgt_product.id = trn_approve.mgt_product_id');
		$this->db->join('trn_mgt_plans','trn_mgt_plans.id = trn_approve.mgt_plans_id');
		$this->db->join('trn_budget_main', 'trn_budget_main.id = trn_approve.budget_main_id');
		
		$this->db->join('mst_costs', 'mst_costs.id = trn_mgt_costs.costs_id');
		$this->db->join('mst_costs_type', 'mst_costs_type.id = trn_mgt_costs.costs_type_id');
		$this->db->join('mst_costs_lists', 'mst_costs_lists.id = trn_mgt_costs.costs_lists_id');
		
		if(!empty($budget_main_ID))
		    $this->db->where('trn_approve.budget_main_id =', $budget_main_ID);
		
		$this->db->group_by("trn_approve.id");
		$this->db->order_by($this->sort,$this->order);
		$this->db->limit($this->limit, $this->offset);
		return $this->get();
    }
 
    public function num_page($budget_main_ID) {
                        
		if(!empty($budget_main_ID))
		   $result = $this->db->from('trn_approve')->where('trn_approve.budget_main_id', $budget_main_ID)->count_all_results();
		else
           $result = $this->db->from('trn_approve')->count_all_results();
		   
        return $result;
    }

	public function approve_detail($approve_ID) {
		
		$this->db->select('trn_approve.id, trn_approve.doc_number, trn_approve.file_number, trn_approve.subject, trn_approve.detail, trn_approve.amount, trn_approve.budget_main_id');
		
		$this->db->select('mst_faculty.name AS faculty, mst_department.name AS department, mst_division.name AS division');
		
		$this->db->select('mst_plans.name AS plans, mst_product.name AS product, mst_project.name AS project, mst_activity.name AS activity');
		
		//$this->db->select('mst_costs_group.name AS costs_group, mst_costs_type.name AS costs_type, mst_costs_lists.name AS costs_lists, mst_costs_sublist.name AS costs_sublist');
		
		$this->db->select("CONCAT(mst_costs.name,' --> ', mst_costs_type.name,' --> ',IF(trn_mgt_costs.costs_sublist_id = 0, mst_costs_lists.name, CONCAT(mst_costs_lists.name,' / ', mst_costs_sublist.name))) AS costs",FALSE);
		
		$this->db->select("CONCAT(mst_budget.title,' ',trn_budget_main.year + 543) AS budget_amount",FALSE);
		
		$this->db->select("CONCAT(DATE_FORMAT(trn_approve.doc_date, '%d'),'/',DATE_FORMAT(trn_approve.doc_date, '%m'),'/',DATE_FORMAT(trn_approve.doc_date, '%Y' ) +543) AS doc_date", FALSE);
		
		$this->db->join('mst_faculty', 'mst_faculty.code = trn_approve.faculty_code');
		$this->db->join('mst_department', 'mst_department.id = trn_approve.department_id','LEFT OUTER');
		$this->db->join('mst_division', 'mst_division.id = trn_approve.division_id','LEFT OUTER');
		
		$this->db->join('trn_mgt_costs','trn_mgt_costs.id = trn_approve.mgt_costs_id');
		$this->db->join('trn_mgt_product','trn_mgt_product.id = trn_approve.mgt_product_id');
		$this->db->join('trn_mgt_plans','trn_mgt_plans.id = trn_approve.mgt_plans_id');
		$this->db->join('trn_budget_main', 'trn_budget_main.id = trn_approve.budget_main_id');
		
		$this->db->join('mst_plans', 'mst_plans.id = trn_mgt_plans.plan_id');
		$this->db->join('mst_product', 'mst_product.id = trn_mgt_product.product_id');
		$this->db->join('mst_project', 'mst_project.id = trn_approve.project_id','LEFT OUTER');
		$this->db->join('mst_activity', 'mst_activity.id = trn_approve.activity_id','LEFT OUTER');
		
		$this->db->join('mst_costs', 'mst_costs.id = trn_mgt_costs.costs_id');
		$this->db->join('mst_costs_group', 'mst_costs_group.id = trn_mgt_costs.costs_group_id');
		$this->db->join('mst_costs_type', 'mst_costs_type.id = trn_mgt_costs.costs_type_id');
		$this->db->join('mst_costs_lists', 'mst_costs_lists.id = trn_mgt_costs.costs_lists_id','LEFT OUTER');
		$this->db->join('mst_costs_sublist', 'mst_costs_sublist.id = trn_mgt_costs.costs_sublist_id','LEFT OUTER');
		
		$this->db->join('mst_budget', 'mst_budget.id = trn_budget_main.budget_id');
		
		$this->db->where('trn_approve.id =', $approve_ID);
		return $this->get();
    }

	function real_balance($mgt_costs_ID)
	{
		$this->db->select('(trn_mgt_costs.amount - sum(trn_payment.amount)) AS amount',FALSE);
		
		$this->db->join('trn_mgt_costs', 'trn_mgt_costs.id = trn_approve.mgt_costs_id');
		$this->db->join('trn_disbursement', 'trn_disbursement.approve_id = trn_approve.id');
		$this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id');
		
	    $this->db->where('trn_approve.mgt_costs_id =', $mgt_costs_ID);
		return $this->get();
	}

	function approve_total($mgt_costs_ID)
	{
		$this->db->select('trn_mgt_costs.amount');
		
		$this->db->select('SUM(IFNULL(trn_payment.amount,trn_approve.amount)) AS total',FALSE);
		
		//$this->db->select('SUM(CASE WHEN trn_approve.status = 1 THEN trn_approve.amount ELSE trn_payment.amount END) AS payment', FALSE);
		
		$this->db->join('trn_mgt_costs', 'trn_mgt_costs.id = trn_approve.mgt_costs_id');
		$this->db->join('trn_disbursement', 'trn_disbursement.approve_id = trn_approve.id','LEFT OUTER');
		$this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
		
	    $this->db->where('trn_approve.mgt_costs_id =', $mgt_costs_ID);
		
		return $this->get();
	}

	function num_balance($mgt_costs_ID)
	{
		$result = $this->db->from('trn_approve')
						   ->join('trn_mgt_costs', 'trn_mgt_costs.id = trn_approve.mgt_costs_id')
						   ->join('trn_disbursement', 'trn_disbursement.approve_id = trn_approve.id')
						   ->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id')
						   ->where('trn_approve.mgt_costs_id =', $mgt_costs_ID)
                           ->count_all_results();
		
		return $result;
	}
    
    function approve_check($document_number, $budget_main_ID)
	{
        $this->db->select('trn_approve.id, trn_approve.subject ,trn_approve.amount');
        $this->db->select('COUNT(*) AS numrows',FALSE);
        $this->db->where('trn_approve.doc_number =', $document_number);
        $this->db->where('trn_approve.budget_main_id =', $budget_main_ID);
        
		return $this->get();
	}
    

	function approve_plans_report($budget_main_ID)
	{
		$this->db->select('trn_approve.id, trn_approve.mgt_plans_id, trn_approve.budget_main_id, mst_plans.name');
		$this->db->select('sum(trn_approve.amount) AS total',FALSE);
		$this->db->select("CONCAT(mst_budget.title,' ',trn_budget_main.year + 543) AS year",FALSE);
		
		$this->db->join('trn_mgt_plans','trn_mgt_plans.id = trn_approve.mgt_plans_id');
		$this->db->join('trn_budget_main', 'trn_budget_main.id = trn_approve.budget_main_id');
		
		$this->db->join('mst_plans', 'mst_plans.id = trn_mgt_plans.plan_id');
		$this->db->join('mst_budget', 'mst_budget.id = trn_budget_main.budget_id');
		
		$this->db->group_by("trn_approve.mgt_plans_id");
		$this->db->order_by('trn_budget_main.year','desc');
		
		
		if(!empty($budget_main_ID))
		    $this->db->where('trn_approve.budget_main_id =', $budget_main_ID);
		
		return $this->get();
	}


	function approve_costs_report($budget_main_ID, $mgt_plans_ID)
	{
		$this->db->select('trn_approve.id');
		$this->db->select("CONCAT(DATE_FORMAT(trn_approve.doc_date, '%d'),'/',DATE_FORMAT(trn_approve.doc_date, '%m'),'/',DATE_FORMAT(trn_approve.doc_date, '%Y' ) +543) AS doc_date", FALSE);
		$this->db->select("CONCAT(mst_costs.name,' >> ', mst_costs_group.name,' >> ', mst_costs_type.name,' >> ',IF(trn_mgt_costs.costs_sublist_id = 0, mst_costs_lists.name, CONCAT(mst_costs_lists.name,' / ', mst_costs_sublist.name))) AS costs",FALSE);
		
		$this->db->select('trn_approve.amount AS total',FALSE);
		
		$this->db->join('trn_mgt_costs','trn_mgt_costs.id = trn_approve.mgt_costs_id');
		$this->db->join('trn_budget_main', 'trn_budget_main.id = trn_approve.budget_main_id');
		
		$this->db->join('mst_costs', 'mst_costs.id = trn_mgt_costs.costs_id');
		$this->db->join('mst_costs_group', 'mst_costs_group.id = trn_mgt_costs.costs_group_id');
		$this->db->join('mst_costs_type', 'mst_costs_type.id = trn_mgt_costs.costs_type_id');
		$this->db->join('mst_costs_lists', 'mst_costs_lists.id = trn_mgt_costs.costs_lists_id','LEFT OUTER');
		$this->db->join('mst_costs_sublist', 'mst_costs_sublist.id = trn_mgt_costs.costs_sublist_id','LEFT OUTER');
		
	    
	    $this->db->where('trn_approve.budget_main_id =', $budget_main_ID);
		$this->db->where('trn_approve.mgt_plans_id =', $mgt_plans_ID);
		
		return $this->get();
	}

    // report_summary.php (controllers)
	function plans_level_report($budget_main_ID)
	{
		$this->db->select('trn_mgt_plans.id, mst_plans.name ,trn_mgt_product.amount');
		$this->db->select('trn_mgt_product.id AS product_id, trn_approve.id AS approve_id');
		
		$this->db->select('IFNULL(trn_approve.amount,0) AS approve',FALSE);
		$this->db->select('IFNULL(sum(trn_payment.amount),0)  AS payment',FALSE);
	
	
		$this->db->join('trn_disbursement','trn_disbursement.approve_id = trn_approve.id','LEFT OUTER');
		$this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
		
		$this->db->join('trn_mgt_plans','trn_mgt_plans.id = trn_approve.mgt_plans_id','RIGHT OUTER');
		$this->db->join('trn_mgt_product','trn_mgt_product.mgt_plans_id = trn_mgt_plans.id','RIGHT OUTER');
		$this->db->join('mst_plans', 'mst_plans.id = trn_mgt_plans.plan_id');
	
	    $this->db->where('trn_mgt_plans.budget_main_id =', $budget_main_ID);
		$this->db->group_by("trn_mgt_product.id,trn_approve.id");
		$this->db->order_by('trn_mgt_plans.id,trn_mgt_product.id');
	    
		return $this->get();
	}

    // report_summary.php (controllers)
	function product_level_report($Mgt_Plans_ID)
	{
		$this->db->select('trn_mgt_costs.id, trn_mgt_costs.mgt_product_id, mst_product.name, trn_mgt_costs.amount');
		$this->db->select('IFNULL(trn_approve.amount,0) AS approve',FALSE);
		$this->db->select('IFNULL(sum(trn_payment.amount),0)  AS payment',FALSE);
	
		$this->db->join('trn_disbursement','trn_disbursement.approve_id = trn_approve.id','LEFT OUTER');
		$this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
		
		$this->db->join('trn_mgt_costs','trn_mgt_costs.id = trn_approve.mgt_costs_id','RIGHT OUTER');
		$this->db->join('trn_mgt_product','trn_mgt_product.id = trn_mgt_costs.mgt_product_id','RIGHT OUTER');
		$this->db->join('mst_product', 'mst_product.id = trn_mgt_product.product_id');
	
	    $this->db->where('trn_mgt_product.mgt_plans_id =', $Mgt_Plans_ID);
		$this->db->group_by("trn_approve.id");
		$this->db->order_by('trn_mgt_costs.id');
		
		return $this->get();
	}
	
	// report_summary.php (controllers)
	function costs_level_report($Mgt_Product_ID)
	{
		$this->db->select('trn_mgt_costs.id, mst_costs.id AS costs_id, mst_costs.name, trn_mgt_costs.amount');
		$this->db->select('IFNULL(trn_approve.amount,0) AS approve',FALSE);
		$this->db->select('IFNULL(sum(trn_payment.amount),0)  AS payment',FALSE);
	
		$this->db->join('trn_disbursement','trn_disbursement.approve_id = trn_approve.id','LEFT OUTER');
		$this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
		
		$this->db->join('trn_mgt_costs','trn_mgt_costs.id = trn_approve.mgt_costs_id','RIGHT OUTER');
		$this->db->join('mst_costs', 'mst_costs.id = trn_mgt_costs.costs_id');
	
	    $this->db->where('trn_mgt_costs.mgt_product_id =', $Mgt_Product_ID);
		$this->db->group_by("trn_approve.id");
		$this->db->order_by('trn_mgt_costs.id');
	    
		return $this->get();
	}
	
	// report_summary.php (controllers)
	function costs_type_level_report($Mgt_Product_ID,$Costs_ID)
	{
		$this->db->select('trn_mgt_costs.id, mst_costs_type.id AS costs_type_id, mst_costs_type.name, trn_mgt_costs.amount');
		$this->db->select('IFNULL(trn_approve.amount,0) AS approve',FALSE);
		$this->db->select('IFNULL(sum(trn_payment.amount),0)  AS payment',FALSE);
	
		$this->db->join('trn_disbursement','trn_disbursement.approve_id = trn_approve.id','LEFT OUTER');
		$this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
		
		$this->db->join('trn_mgt_costs','trn_mgt_costs.id = trn_approve.mgt_costs_id','RIGHT OUTER');
		$this->db->join('mst_costs_type', 'mst_costs_type.id = trn_mgt_costs.costs_type_id');
	
	    $this->db->where('trn_mgt_costs.mgt_product_id =', $Mgt_Product_ID);
		$this->db->where('trn_mgt_costs.costs_id =', $Costs_ID);
		$this->db->group_by("trn_approve.id");
		$this->db->order_by('trn_mgt_costs.id');
	    
		
		return $this->get();
	}
	
	// report_summary.php (controllers)
	function costs_lists_level_report($Mgt_Product_ID, $Costs_Type_ID)
	{
		$this->db->select('trn_mgt_costs.id, trn_mgt_costs.amount');
		$this->db->select("IF(trn_mgt_costs.costs_sublist_id = 0, mst_costs_lists.name, CONCAT(mst_costs_lists.name,' / ', mst_costs_sublist.name)) AS name",FALSE);
		
		$this->db->select('IFNULL(trn_approve.amount,0) AS approve',FALSE);
		$this->db->select('IFNULL(sum(trn_payment.amount),0)  AS payment',FALSE);
	
		$this->db->join('trn_disbursement','trn_disbursement.approve_id = trn_approve.id','LEFT OUTER');
		$this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
		
		$this->db->join('trn_mgt_costs','trn_mgt_costs.id = trn_approve.mgt_costs_id','RIGHT OUTER');
		$this->db->join('mst_costs_lists', 'mst_costs_lists.id = trn_mgt_costs.costs_lists_id');
		$this->db->join('mst_costs_sublist','mst_costs_sublist.costs_lists_id = mst_costs_lists.id',"LEFT OUTER");
	
	    $this->db->where('trn_mgt_costs.mgt_product_id =', $Mgt_Product_ID);
		$this->db->where('trn_mgt_costs.costs_type_id =', $Costs_Type_ID);
		$this->db->group_by("trn_approve.id");
		$this->db->order_by('trn_mgt_costs.id');
	    
		return $this->get();
	}
	

}

/* End of file approve_model.php */
/* Location: ./application/models/approve_model.php */