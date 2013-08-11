 <?php

 	require_once PATH_TABLES .'user.php';
 
 	if (Session::get('auth_user_id'))
 	{
 		$request->stop(lng('registration_is_disabled_because_you_are_signed_in'));
 	}
 
	$config = getConfig();
	$appId = $config->get('social', 'facebook_app_id');
	$appSecret = $config->get('social', 'facebook_app_secret');
	$appRedirectUrl = href(array('api' => $config->get('social', 'facebook_redirect_url')));
	if(empty($appId) || empty($appSecret) || empty($appRedirectUrl))
	{
		$request->stop(lng('internal_error'));
	}

 	$code = $request->param('code');
 	if (!empty($code))
 	{
		$url = 'https://graph.facebook.com/oauth/access_token?client_id='. $appId.
			'&redirect_uri='. $appRedirectUrl.
			'&client_secret='. $appSecret.
			'&scope=email'.
			'&code='.$code;
		$result = @file_get_contents($url);
		parse_str($result, $result);
		if (!isset($result['access_token']) || empty($result['access_token']))
 		{
			$request->stop(lng('internal_error'));
		}

		$accessToken = $result['access_token'];
		$url = 'https://graph.facebook.com/me?access_token='.$accessToken;
		$result = @file_get_contents($url);
		$profile = json_decode($result);
		
		if (
			!is_object($profile) 
			|| !isset($profile->id) 
			|| empty($profile->id)
		)
		{
			$request->stop(lng('internal_error'));
		}

		$redirectUrl = href(array('action' => 'home'));
		$userGateway = new UserGateway();
		$user = $userGateway->getBy('facebook_id', (int)$profile->id);
		if (!is_array($user) || !count($user))
		{
			Session::set('facebook_access_token', $accessToken);
			$redirectUrl = href(array('action' => 'user.facebook.register'));
			$request->setRedirect($redirectUrl);
			$request->redirect();
		}
 
		Session::set('facebook_access_token', $accessToken);
		Session::set('auth_user_id', $user['user_id']);
		$request->setRedirect($redirectUrl);
		$request->redirect();
 		exit;
 	}
 
 	$signedRequest = $request->param('signed_request');
 	if (!empty($signedRequest))
 	{
		$accessToken = Session::get('facebook_access_token');
		if(empty($accessToken))
		{
			$request->stop(lng('internal_error'));
		}
		$registerResponse = parseSignedRequest($signedRequest, $appSecret);
		$url = 'https://graph.facebook.com/me?access_token='. $accessToken;
		$result = @file_get_contents($url);
		$profile = json_decode($result);
		if (
			!is_object($profile) 
			|| !isset($profile->id)
			|| !isset($registerResponse['user_id'])
			|| $profile->id != $registerResponse['user_id']
			|| !isset($registerResponse['registration']['email'])
			|| empty($registerResponse['registration']['email'])
			|| !isset($profile->link)
			|| empty($profile->link)
			|| !isset($profile->first_name)
			|| empty($profile->first_name)
			|| !isset($profile->last_name)
			|| empty($profile->last_name)
		)
		{
			$request->stop(lng('internal_error'));
		}

		$request->set('user_email', $registerResponse['registration']['email']);
		$request->set('user_login', $registerResponse['registration']['email']);

		validateUserEmail($request);
		validateUniqueUsernameAndEmail($request);
		$request->trust();

		$data = array(
			'facebook_id' => $profile->id,
			'user_title' => $profile->first_name .' '. $profile->last_name,
			'user_login' => $registerResponse['registration']['email'],
			'user_email' => $registerResponse['registration']['email'],
			'user_status' => 'active',
			'activation_token' => randomToken(),
			'password' => 'facebook:'. md5(uniqid(mt_rand(), true)),
			'url' => $profile->link,
		);
		
		$userGateway = new UserGateway();
		$user = $userGateway->getBy('facebook_id', (int)$data['facebook_id']);
		if (is_array($user) && count($user))
		{
			Session::set('auth_user_id', $user['user_id']);
			$redirectUrl = href(array('action' => 'home'));
			$request->setRedirect($redirectUrl);
			$request->redirect();
		}

		if (!$userId = $userGateway->add($data))
		{
		        $request->stop(lng('internal_error'));
		}

		Session::set('auth_user_id', $userId);
 		$redirectUrl = href(array('action' => 'home'));
 		$request->setRedirect($redirectUrl);
		$request->redirect();
 	}
 
	$redirectUrl = 'https://www.facebook.com/dialog/oauth?client_id='. $appId .'&redirect_uri='. $appRedirectUrl;
	$request->setRedirect($redirectUrl);
 	$request->ok();