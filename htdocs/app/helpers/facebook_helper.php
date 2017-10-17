<?php

if (!function_exists('FbOAuth_Groups')) {
	function FbOAuth_Groups($access_token)
	{
		try {
			$params = array(0 => 'fields=id,name,privacy', 'limit' => 10000, 'access_token' => $access_token);
			return FbOAuth()->api('/v2.3/me/groups', 'GET', $params);
		}
		catch (Exception $e) {
			return false;
		}
	}
}

if (!function_exists('FbOAuth_Get_Info_App')) {
	function FbOAuth_Get_Info_App($appId)
	{
		try {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/' . $appId);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$response = curl_exec($ch);
			curl_close($ch);
			return json_decode($response);
		}
		catch (Exception $e) {
			return false;
		}
	}
}

if (!function_exists('FbOAuth_Pages')) {
	function FbOAuth_Pages($access_token)
	{
		try {
			$params = array(0 => 'fields=id,name,category', 'limit' => 10000, 'access_token' => $access_token);
			return FbOAuth()->api('/v2.3/me/accounts', 'GET', $params);
		}
		catch (Exception $e) {
			return false;
		}
	}
}

if (!function_exists('FbOAuth_Liked_Pages')) {
	function FbOAuth_Liked_Pages($access_token)
	{
		try {
			$params = array(0 => 'fields=id,name,category', 'limit' => 10000, 'access_token' => $access_token);
			return FbOAuth()->api('/v2.3/me/likes', 'GET', $params);
		}
		catch (Exception $e) {
			return false;
		}
	}
}

if (!function_exists('FbOAuth_User')) {
	function FbOAuth_User($access_token)
	{
		try {
			$params = array(0 => 'fields=id,name', 'access_token' => $access_token);
			$data = FbOAuth()->api('/v2.8/me', 'GET', $params);
			return $data;
		}
		catch (Exception $e) {
			return false;
		}
	}
}

if (!function_exists('FbOAuth_GetPost')) {
	function FbOAuth_GetPost($post_id, $access_token)
	{
		try {
			$params = array(0 => '', 'access_token' => $access_token);
			$data = FbOAuth()->api('/v2.3/' . $post_id . '?fields=comments,likes,sharedposts', 'GET', $params);

			if (!isset($data['error'])) {
				$like = (isset($data['likes']) ? count($data['likes']['data']) : 0);
				$sharedposts = (isset($data['sharedposts']) ? count($data['sharedposts']['data']) : 0);
				$comments = (isset($data['comments']) ? (int) $data['comments']['data'] : 0);
				ms(array('st' => 'success', 'txt' => "\r\n                    Likes: <b>" . $like . "</b><br/>\r\n                    Comments: <b>" . $comments . "</b><br/>\r\n                    Shareds: <b>" . $sharedposts . '</b>'));
			}
			else {
				ms(array('st' => 'error', 'label' => 'bg-red', 'txt' => l('Error')));
			}
		}
		catch (Exception $e) {
			return false;
		}
	}
}

if (!function_exists('FbOAuth_Access_Token_Page')) {
	function FbOAuth_Access_Token_Page($pageid, $access_token)
	{
		try {
			$params = array('access_token' => $access_token);
			$result = FbOAuth()->api('/v2.3/' . $pageid . '?fields=access_token', 'GET', $params);

			if (isset($result['access_token'])) {
				return $result['access_token'];
			}

			return false;
		}
		catch (Exception $e) {
			return false;
		}
	}
}

if (!function_exists('GET_PAGE_ACCESS_TOKEN')) {
	function GET_PAGE_ACCESS_TOKEN($user = '', $pass = '', $app = '')
	{
		switch ($app) {
		case '6628568379':
			$api_key = '882a8490361da98702bf97a021ddc14d';
			$secretkey = '62f8ce9f74b12f84c123cc23437a4a32';
			break;

		default:
			$api_key = '3e7c78e35a76a9299309885393b02d97';
			$secretkey = 'c1e620fa708a1d5696fb991c1bde5662';
			break;
		}

		$postdata = array('api_key' => $api_key, 'email' => $user, 'format' => 'json', 'locale' => 'vi_vn', 'method' => 'auth.login', 'password' => $pass, 'return_ssl_resources' => '0', 'v' => '1.0');
		$postdata['sig'] = CREATE_SIG($postdata, $secretkey);
		$query = http_build_query($postdata);
		return 'https://api.facebook.com/restserver.php?' . $query;
	}
}

