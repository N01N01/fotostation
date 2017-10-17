<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class user_management extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
	}

	public function index(){
		if(IS_ADMIN != 1) redirect(PATH."dashboard");
		$data = array(
			"result" => $this->model->getUserList()
		);
		$this->template->title(l('User management'));
		$this->template->build('index', $data);
	}

	public function update(){
		if(IS_ADMIN != 1) redirect(PATH."dashboard");
		$data = array(
			"result"  => $this->model->get("*", USER_MANAGEMENT, "id = '".get("id")."'"),
			"package" => $this->model->fetch("*", PACKAGE)
		);
		$this->template->title(l('User management'));
		$this->template->build('update', $data);
	}

	public function ajax_update(){
		if(IS_ADMIN != 1) redirect(PATH."dashboard");
		$id = (int)post("id");

		if(post("fullname") == ""){
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Fullname is required')
			));
		}

		if(post("email") == ""){
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Email is required')
			));
		}

		if(!filter_var(post("email"), FILTER_VALIDATE_EMAIL)){
		  	ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Invalid email format')
			));
		}

		if(post("expiration_date") == ""){
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Expiration date is required')
			));
		}

		if(post("timezone") == ""){
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Timezone is required')
			));
		}

		$groups = (int)post("maximum_groups");
		$pages  = (int)post("maximum_pages");
		$liked_pages  = (int)post("maximum_liked_pages");

		$data = array(
			"fullname"        => post("fullname"),
			"email"           => post("email"),
			"admin"           => (int)post("admin"),
			"maximum_account" => (int)post("maximum_account"),
			"maximum_groups"  => ($groups > 5000)?5000:$groups,
			"maximum_pages"   => ($pages > 50)?50:$pages,
			"maximum_liked_pages" => ($liked_pages > 50)?50:$liked_pages,
			"expiration_date" => date("Y-m-d", strtotime(post("expiration_date"))),
			"timezone"        => post("timezone"),
			"status"          => (int)post("status"),
			"changed"         => NOW
		);

		if($id == 0){
			if(post("password") == ""){
				ms(array(
					"st"    => "error",
					"label" => "bg-red",
					"txt"   => l('Password is required')
				));
			}

			if(strlen(post("password")) < 6){
				ms(array(
					"st"    => "error",
					"label" => "bg-red",
					"txt"   => l('Passwords must be at least 6 characters')
				));
			}

			if(post("password") != post("repassword")){
				ms(array(
					"st"    => "error",
					"label" => "bg-red",
					"txt"   => l('Password incorrect')
				));
			}

			$data["password"] = md5(post("password"));
			$data["type"]     = "direct";
			$data["created"]  = NOW;

			$this->db->insert(USER_MANAGEMENT, $data);
			$id = $this->db->insert_id();
		}else{
			if(post("password") != ""){
				if(strlen(post("password")) < 6){
					ms(array(
						"st"    => "error",
						"label" => "bg-red",
						"txt"   => l('Passwords must be at least 6 characters')
					));
				}

				if(post("password") != post("repassword")){
					ms(array(
						"st"    => "error",
						"label" => "bg-red",
						"txt"   => l('Password incorrect')
					));
				}

				$data["password"] = md5(post("password"));
			}

			$this->db->update(USER_MANAGEMENT, $data, array("id" => $id));
		}

		ms(array(
			"st"    => "success",
			"label" => "bg-light-green",
			"txt"   => l('Update successfully')
		));
	}

	public function ajax_action_item(){
		if(IS_ADMIN != 1) redirect(PATH."dashboard");
		$id = (int)post('id');
		$POST = $this->model->get('*', USER_MANAGEMENT, "id = '{$id}'");
		if(!empty($POST)){
			switch (post("action")) {
				case 'delete':
					$this->db->delete(USER_MANAGEMENT, "id = '{$id}'");
					$this->db->delete(FACEBOOK_ACCOUNTS, "uid = '{$id}'");
					$this->db->delete(FACEBOOK_SCHEDULES, "uid = '{$id}'");
					$this->db->delete(SAVE, "uid = '{$id}'");
					$this->db->delete(CATEGORIES, "uid = '{$id}'");
					break;
				
				case 'active':
					$this->db->update(USER_MANAGEMENT, array("status" => 1), "id = '{$id}'");
					break;

				case 'disable':
					$this->db->update(USER_MANAGEMENT, array("status" => 0), "id = '{$id}'");
					break;
			}
		}

		ms(array(
			"st"    => "success",
			"label" => "bg-light-green",
			"txt"   => l('Update successfully')
		));
	}

	public function ajax_action_multiple(){
		if(IS_ADMIN != 1) redirect(PATH."dashboard");
		$ids =$this->input->post('id');
		if(!empty($ids)){
			foreach ($ids as $id) {
				$POST = $this->model->get('*', USER_MANAGEMENT, "id = '{$id}'");
				if(!empty($POST)){
					switch (post("action")) {
						case 'delete':
							$this->db->delete(USER_MANAGEMENT, "id = '{$id}'");
							$this->db->delete(FACEBOOK_ACCOUNTS, "uid = '{$id}'");
							$this->db->delete(FACEBOOK_SCHEDULES, "uid = '{$id}'");
							$this->db->delete(SAVE, "uid = '{$id}'");
							$this->db->delete(CATEGORIES, "uid = '{$id}'");
							break;
						case 'active':
							$this->db->update(USER_MANAGEMENT, array("status" => 1), "id = '{$id}'");
							break;

						case 'disable':
							$this->db->update(USER_MANAGEMENT, array("status" => 0), "id = '{$id}'");
							break;
					}
				}
			}
		}

		print_r(json_encode(array(
			'st' 	=> 'success',
			'txt' 	=> l('Update successfully')
		)));
	}

	public function profile(){
		$user = $this->model->get("*", USER_MANAGEMENT, "id = '".session("uid")."'");
		if(empty($user)) redirect(PATH);

		$data = array(
			"result"  => $user
		);
		$this->template->title('Dashboard');
		$this->template->build('profile', $data);
	}

	public function ajax_profile(){
		$id = (int)post("id");

		if(post("fullname") == ""){
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Fullname is required')
			));
		}
		
		if(post("timezone") == ""){
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Timezone is required')
			));
		}

		$data = array(
			"fullname"        => post("fullname"),
			"timezone"        => post("timezone"),
			"changed"         => NOW
		);

		if(post("password") != ""){
			if(strlen(post("password")) < 6){
				ms(array(
					"st"    => "error",
					"label" => "bg-red",
					"txt"   => l('Passwords must be at least 6 characters')
				));
			}

			if(post("password") != post("repassword")){
				ms(array(
					"st"    => "error",
					"label" => "bg-red",
					"txt"   => l('Password incorrect')
				));
			}

			$data["password"] = md5(post("password"));
		}

		$this->db->update(USER_MANAGEMENT, $data, array("id" => session("uid")));

		ms(array(
			"st"    => "success",
			"label" => "bg-light-green",
			"txt"   => l('Update successfully')
		));
	}

	public function openid($type = ""){
		$result = array();
		$PACKAGE = $this->model->get("*", PACKAGE, "default_package = 1");
		switch ($type) {
			case 'facebook':
				if(get('code') && get('state')){
					$USER = FACEBOOK_GET_USER();
					if(!empty($USER) && isset($USER['id'])){
						$data = array(
							"type"            => "facebook",
							"pid"             => $USER['id'],
							"fullname"        => $USER['name'],
							"status"          => AUTO_ACTIVE_USER,
							"changed"         => NOW
						);

						if(!empty($PACKAGE)){
							$permission = json_decode($PACKAGE->permission);
							$data["maximum_account"] = $permission->maximum_account;
							$data["maximum_groups"]  = $permission->maximum_groups;
							$data["maximum_pages"]   = $permission->maximum_pages;
							$data["maximum_liked_pages"] = $permission->maximum_liked_pages;
							$data["expiration_date"] = date('Y-m-d', strtotime("+".$PACKAGE->day." days"));
						}else{
							$data["expiration_date"] = date('Y-m-d');
						}

						if(isset($USER['email'])){
							$data['email'] = $USER['email'];
						}

						if(isset($data['email'])){
							$result = $this->model->get('*', USER_MANAGEMENT, "email = '".$data['email']."'");
						}else{
							$result = $this->model->get('*', USER_MANAGEMENT, "pid = '".$USER['id']."'");
						}
						if(empty($result)){
							if(REGISTER_ALLOWED == 1){
								$data["created"] = NOW;
								$this->db->insert(USER_MANAGEMENT, $data);
								$id = $this->db->insert_id();
								$result = $this->model->get('*', USER_MANAGEMENT, "id = '".$id."'");
							}
						}else{
							$this->db->update(USER_MANAGEMENT, $data, array('id' => $result->id));
						}
					}
				}
				break;
			case 'google':
				if(get('code')){
					$USER = GOOGLE_GET_USER(get('code'));
					if(!empty($USER)){
						$data = array(
							"type"            => "google",
							"pid"             => $USER->id,
							"fullname"        => $USER->name,
							"email"           => $USER->email,
							"status"          => AUTO_ACTIVE_USER,
							"changed"         => NOW
						);

						if(!empty($PACKAGE)){
							$permission = json_decode($PACKAGE->permission);
							$data["maximum_account"] = $permission->maximum_account;
							$data["maximum_groups"]  = $permission->maximum_groups;
							$data["maximum_pages"]   = $permission->maximum_pages;
							$data["maximum_liked_pages"] = $permission->maximum_liked_pages;
							$data["expiration_date"] = date('Y-m-d', strtotime("+".$PACKAGE->day." days"));
						}else{
							$data["expiration_date"] = date('Y-m-d');
						}

						$result = $this->model->get('*', USER_MANAGEMENT, "email = '".$USER->email."'");
						if(empty($result)){
							if(REGISTER_ALLOWED == 1){
								$data["created"] = NOW;
								$this->db->insert(USER_MANAGEMENT, $data);
								$id = $this->db->insert_id();
								$result = $this->model->get('*', USER_MANAGEMENT, "id = '".$id."'");
							}
						}else{
							$this->db->update(USER_MANAGEMENT, $data, array('id' => $result->id));
						}
					}
				}
				break;
			case 'twitter':
				if(get('oauth_token') && get('oauth_verifier')){
					$USER = TWITTER_GET_USER();
					if(!empty($USER)){
						$data = array(
							"type"            => "twitter",
							"pid"             => $USER->id_str,
							"fullname"        => $USER->name,
							"status"          => AUTO_ACTIVE_USER,
							"changed"         => NOW
						);

						if(!empty($PACKAGE)){
							$permission = json_decode($PACKAGE->permission);
							$data["maximum_account"] = $permission->maximum_account;
							$data["maximum_groups"]  = $permission->maximum_groups;
							$data["maximum_pages"]   = $permission->maximum_pages;
							$data["maximum_liked_pages"] = $permission->maximum_liked_pages;
							$data["expiration_date"] = date('Y-m-d', strtotime("+".$PACKAGE->day." days"));
						}else{
							$data["expiration_date"] = date('Y-m-d');
						}
						
						if(isset($USER->email)){
							$data['email'] = $USER->email;
						}

						if(isset($data['email'])){
							$result = $this->model->get('*', USER_MANAGEMENT, "email = '".$data['email']."'");
						}else{
							$result = $this->model->get('*', USER_MANAGEMENT, "pid = '".$USER->id_str."'");
						}
						if(empty($result)){
							if(REGISTER_ALLOWED == 1){
								$data["created"] = NOW;
								$this->db->insert(USER_MANAGEMENT, $data);
								$id = $this->db->insert_id();
								$result = $this->model->get('*', USER_MANAGEMENT, "id = '".$id."'");
							}
						}else{
							$this->db->update(USER_MANAGEMENT, $data, array('id' => $result->id));
						}
					}
				}
				break;
		}

		if(!empty($result) && $result->status == 1){
			$this->model->session($result);
			redirect(PATH."#login-success");
		}else{
			redirect(PATH."#not-active");
		}
	}

	public function ajax_login(){
		if(post("email") == ""){
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Email is required')
			));
		}

		if(!filter_var(post("email"), FILTER_VALIDATE_EMAIL)){
		  	ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Invalid email format')
			));
		}

		if(post("password") == ""){
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Password is required')
			));
		}

		$user = $this->model->get("*", USER_MANAGEMENT, "email = '".post('email')."' AND password = '".md5(post("password"))."'");
		if(!empty($user)){
			if($user->status == 1){
				if(post("remember")){
					$this->input->set_cookie('uid', $user->id, 72000);
				}
				
				$this->model->session($user);
				ms(array(
					"st"    => "success",
					"label" => "bg-light-green",
					"txt"   => l('Login successfully')
				));
			}else{
				ms(array(
					"st"    => "error",
					"label" => "bg-red",
					"txt"   => l('Your account has not been activated')
				));
			}
		}else{
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Username or password incorrect')
			));
		}
	}

	public function ajax_register(){
		if(!REGISTER_ALLOWED) redirect(PATH);

		if(post("fullname") == ""){
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Fullname is required')
			));
		}

		if(post("email") == ""){
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Email is required')
			));
		}

		if(!filter_var(post("email"), FILTER_VALIDATE_EMAIL)){
		  	ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Invalid email format')
			));
		}

		if(strlen(post('password')) == ''){
    		ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Password is required')
			));
    		exit(0);
    	}

		if(strlen(post("password")) < 6){
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Passwords must be at least 6 characters')
			));
		}

		if(post("password") != post("repassword")){
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Password incorrect')
			));
		}

		$PACKAGE = $this->model->get("*", PACKAGE, "default_package = 1");
		$POST = $this->model->get('*', USER_MANAGEMENT, "email = '".post('email')."'");
		if(empty($POST)){
			$data = array(
				'fullname'=> post("fullname"),
				'type'    => 'direct',
	    		'email'   => post('email'),
	    		'password'=> md5(post('password')),
	    		'status'  => AUTO_ACTIVE_USER,
	    		'changed' => NOW,
	    		'created' => NOW
	    	);

			if(!empty($PACKAGE)){
				$permission = json_decode($PACKAGE->permission);
				$data["maximum_account"] = $permission->maximum_account;
				$data["maximum_groups"]  = $permission->maximum_groups;
				$data["maximum_pages"]   = $permission->maximum_pages;
				$data["maximum_liked_pages"] = $permission->maximum_liked_pages;
				$data["expiration_date"] = date('Y-m-d', strtotime("+".$PACKAGE->day." days"));
			}else{
				$data["expiration_date"] = date('Y-m-d');
			}

    		$this->db->insert(USER_MANAGEMENT, $data);
    		$id = $this->db->insert_id();
    		if(AUTO_ACTIVE_USER == 1){
	    		set_cookie("uid", $id, 1209600);
				set_session("uid", $id);
				if (!file_exists('uploads/user'.(string)$id)) {
		    		mkdir('uploads/user'.$id, 0777, true);
				}
				set_cookie('folderid', 'user'.(string)$id, 86400);
			}
    		ms(array(
				'st' 	=> 'success',
				'label' => "bg-light-green",
				'txt' 	=> l('Register successfully')
			));
    	}else{
    		ms(array(
				'st' 	=> 'error',
				'label' => "bg-red",
				'txt' 	=> l('Email already exists')
			));
    	}
	}

	public function ajax_reset_password(){
		if(strlen(post('password')) == ''){
    		ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Password is required')
			));
    		exit(0);
    	}

		if(strlen(post("password")) < 6){
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Passwords must be at least 6 characters')
			));
		}

		if(post("password") != post("repassword")){
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Password incorrect')
			));
		}

		$POST = $this->model->get('*', USER_MANAGEMENT, "reset_key = '".post('reset_key')."'");
		if(!empty($POST)){
			$data = array(
	    		'password'=> md5(post('password')),
	    		'reset_key' => md5(time()),
	    		'changed' => NOW,
	    	);

    		$this->db->update(USER_MANAGEMENT, $data, array("id" => $POST->id));
    		
    		ms(array(
				'st' 	=> 'success',
				'label' => "bg-light-green",
				'txt' 	=> l('Successfully')
			));
    	}else{
    		ms(array(
				'st' 	=> 'error',
				'label' => "bg-red",
				'txt' 	=> l('Reset password key not exists')
			));
    	}
	}

	public function ajax_forgot_password(){
		
		if(post("email") == ""){
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Email is required')
			));
		}

		if(!filter_var(post("email"), FILTER_VALIDATE_EMAIL)){
		  	ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Invalid email format')
			));
		}

		$POST = $this->model->get('*', USER_MANAGEMENT, "email = '".post('email')."'");
		if(!empty($POST)){
			$reset_key = md5(time().$POST->password);
			$this->db->update(USER_MANAGEMENT, array("reset_key" => $reset_key), array("id" => $POST->id));

			if(send_mail(post("email"), $reset_key)){
				ms(array(
					'st' 	=> 'success',
					'label' => "bg-light-green",
					'txt' 	=> l('Please check your email to reset password')
				));
			}else{
				ms(array(
					'st' 	=> 'error',
					'label' => "bg-red",
					'txt' 	=> l('An error occurred. Please try again later')
				));
			}
    	}else{
    		ms(array(
				'st' 	=> 'error',
				'label' => "bg-red",
				'txt' 	=> l('This email address does not exist')
			));
    	}
	}

	public function ajax_timezone(){
		if(session("uid")){
			$this->db->update(USER_MANAGEMENT, array("timezone" => post("timezone")), array("id" => (int)session("uid")));
			ms(array(
				"st"    => "success",
				"label" => "bg-light-green",
				"txt"   => l('Update successfully')
			));
		}
	}
}