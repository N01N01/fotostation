<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class dashboard_model extends MY_Model {
	public function __construct(){
		parent::__construct();
	}

	public function countGroup(){
		$this->db->select('type, COUNT(type) as total');
		if(IS_ADMIN != 1){
			$this->db->where('uid', session("uid"));
		}
		$this->db->group_by('type'); 
		$this->db->order_by('total', 'desc'); 
		$query = $this->db->get(FACEBOOK_GROUPS, 10);
		if($query->result()){
			return $query->result();
		}else{
			return false;
		}

	}	
}