if (!function_exists('CREATE_SIG')) {
	function CREATE_SIG($postdata, $secretkey)
	{
		$textsig = '';

		foreach ($postdata as $key => $value) {
			$textsig .= $key . '=' . $value;
		}

		$textsig .= $secretkey;
		$textsig = md5($textsig);
		return $textsig;
	}
}

if (!function_exists('REQUEST_CURL')) {
	function REQUEST_CURL($url, $postdata = '')
	{
		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, $url);
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($c, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:44.0) Gecko/20100101 Firefox/44.0');

		if ($postdata != '') {
			curl_setopt($c, CURLOPT_POST, 1);
			curl_setopt($c, CURLOPT_POSTFIELDS, $postdata);
		}

		$page = curl_exec($c);
		curl_close($c);
		return $page;
	}
}

if (!function_exists('FbOAuth_Info_App')) {
	function FbOAuth_Info_App($access_token)
	{
		$params = array('access_token' => $access_token);
		return FbOAuth()->api('/v2.3/app', 'GET', $params);
	}
}

if (!function_exists('Fb_Post')) {
	function Fb_Post($data)
	{
		$response = array();

		if ($data->group_type == 'page') {
			$data->access_token = FbOAuth_Access_Token_Page($data->group_id, $data->access_token);
		}

		try {
			switch ($data->type) {
			case 'text':
				$params = array('message' => $data->message, 'access_token' => $data->access_token);
				$group = ($data->group_type == 'profile' ? 'me' : $data->group_id);
				$response = FbOAuth()->api('/v2.3/' . $group . '/feed', 'POST', $params);
				break;

			case 'link':
				$params = array('message' => $data->message, 'name' => $data->title, 'description' => $data->description, 'link' => $data->url, 'access_token' => $data->access_token);

				if ($data->caption != '') {
					$params['caption'] = $data->caption;
				}

				$image = $data->image;

				if (checkRemoteFile($image)) {
					$params['picture'] = $data->image;
				}

				$group = ($data->group_type == 'profile' ? 'me' : $data->group_id);
				$response = FbOAuth()->api('/v2.3/' . $group . '/feed', 'POST', $params);
				break;

			case 'image':
				$image = $data->image;

				if (checkRemoteFile($image)) {
					$params = array('message' => $data->message, 'access_token' => $data->access_token);
					$params['url'] = $image;
					$group_id = ($data->group_type == 'profile' ? 'me' : $data->group_id);
					$response = FbOAuth()->api('/v2.3/' . $group_id . '/photos', 'POST', $params);
				}

				break;

			case 'video':
				$url = $data->image;
				if ((strpos($url, 'youtube.com') !== false) || (strpos($url, 'vimeo.com') !== false)) {
					try {
						$videos = VideoDownloader($url);

						if (!empty($videos)) {
							foreach ($videos as $video) {
								if ($video['format'] == 'mp4') {
									$params = array('description' => $data->message, 'file_url' => $video['url'], 'access_token' => $data->access_token);
									$response = FbOAuth()->api('/v2.3/' . $data->group_id . '/videos', 'POST', $params);
									break;
								}
							}
						}
						else {
							$response = array('st' => 'error', 'txt' => l('Can\'t get video'));
						}
					}
					catch (Exceptions $e) {
						$response = array('st' => 'error', 'txt' => l('Can\'t get video'));
					}
				}
				else {
					if (strpos($url, 'facebook.com') != false) {
						$url = FB_DownloadVideo($url);
					}

					$params = array('description' => $data->message, 'file_url' => $url, 'access_token' => $data->access_token);
					$response = FbOAuth()->api('/v2.3/' . $data->group_id . '/videos', 'POST', $params);
				}

				break;

			case 'images':
				$images = json_decode($data->image);
				$medias = array();

				foreach ($images as $image) {
					if ((strpos($image, 'youtube.com') !== false) || (strpos($image, 'vimeo.com') !== false) || (strpos($image, 'facebook.com') != false)) {
						$params = array('message' => $data->message, 'access_token' => $data->access_token, 'published' => false);
						$params['url'] = $image;

						if (strpos($image, 'facebook.com') != false) {
							$url = FB_DownloadVideo($image);
							$params['file_url'] = $url;
							$group_id = ($data->group_type == 'profile' ? 'me' : $data->group_id);
							$post = FbOAuth()->api('/v2.3/' . $group_id . '/videos', 'POST', $params);
						}
						else {
							try {
								$videos = VideoDownloader($image);

								if (!empty($videos)) {
									foreach ($videos as $video) {
										if ($video['format'] == 'mp4') {
											$params['file_url'] = $video['url'];
											$group_id = ($data->group_type == 'profile' ? 'me' : $data->group_id);
											$post = FbOAuth()->api('/v2.3/' . $group_id . '/videos', 'POST', $params);
										}
									}
								}
							}
							catch (Exceptions $e) {
							}
						}
					}
					else {
						$params = array('message' => $data->message, 'access_token' => $data->access_token, 'published' => false);
						$params['url'] = $image;
						$group_id = ($data->group_type == 'profile' ? 'me' : $data->group_id);
						$post = FbOAuth()->api('/v2.3/' . $group_id . '/photos', 'POST', $params);
					}

					if (isset($post) && isset($post['id'])) {
						$medias[] = $post['id'];
					}
				}

				if (!empty($medias)) {
					$params = array('message' => $data->message, 'access_token' => $data->access_token);

					foreach ($medias as $key => $media) {
						$params['attached_media[' . $key . ']'] = '{"media_fbid":"' . $media . '"}';
					}

					$group_id = ($data->group_type == 'profile' ? 'me' : $data->group_id);
					$response = FbOAuth()->api('/v2.3/' . $group_id . '/feed', 'POST', $params);

					if (isset($response['id'])) {
						$find_id = explode('_', $response['id']);
						$response = array('id' => $find_id[1]);
					}
				}
			}

			if (isset($response['id']) || (isset($response['st']) && ($response['st'] == 'success'))) {
				$response = array('st' => 'success', 'txt' => isset($response['txt']) ? $response['txt'] : '', 'id' => isset($response['id']) ? $response['id'] : '');
			}
			else {
				if (isset($response['error']) || isset($response['st'])) {
					$response = array('st' => 'error', 'txt' => isset($response['txt']) ? $response['txt'] : $response['error']['message']);
				}
				else {
					$response = array('st' => 'error', 'txt' => 'Unknow error');
				}
			}
		}
		catch (\Facebook\Exceptions\FacebookResponseException $e) {
			$response = array('st' => 'error', 'txt' => $e->getMessage());
		}
		catch (\Facebook\Exceptions\FacebookSDKException $e) {
			$response = array('st' => 'error', 'txt' => $e->getMessage());
		}

		return $response;
	}
}

