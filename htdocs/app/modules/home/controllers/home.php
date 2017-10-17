<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class home extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
	}

	public function index(){
		if(get_cookie('uid') != ""){
			if(!session("uid")){
				$uid = (int)get_cookie('uid');
				$user = $this->model->get("*", USER_MANAGEMENT, "id = '".$uid."'");
				$this->model->session($user);
			}
		}

		if(session("uid")) redirect(url("post"));
		$data = array();
		$this->template->set_layout("home");
		$this->template->title(TITLE);
		$this->template->build('index', $data);
	}

	public function register(){
		if(session("uid")) redirect(url("post"));
		$data = array();
		$this->template->set_layout("home");
		$this->template->title(TITLE);
		$this->template->build('register', $data);
	}

	public function forgot_password(){
		$data = array();
		$this->template->set_layout("home");
		$this->template->title(TITLE);
		$this->template->build('forgot_password', $data);
	}

	public function reset_password(){
		$data = array();
		$this->template->set_layout("home");
		$this->template->title(TITLE);
		$this->template->build('reset_password', $data);
	}

	public function redirect(){
		redirect(get("url"));
	}

	public function timezone(){
		$data = array();
		$this->template->set_layout("home");
		$this->template->title(TITLE);
		$this->template->build('timezone', $data);
	}
	
	public function logout(){
		delete_cookie('folderid');
		unset_session('uid');
		delete_cookie('uid'); 
		redirect(PATH);
	}

	public function facebook(){
		redirect(FACEBOOK_GET_LOGIN_URL());
	}

	public function google(){
		redirect(GOOGLE_GET_LOGIN_URL());
	}

	public function twitter(){
		redirect(TWITTER_GET_LOGIN_URL());
	}
}