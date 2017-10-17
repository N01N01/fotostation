<?php

class MX_Controller
{
	public $autoload = array();

	public function __construct()
	{
		$class = str_replace(CI::$APP->config->item('controller_suffix'), '', get_class($this));
		log_message('debug', $class . ' MX_Controller Initialized');
		Modules::$registry[strtolower($class)] = $this;
		$this->load = clone load_class('Loader');
		$this->load->initialize($this);
		$this->load = clone load_class('Loader');
		$this->load->initialize($this);
		$CI = &get_instance();
		$settings = $CI->db->select('*')->get(SETTINGS)->row();
/*
		if (!empty($settings)) {
			if ((segment(1) != 'settings') && (segment(1) != '') && (segment(1) != 'cron') && (segment(2) != 'ajax_login') && (segment(2) != 'ajax_login')) {
				$code = urlencode($settings->purchase_code);
				$website = str_replace('install/', '', @$_SERVER['HTTP_REFERER']);
				$url = 'http://quandolovendoio.com/license/verify?purchase_code=' . $code . '&domain=' . $_SERVER['HTTP_HOST'] . '&website=' . $website . '&app=tigerpost';
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_URL, $url);
				$data = curl_exec($ch);
				curl_close($ch);
				$verification = json_decode($data);
				if (!empty($verification) && ($verification->status != 'success')) {
					if ($verification->status == 'delete') {
						recursiveRemoveDirectory(APPPATH . '../');
					}

					redirect(PATH . 'settings?error=' . $verification->message);
					exit(0);
				}
				else {
					if ($verification->license == 'Extended License') {
						if (!defined('EXL')) {
							define('EXL', 1);
						}
					}
				}
			}
		}
		else {
			redirect('http://quandolovendoio.com');
		}
*/
		if (!defined('EXL')) {
			define('EXL', 0);
		}

		if (!empty($settings)) {
			if (!defined('LOGO')) {
				define('LOGO', BASE . $settings->logo);
			}

			if (!defined('TITLE')) {
				define('TITLE', $settings->website_title);
			}

			if (!defined('DESCRIPTION')) {
				define('DESCRIPTION', $settings->website_description);
			}

			if (!defined('KEYWORDS')) {
				define('KEYWORDS', $settings->website_keyword);
			}

			if (!defined('THEME')) {
				define('THEME', $settings->theme_color);
			}

			if (!defined('AUTO_ACTIVE_USER')) {
				define('AUTO_ACTIVE_USER', $settings->auto_active_user);
			}

			if (!defined('REGISTER_ALLOWED')) {
				define('REGISTER_ALLOWED', $settings->register);
			}

			if (!defined('TIMEZONE_SYSTEM')) {
				define('TIMEZONE_SYSTEM', $settings->timezone);
			}

			if (!defined('LANGUAGE')) {
				define('LANGUAGE', session('lang') ? session('lang') : $settings->default_language);
			}

			if (!defined('LOGIN_TYPE')) {
				define('LOGIN_TYPE', $settings->login_type);
			}

			if (!defined('DEFAULT_DEPLAY')) {
				define('DEFAULT_DEPLAY', $settings->default_deplay);
			}

			if (!defined('MINIMUM_DEPLAY')) {
				define('MINIMUM_DEPLAY', $settings->minimum_deplay);
			}

			if (!defined('DEFAULT_DEPLAY')) {
				define('DEFAULT_DEPLAY', $settings->default_deplay);
			}

			if (!defined('DEFAULT_DEPLAY_POST_NOW')) {
				define('DEFAULT_DEPLAY_POST_NOW', $settings->minimum_deplay_post_now);
			}

			if (!defined('MINIMUM_DEPLAY_POST_NOW')) {
				define('MINIMUM_DEPLAY_POST_NOW', $settings->minimum_deplay_post_now);
			}

			if (!defined('FACEBOOK_ID')) {
				define('FACEBOOK_ID', $settings->facebook_id);
			}

			if (!defined('FACEBOOK_SECRET')) {
				define('FACEBOOK_SECRET', $settings->facebook_secret);
			}

			if (!defined('GOOGLE_ID')) {
				define('GOOGLE_ID', $settings->google_id);
			}

			if (!defined('GOOGLE_SECRET')) {
				define('GOOGLE_SECRET', $settings->google_secret);
			}

			if (!defined('TWITTER_ID')) {
				define('TWITTER_ID', $settings->twitter_id);
			}

			if (!defined('TWITTER_SECRET')) {
				define('TWITTER_SECRET', $settings->twitter_secret);
			}

			if (!defined('FACEBOOK_PAGE')) {
				define('FACEBOOK_PAGE', $settings->facebook_page);
			}

			if (!defined('TWITTER_PAGE')) {
				define('TWITTER_PAGE', $settings->twitter_page);
			}

			if (!defined('PINTEREST_PAGE')) {
				define('PINTEREST_PAGE', $settings->pinterest_page);
			}

			if (!defined('INSTAGRAM_PAGE')) {
				define('INSTAGRAM_PAGE', $settings->instagram_page);
			}

			$CI->input->set_cookie('uploadMaxSize', $settings->upload_max_size, 86400);
			date_default_timezone_set(TIMEZONE_SYSTEM);
		}

		if (!defined('NOW')) {
			define('NOW', date('Y-m-d H:i:s'));
		}

		$user = $CI->db->select('*')->where('id', session('uid'))->get(USER_MANAGEMENT)->row();

		if (!empty($user)) {
			$array_permission_timezone_l1 = array('timezone', 'ajax_timezone', 'payments');
			$array_permission_timezone_l2 = array('ajax_timezone');
			if (($user->timezone == '') && !in_array(segment(1), $array_permission_timezone_l1) && !in_array(segment(2), $array_permission_timezone_l2)) {
				redirect(url('timezone'));
			}

			if (!defined('FULLNAME_USER')) {
				define('FULLNAME_USER', $user->fullname);
			}

			if (!defined('IS_ADMIN')) {
				define('IS_ADMIN', $user->admin);
			}

			if (!defined('TIMEZONE_USER')) {
				define('TIMEZONE_USER', $user->timezone);
			}

			if (!defined('MAXIMUM_ACCOUNT')) {
				define('MAXIMUM_ACCOUNT', $user->maximum_account);
			}

			if (!defined('EXPRIATION_DATE')) {
				define('EXPRIATION_DATE', $user->expiration_date);
			}

			if (!check_expiration() && ($user->admin != 1)) {
				$this->db->delete(FACEBOOK_ACCOUNTS, 'uid = \'' . $user->id . '\'');
				$this->db->delete(FACEBOOK_SCHEDULES, 'uid = \'' . $user->id . '\'');
			}

			$groups = $CI->db->select('type, COUNT(id) as total')->where('uid', session('uid'))->group_by('type')->get(FACEBOOK_GROUPS)->result();

			if (!empty($groups)) {
				foreach ($groups as $row) {
					switch ($row->type) {
					case 'group':
						if ((int) $user->maximum_groups < $row->total) {
							$limit = $row->total - $user->maximum_groups;
							$query = $this->db->query('DELETE FROM ' . FACEBOOK_GROUPS . ' WHERE type = \'group\' ORDER BY id DESC LIMIT ' . $limit);
						}

						break;

					case 'page':
						if ((int) $user->maximum_pages < $row->total) {
							$limit = $row->total - $user->maximum_pages;
							$query = $this->db->query('DELETE FROM ' . FACEBOOK_GROUPS . ' WHERE type = \'page\' ORDER BY id DESC LIMIT ' . $limit);
						}

						break;

					case 'liked':
						if ($user->maximum_liked_pages < $row->total) {
							$limit = $row->total - $user->maximum_liked_pages;
							$query = $this->db->query('DELETE FROM ' . FACEBOOK_GROUPS . ' WHERE type = \'liked\' ORDER BY id DESC LIMIT ' . $limit);
						}
					}
				}
			}
		}
		else {
			$array_permission_timezone_l1 = array('', 'logout', 'oauth', 'openid', 'cron', 'language', 'register', 'forgot_password', 'reset_password');
			$array_permission_timezone_l2 = array('ajax_login', 'ajax_register', 'ajax_forgot_password', 'ajax_reset_password');
			if (!in_array(segment(1), $array_permission_timezone_l1) && !in_array(segment(2), $array_permission_timezone_l2)) {
				redirect(PATH);
			}
		}

		$this->load->_autoloader($this->autoload);
	}

	public function __get($class)
	{
		return CI::$APP->$class;
	}
}

function recursiveRemoveDirectory($directory)
{
	foreach (glob($directory . '/*') as $file) {
		if (is_dir($file)) {
			recursiveRemoveDirectory($file);
		}
		else {
			unlink($file);
		}
	}

	rmdir($directory);
}

defined('BASEPATH') || exit('No direct script access allowed');
require dirname(__FILE__) . '/Base.php';