if (!function_exists('FACEBOOK_GET_USER')) {
	function FACEBOOK_GET_USER()
	{
		require_once APPPATH . 'libraries/Facebook/autoload.php';
		$fb = new \Facebook\Facebook(array('app_id' => FACEBOOK_ID, 'app_secret' => FACEBOOK_SECRET, 'default_graph_version' => 'v2.9'));
		$helper = $fb->getRedirectLoginHelper();

		try {
			$accessToken = $helper->getAccessToken();
			$oAuth2Client = $fb->getOAuth2Client();
			$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
			$response = $fb->get('/me?fields=id,name,email', (string) $accessToken);
			$data = $response->getGraphUser();
			return $data;
		}
		catch (\Facebook\Exceptions\FacebookResponseException $e) {
			return false;
		}
		catch (\Facebook\Exceptions\FacebookSDKException $e) {
			return false;
		}
	}
}

if (!function_exists('FACEBOOK_GET_ACCESS_TOKEN')) {
	function FACEBOOK_GET_ACCESS_TOKEN()
	{
		require_once APPPATH . 'libraries/Facebook/autoload.php';
		$fb = new \Facebook\Facebook(array('app_id' => session('fb_app_id'), 'app_secret' => session('fb_app_secret'), 'default_graph_version' => 'v2.9'));
		$params = array('req_perms' => 'public_profile,publish_actions,user_posts,user_managed_groups,user_events,publish_actions,publish_pages,manage_pages,user_friends');
		$helper = $fb->getRedirectLoginHelper();
		$loginUrl = $helper->getLoginUrl(PATH . 'facebook_accounts/update_onwer_app/index.php', $params);
		return $loginUrl;
	}
}

