<?php
class Disbursement_model extends MY_Model{
     	
     function __construct (){
        parent::__construct();
        $this->table_name = 'trn_disbursement';
        $this->primary_key = 'trn_disbursement.id';
		$this->order_by = 'trn_disbursement.id ASC';
    }
	 
	public $limit;
    public $offset; 
	public $sort;
	public $order;
	
	public function list_page($budget_main_ID) {
		
		$this->db->select('trn_disbursement.id, trn_disbursement.doc_number, trn_disbursement.file_number, trn_disbursement.approve_id, trn_approve.subject');
		$this->db->select('SUM(trn_payment.amount) AS total_amount');
		$this->db->select('mst_department.name AS department, mst_costs.name AS costs, mst_costs_type.name AS coststype');
		
		$this->db->select("IF(trn_mgt_costs.costs_sublist_id = 0, mst_costs_lists.name, CONCAT(mst_costs_lists.name,' / ', mst_costs_sublist.name)) AS costsname",FALSE);
		
		$this->db->select("CONCAT(DATE_FORMAT(trn_disbursement.doc_date, '%d'),'/',DATE_FORMAT(trn_disbursement.doc_date, '%m'),'/',DATE_FORMAT(trn_disbursement.doc_date, '%Y' ) +543) AS doc_date", FALSE);
		
		$this->db->join('trn_approve', 'trn_approve.id = trn_disbursement.approve_id');
		$this->db->join('trn_mgt_costs','trn_mgt_costs.id = trn_approve.mgt_costs_id');
		$this->db->join('trn_payment','trn_payment.disbursement_id = trn_disbursement.id');
		
		$this->db->join('mst_department', 'mst_department.id = trn_approve.department_id');
		$this->db->join('mst_costs', 'mst_costs.id = trn_mgt_costs.costs_id');
		$this->db->join('mst_costs_type', 'mst_costs_type.id = trn_mgt_costs.costs_type_id');
		$this->db->join('mst_costs_lists', 'mst_costs_lists.id = trn_mgt_costs.costs_lists_id');
		$this->db->join('mst_costs_sublist', 'mst_costs_sublist.id = trn_mgt_costs.costs_sublist_id',"LEFT OUTER");
		
		$this->db->where('trn_approve.status =', '2');
		
		if(!empty($budget_main_ID))
		    $this->db->where('trn_approve.budget_main_id =', $budget_main_ID);
		
		$this->db->group_by('trn_disbursement.id');
		$this->db->order_by($this->sort,$this->order);
		$this->db->limit($this->limit, $this->offset);
		return $this->get();
    }
 
    public function num_page($budget_main_ID) {
    					
		if(!empty($budget_main_ID)){
		   $result = $this->db->from('trn_disbursement')
		                      ->join('trn_approve', 'trn_disbursement.approve_id = trn_approve.id')
		                      ->where('trn_approve.budget_main_id', $budget_main_ID)
		                      ->count_all_results();
		}
		else{
           $result = $this->db->from('trn_disbursement')->count_all_results();
		}
		
        return $result;
    }
	
}

/* End of file disbursement_model.php */
/* Location: ./application/models/disbursement_model.php */