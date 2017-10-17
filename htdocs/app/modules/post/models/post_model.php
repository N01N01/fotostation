<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class post_model extends MY_Model {
	public function __construct(){
		parent::__construct();
	}


	public function getAllAccount(){
		$cate   = $this->model->get("*", CATEGORIES, "id = '".session("category")."' AND category = 'post'");
		$result = $this->model->fetch("*", FACEBOOK_ACCOUNTS, "status = 1".getDatabyUser(), "id", "asc");
		if(!empty($result)){
			foreach ($result as $key => $row) {
				$this->db->select("*");
				$this->db->where("account_id = '".$row->id."'");
				$this->db->where("type != 'friend'");

				if(session("category") && !empty($cate)){
					$group_id = json_decode($cate->data);
					if(!empty($group_id)){
						$this->db->where_in("pid", $group_id);
					}
				}
				
				$this->db->where("uid = '".session("uid")."'");
				$this->db->order_by("type", "desc");
				$query = $this->db->get(FACEBOOK_GROUPS);
				$result[$key]->groups = $query->result();
			}
		}

		return $result;
	}
}
