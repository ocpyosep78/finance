<?php
class Dashboard_model extends MY_Model{
     	
     function __construct (){
        parent::__construct();
        $this->table_name = 'trn_budget_main';
        $this->primary_key = 'trn_budget_main.id';
		$this->order_by = 'trn_budget_main.id ASC';
    }
	 
	public function num_page() {
        $result = $this->db->from('trn_budget_main')
                        ->count_all_results();
        return $result;
    }
	
	// Pie Chart 1
	public function total_chart($budget_main_ID) {
		
		$this->db->select('IFNULL(trn_budget_main.amount,0) AS budget',FALSE);
		$this->db->select('IFNULL(sum(trn_payment.amount),0)  AS payment',FALSE);
		
		$this->db->join('trn_approve', 'trn_approve.budget_main_id = trn_budget_main.id');
		$this->db->join('trn_disbursement','trn_disbursement.approve_id = trn_approve.id','LEFT OUTER');
		$this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
		
		
		$this->db->where('trn_approve.budget_main_id =', $budget_main_ID);
		return $this->get();
    }
	
	// Pie Chart 2
	public function mgt_plan_chart($budget_main_ID) {
		
		$this->db->select('mst_plans.name, trn_mgt_plans.amount');
		
        $this->db->join('trn_mgt_plans', 'trn_mgt_plans.budget_main_id = trn_budget_main.id ');
		$this->db->join('mst_plans','mst_plans.id = trn_mgt_plans.plan_id');		
		
		$this->db->where('trn_mgt_plans.budget_main_id =', $budget_main_ID);
		return $this->get();
    }
	
	// Pie Chart 3
	public function approve_plans_chart($budget_main_ID) {
		
		$this->db->select('mst_plans.name');
		$this->db->select('IFNULL(sum(trn_approve.amount),0) AS amount',FALSE);
		
		$this->db->join('trn_approve', 'trn_approve.budget_main_id = trn_budget_main.id');
        $this->db->join('trn_mgt_plans', 'trn_mgt_plans.id = trn_approve.mgt_plans_id ');
		$this->db->join('mst_plans','mst_plans.id = trn_mgt_plans.plan_id');
		
		$this->db->group_by("trn_approve.mgt_plans_id");
		$this->db->where('trn_mgt_plans.budget_main_id =', $budget_main_ID);
		return $this->get();
    }
	
	// Pie Chart 4
	public function payment_plans_chart($budget_main_ID) {
		
		$this->db->select('mst_plans.name');
		$this->db->select('IFNULL(sum(trn_payment.amount),0) AS amount',FALSE);
		
		$this->db->join('trn_approve', 'trn_approve.budget_main_id = trn_budget_main.id');
		$this->db->join('trn_disbursement','trn_disbursement.approve_id = trn_approve.id','LEFT OUTER');
		$this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
        $this->db->join('trn_mgt_plans', 'trn_mgt_plans.id = trn_approve.mgt_plans_id ');
		$this->db->join('mst_plans','mst_plans.id = trn_mgt_plans.plan_id');
		
		$this->db->group_by("trn_approve.mgt_plans_id");
		$this->db->where('trn_mgt_plans.budget_main_id =', $budget_main_ID);
		return $this->get();
    }
 
    // Pie Chart 5
	public function approve_costs_chart($budget_main_ID) {
		
		$this->db->select('mst_costs.name');
		$this->db->select('IFNULL(sum(trn_approve.amount),0) AS amount',FALSE);
		
		$this->db->join('trn_approve', 'trn_approve.budget_main_id = trn_budget_main.id');
        $this->db->join('trn_mgt_costs','trn_mgt_costs.id = trn_approve.mgt_costs_id','RIGHT OUTER');
		$this->db->join('mst_costs', 'mst_costs.id = trn_mgt_costs.costs_id');
		
		$this->db->group_by("mst_costs.id");
		$this->db->where('trn_approve.budget_main_id =', $budget_main_ID);
		return $this->get();
    }

	// Pie Chart 6
	public function payment_costs_chart($budget_main_ID) {
		
		$this->db->select('mst_costs.name');
		$this->db->select('IFNULL(sum(trn_payment.amount),0) AS amount',FALSE);
		
		$this->db->join('trn_approve', 'trn_approve.budget_main_id = trn_budget_main.id');
		$this->db->join('trn_disbursement','trn_disbursement.approve_id = trn_approve.id','LEFT OUTER');
		$this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
        $this->db->join('trn_mgt_costs','trn_mgt_costs.id = trn_approve.mgt_costs_id','RIGHT OUTER');
		$this->db->join('mst_costs', 'mst_costs.id = trn_mgt_costs.costs_id');
		
		$this->db->group_by("mst_costs.id");
		$this->db->where('trn_approve.budget_main_id =', $budget_main_ID);
		return $this->get();
    }
	
	// Bar Chart 1
	public function approve_bar_chart($budget_main_ID) {
		
		$this->db->select('trn_approve.doc_date');
		$this->db->select('count(trn_approve.id) AS total',FALSE);	
		$this->db->join('trn_approve', 'trn_approve.budget_main_id = trn_budget_main.id');
		
		$this->db->group_by("YEAR(trn_approve.doc_date), MONTH(trn_approve.doc_date)");
		$this->db->where('trn_approve.budget_main_id =', $budget_main_ID);
		return $this->get();
    }

	// Bar Chart 1
	public function payment_bar_chart($budget_main_ID) {
		
		$this->db->select('trn_disbursement.doc_date');
		$this->db->select('count(trn_disbursement.id) AS total',FALSE);	
		$this->db->join('trn_approve', 'trn_approve.budget_main_id = trn_budget_main.id');
		$this->db->join('trn_disbursement','trn_disbursement.approve_id = trn_approve.id');
		
		$this->db->group_by("YEAR(trn_disbursement.doc_date), MONTH(trn_disbursement.doc_date)");
		$this->db->where('trn_approve.budget_main_id =', $budget_main_ID);
		return $this->get();
    }
}


/* End of file dashboard_model.php */
/* Location: ./application/models/dashboard_model.php */