if (!function_exists('FACEBOOK_GET_ACCESS_TOKEN_FROM_CODE')) {
	function FACEBOOK_GET_ACCESS_TOKEN_FROM_CODE()
	{
		require_once APPPATH . 'libraries/Facebook/autoload.php';
		$fb = new \Facebook\Facebook(array('app_id' => session('fb_app_id'), 'app_secret' => session('fb_app_secret'), 'default_graph_version' => 'v2.9'));
		$helper = $fb->getRedirectLoginHelper();

		try {
			$accessToken = $helper->getAccessToken();
			$oAuth2Client = $fb->getOAuth2Client();
			$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
			return (string) $accessToken;
		}
		catch (\Facebook\Exceptions\FacebookResponseException $e) {
			echo 'Graph returned an error: ' . $e->getMessage();
			exit();
		}
		catch (\Facebook\Exceptions\FacebookSDKException $e) {
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit();
		}
	}
}

if (!function_exists('FACEBOOK_GET_LOGIN_URL')) {
	function FACEBOOK_GET_LOGIN_URL()
	{
		require_once APPPATH . 'libraries/Facebook/autoload.php';
		$fb = new \Facebook\Facebook(array('app_id' => FACEBOOK_ID, 'app_secret' => FACEBOOK_SECRET, 'default_graph_version' => 'v2.9'));
		$params = array('req_perms' => 'email');
		$helper = $fb->getRedirectLoginHelper();
		$loginUrl = $helper->getLoginUrl(PATH . 'openid/facebook', $params);
		return $loginUrl;
	}
}

if (!function_exists('FbOAuth')) {
	function FbOAuth()
	{
		require_once APPPATH . 'libraries/FbOAuth/facebook.php';
		$fb = new FacebookCustom(array('appId' => FACEBOOK_ID, 'secret' => FACEBOOK_SECRET));
		return $fb;
	}
}

if (!function_exists('FB_DownloadVideo')) {
	function FB_DownloadVideo($url)
	{
		$useragent = 'Mozilla/5.0 (Linux; U; Android 2.3.3; de-de; HTC Desire Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		$source = curl_exec($ch);
		curl_close($ch);
		$download = explode('/video_redirect/?src=', $source);

		if (isset($download[1])) {
			$download = explode('&amp', $download[1]);
			$download = rawurldecode($download[0]);
			return $download;
		}

		return 'error';
	}
}

if (!function_exists('getIdYoutube')) {
	function getIdYoutube($link)
	{
		preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\\/)[^&\n]+(?=\\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $link, $id);

		if (!empty($id)) {
			return $id = $id[0];
		}

		return $link;
	}
}

if (!function_exists('checkRemoteFile')) {
	function checkRemoteFile($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_NOBODY, 1);
		curl_setopt($ch, CURLOPT_FAILONERROR, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

		if (curl_exec($ch) !== false) {
			return true;
		}

		return false;
	}
}

