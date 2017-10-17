<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class facebook_accounts extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
	}

	public function index(){
		$data = array(
			"result" => $this->model->getAccounts()
		);
		$this->template->title(l('Facebook accounts'));
		$this->template->build('index', $data);
	}

	public function update(){
		$accounts = $this->model->fetch("*", FACEBOOK_ACCOUNTS, "id != '".get("id")."'".getDatabyUser());
		$account = $this->model->get("*", FACEBOOK_ACCOUNTS, "id = '".get("id")."'".getDatabyUser());
		//pr($accounts,1);
		$data = array(
			'result' => $account,
			'fbcount'  => count($accounts),
			'fbapp' => $this->model->fetch("*", FACEBOOK_APP, "id != '".get("id")."'".getDatabyUser())
		);
		$this->template->title(l('Facebook accounts'));
		$this->template->build('update', $data);
	}

	public function ajax_update(){
		$access_token = $this->input->post('access_token');
		$access_token_parse = json_decode($access_token);
		if(is_object($access_token_parse)){
			if(isset($access_token_parse->access_token)){
				$access_token = $access_token_parse->access_token;
			}
		}

		if($access_token == ""){
			ms(array(
				"st"  => "error",
				"label" => "bg-red",
				"txt" => l('Please input all fields')
			));
		}

		$FbOAuth_App = FbOAuth_Info_App($access_token);
		if(!empty($FbOAuth_App) && isset($FbOAuth_App['error'])){
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l($FbOAuth_App['error']['message'])
			));
		}

		$FbOAuth_User = FbOAuth_User($access_token);

		$fid = $FbOAuth_User['id'];
		$data = array(
			"uid"           => session("uid"),
			"fid"           => $fid,
			"username"      => (isset($FbOAuth_User['email']))?$FbOAuth_User['email']:$fid,
			"fullname"      => $FbOAuth_User['name'],
			"token_name"    => $FbOAuth_App['name'],
			"access_token"  => $access_token
		);
				
		$id = (int)post("id");
		$accounts = $this->model->fetch("*", FACEBOOK_ACCOUNTS, getDatabyUser(0));
		if($id == 0){
			if(count($accounts) < MAXIMUM_ACCOUNT || IS_ADMIN == 1){
				$checkAccount = $this->model->get("*", FACEBOOK_ACCOUNTS, "fid = '".$fid."'".getDatabyUser());
				if(!empty($checkAccount)){
					ms(array(
						"st"    => "error",
						"label" => "bg-red",
						"txt"   => l('This facebook account already exists')
					));
				}

				$this->db->insert(FACEBOOK_ACCOUNTS, $data);
				$id = $this->db->insert_id();
				$this->getPages($id, $access_token);
				$this->getLikedPages($id, $access_token);
				$this->getGroups($id, $access_token);
			}else{
				if(check_expiration()){
					ms(array(
						"st"    => "error",
						"label" => "bg-orange",
						"txt"   => l('Oh sorry! Out of date')
					));
				}else{
					ms(array(
						"st"    => "error",
						"label" => "bg-orange",
						"txt"   => l('Oh sorry! You have exceeded the number of accounts allowed, You are only allowed to update your account')
					));
				}
			}
		}else{
			$checkAccount = $this->model->get("*", FACEBOOK_ACCOUNTS, "fid = '".$fid."' AND id != '".$id."'".getDatabyUser());
			if(!empty($checkAccount)){
				ms(array(
					"st"    => "error",
					"label" => "bg-red",
					"txt"   => l('This facebook account already exists')
				));
			}

			$this->db->update(FACEBOOK_ACCOUNTS, $data, array("id" => post("id")));
		}

		ms(array(
			"st"    => "success",
			"label" => "bg-light-green",
			"txt"   => l('Update successfully')
		));
	}

	public function update_onwer_app(){
		$access_token = FACEBOOK_GET_ACCESS_TOKEN_FROM_CODE();
		if(strlen($access_token) <= 130){
			redirect(PATH."facebook_accounts/update?st=error&lable=bg-red&txt=".l('Facebook App ID and Facebook App Secret is required'));
		}

		$FbOAuth_App = FbOAuth_Info_App($access_token);
		if(!empty($FbOAuth_App) && isset($FbOAuth_App['error'])){
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l($FbOAuth_App['error']['message'])
			));
		}

		$FbOAuth_User = FbOAuth_User($access_token);

		$fid = $FbOAuth_User['id'];
		$data = array(
			"uid"           => session("uid"),
			"fid"           => $fid,
			"username"      => (isset($FbOAuth_User['email']))?$FbOAuth_User['email']:$fid,
			"fullname"      => $FbOAuth_User['name'],
			"app_id"        => session("fb_app_id"),
			"app_secret"    => session("fb_app_secret"),
			"token_name"    => $FbOAuth_App['name'],
			"access_token"  => $access_token
		);

		$id = (int)post("id");
		$accounts = $this->model->fetch("*", FACEBOOK_ACCOUNTS, getDatabyUser(0));
		if(count($accounts) < MAXIMUM_ACCOUNT || IS_ADMIN == 1){
			$checkAccount = $this->model->get("*", FACEBOOK_ACCOUNTS, "fid = '".$fid."'".getDatabyUser());
			if(!empty($checkAccount)){
				$this->db->update(FACEBOOK_ACCOUNTS, $data, array("id" => $checkAccount->id));
			}else{
				$this->db->insert(FACEBOOK_ACCOUNTS, $data);
				$id = $this->db->insert_id();
				$this->getPages($id, $access_token);
				$this->getLikedPages($id, $access_token);
				$this->getGroups($id, $access_token);
			}

		}else{
			if(check_expiration()){
				redirect(PATH."facebook_accounts/update?st=error&lable=bg-red&txt=".l('Oh sorry! Out of date'));
			}else{
				redirect(PATH."facebook_accounts/update?st=error&lable=bg-red&txt=".l('Oh sorry! You have exceeded the number of accounts allowed, You are only allowed to update your account'));
			}
		}

		unset_session("fb_app_id");
		unset_session("fb_app_secret");
		redirect(PATH."facebook_accounts");
	}

	public function ajax_get_page_token(){
		$username     = post('username');
		$password     = post('password');
		$app = post('app');

		if($username == "" && $password == "" && $app == ""){
			ms(array(
				"st"  => "error",
				"label" => "bg-red",
				"txt" => l('Please input all fields')
			));
		}

		if(strlen($password) < 6){
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Passwords must be at least 6 characters long')
			));
		}
		$url = GET_PAGE_ACCESS_TOKEN($username, $password, $app);

		ms(array(
			"st"    => "success",
			"label" => "bg-light-green",
			"txt"   => l('Update successfully'),
			"url"   => PATH."redirect?url=".urlencode($url)
		));
	}

	public function ajax_update_groups(){

		$id = (int)post("id");
		$access_token = post("access_token");
		if (strpos($access_token, 'facebook.com') !== false) {
		    $token_arr1 = explode("#", $access_token);
		    if(count($token_arr1) > 1){
		    	$token_arr2 = explode("&", $token_arr1[1]);
			    parse_str($token_arr1[1], $get_array);
			    if(isset($get_array['access_token'])){
			    	$access_token = $get_array['access_token'];
			    }
		    }
		}

		$account = $this->model->get("*", FACEBOOK_ACCOUNTS, "id = '".$id."' ".getDatabyUser());
		if(!empty($account)){
			$this->getPages($id, $access_token);
			$this->getLikedPages($id, $access_token);
			$this->getGroups($id, $access_token);
			ms(array(
			"st"    => "success",
			"label" => "bg-light-green",
			"txt"   => l('Successfully')
		));
		}else{
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('An error occurred. Please try again later')
			));
		}
	}
	
	public function ajax_add_facebook_app(){
		if(post("app_id") == ""){
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('App ID is required')
			));
		}

		if(post("app_secret") == ""){
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('App Secret is required')
			));
		}

		$Info_App = FbOAuth_Get_Info_App(post("app_id"));
		if(isset($Info_App->error)){
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => $Info_App->error->message
			));
		}

		$data = array(
			"name" => $Info_App->name,
			"app_id" => post("app_id"),
			"app_secret" => post("app_secret"),
			"uid" => session("uid"),
			"changed" => NOW,
			"created" => NOW
		);

		$this->db->insert(FACEBOOK_APP, $data);
		ms(array(
			"st"    => "success",
			"label" => "bg-light-green",
			"txt"   => l('Successfully')
		));

	}

	public function ajax_delete_facebook_app(){
		$fbapp = (int)post("fbapp");
		if($fbapp == 0){
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Select app you want delete')
			));
		}

		$APP = $this->model->get("*", FACEBOOK_APP, "id = '".$fbapp."'");
		if(!empty($APP)){
			$this->db->delete(FACEBOOK_APP, "id = '".$fbapp."'");
			ms(array(
				'st' 	=> 'success',
				"label" => "bg-light-green",
				'txt' 	=> l('Successfully')
			));
		}else{
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('An error occurred. Please try again later')
			));
		}
	}

	public function getLikedPages($id, $access_token){
		$pages = FbOAuth_Liked_Pages($access_token);
		if(isset($pages["data"]) && !empty($pages["data"])) {
			$count=0;
	        $insert_string = "INSERT INTO `".FACEBOOK_GROUPS."` (`account_id`,`type`,`uid`,`pid`,`name`,`privacy`,`category`,`status`) VALUES ";
			$this->db->delete(FACEBOOK_GROUPS,"account_id = '".$id."' AND type = 'liked'");
			foreach ($pages["data"] as $row) {
				if(isset($row['name'])){
					$insert_string .= "('".$id."','liked','".session("uid")."','".$row['id']."','".clean($row['name'])."','','".clean($row['category'])."','1')";
	            	$insert_string .= ",";
            		$count++;
	            }
	        }

	        if($count != 0){
		        $insert_string=substr($insert_string,0,-1);
		        $this->db->query($insert_string);
	        }
		}
	}

	public function getPages($id, $access_token){
		$pages = FbOAuth_Pages($access_token);
		if(isset($pages["data"]) && !empty($pages["data"])) {
			$count=0;
	        $insert_string = "INSERT INTO `".FACEBOOK_GROUPS."` (`account_id`,`type`,`uid`,`pid`,`name`,`privacy`,`category`,`status`) VALUES ";
			$this->db->delete(FACEBOOK_GROUPS,"account_id = '".$id."' AND type = 'page'");
			foreach ($pages["data"] as $row) {
				if(isset($row['name'])){
					$insert_string .= "('".$id."','page','".session("uid")."','".$row['id']."','".clean($row['name'])."','','".clean($row['category'])."','1')";
	            	$insert_string .= ",";
            		$count++;
	            }
	        }

	        if($count != 0){
		        $insert_string=substr($insert_string,0,-1);
		        $this->db->query($insert_string);
	        }
		}
	}

	public function getGroups($id, $access_token){
		$groups = FbOAuth_Groups($access_token);
		if(isset($groups["data"]) && !empty($groups["data"])) {
			$count=0;
	        $insert_string = "INSERT INTO `".FACEBOOK_GROUPS."` (`account_id`,`type`,`uid`,`pid`,`name`,`privacy`,`category`,`status`) VALUES ";
			$this->db->delete(FACEBOOK_GROUPS,"account_id = '".$id."' AND type = 'group'");
			foreach ($groups["data"] as $row) {
				if(isset($row['name'])){
					$insert_string .= "('".$id."','group','".session("uid")."','".$row['id']."','".clean($row['name'])."','".$row['privacy']."','','1')";
	            	$insert_string .= ",";
            		$count++;
	            }
	        }

	        if($count != 0){
		        $insert_string=substr($insert_string,0,-1);
		        $this->db->query($insert_string);
	        }
		}
	}

	public function ajax_get_groups(){
		$account = $this->model->get("*", FACEBOOK_ACCOUNTS, "id = '".post("id")."'".getDatabyUser());
		if(!empty($account)){
			switch (post("type")) {
				case 'group':
					$this->getGroups($account->id, $account->access_token);
					break;

				case 'page':
					$this->getPages($account->id, $account->access_token);
					break;

				case 'likedpage':
					$this->getLikedPages($account->id, $account->access_token);
					break;
			}
			ms(array(
				'st' 	=> 'success',
				"label" => "bg-light-green",
				'txt' 	=> l('Successfully')
			));
		}else{
			ms(array(
				'st' 	=> 'error',
				"label" => "bg-red",
				'txt' 	=> l('Update failure')
			));
		}
	}
	
	public function get_owner_app(){
		$fbapp = (int)post("fbapp");
		if($fbapp == 0){
			ms(array(
				'st' 	=> 'error',
				"label" => "bg-red",
				'txt' 	=> l('Select Facebook App')
			));
		}

		$APP = $this->model->get("*", FACEBOOK_APP, "id = '".$fbapp."'");
		if(!empty($APP)){
			set_session("fb_app_id", $APP->app_id);
			set_session("fb_app_secret", $APP->app_secret);
			set_session("fb_app_version", 0);
			ms(array(
				'st' 	=> 'success',
				'label' => 'bg-light-green',
				'txt'   => l('Successfully'),
				'url' 	=> FACEBOOK_GET_ACCESS_TOKEN()
			));
		}else{
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('An error occurred. Please try again later')
			));
		}
	}

	public function ajax_action_item(){
		$id = (int)post('id');
		$POST = $this->model->get('*', FACEBOOK_ACCOUNTS, "id = '{$id}'".getDatabyUser());
		if(!empty($POST)){
			switch (post("action")) {
				case 'delete':
					$this->db->delete(FACEBOOK_GROUPS,"account_id = '".$id."'");
					$this->db->delete(FACEBOOK_ACCOUNTS, "id = '{$id}'".getDatabyUser());
					$this->db->delete(FACEBOOK_SCHEDULES, "account_id = '{$id}'");
					break;
				
				case 'active':
					$this->db->update(FACEBOOK_ACCOUNTS, array("status" => 1), "id = '{$id}'".getDatabyUser());
					break;

				case 'disable':
					$this->db->update(FACEBOOK_ACCOUNTS, array("status" => 0), "id = '{$id}'".getDatabyUser());
					break;
			}
		}

		ms(array(
			'st' 	=> 'success',
			'txt' 	=> l('Successfully')
		));
	}

	public function ajax_action_multiple(){
		$ids =$this->input->post('id');
		if(!empty($ids)){
			foreach ($ids as $id) {
				$POST = $this->model->get('*', FACEBOOK_ACCOUNTS, "id = '{$id}'".getDatabyUser());
				if(!empty($POST)){
					switch (post("action")) {
						case 'delete':
							$this->db->delete(FACEBOOK_GROUPS,"account_id = '".$id."'");
							$this->db->delete(FACEBOOK_ACCOUNTS, "id = '{$id}'".getDatabyUser());
							$this->db->delete(FACEBOOK_SCHEDULES, "account_id = '{$id}'");
							break;
						case 'active':
							$this->db->update(FACEBOOK_ACCOUNTS, array("status" => 1), "id = '{$id}'".getDatabyUser());
							break;

						case 'disable':
							$this->db->update(FACEBOOK_ACCOUNTS, array("status" => 0), "id = '{$id}'".getDatabyUser());
							break;
					}
				}
			}
		}

		print_r(json_encode(array(
			'st' 	=> 'success',
			'txt' 	=> l('Successfully')
		)));
	}
}