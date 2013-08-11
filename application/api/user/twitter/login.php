<?php
/*
* PinaCMS
*
* THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
* "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
* LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
* A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
* OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
* SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
* LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
* DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
* THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
* (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
* OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*
* @copyright © 2010 Dobrosite ltd.
*/
if (!defined('PATH')){ exit; }



	require_once PATH_TABLES .'user.php';
	require_once PATH_LIB .'twitteroauth/twitteroauth.php';

	if (Session::get('auth_user_id'))
	{
		$request->stop(lng('registration_is_disabled_because_you_are_signed_in'));
	}

	$config = getConfig();
	$consumerKey = $config->get('social', 'twitter_consumer_key');
	$consumerSecret = $config->get('social', 'twitter_consumer_secret');
	$accessToken = $config->get('social', 'twitter_access_token');
	$accessTokenSecret = $config->get('social', 'twitter_access_token_secret');
	$twitterCallbackUrl = href(array('api' => $config->get('social', 'twitter_callback_url')));
	if(
		empty($consumerKey)
		|| empty($consumerSecret)
		|| empty($accessToken)
		|| empty($accessTokenSecret)
		|| empty($twitterCallbackUrl)
	)
	{
		$request->stop(lng('internal_error'));
	}

	$userEmail = $request->param('user_email');
	if(isset($userEmail) && !empty($userEmail))
	{
		$oauthTokenParams = Session::get('twitter_oauth_token_params');
		if(
			!isset($oauthTokenParams['oauth_token'])
			|| !isset($oauthTokenParams['oauth_token_secret'])
			|| !isset($oauthTokenParams['user_id'])
			|| !isset($oauthTokenParams['screen_name'])
			|| $accessToken != $oauthTokenParams['oauth_token']
			|| $accessTokenSecret != $oauthTokenParams['oauth_token_secret']
		)
		{
			$request->stop(lng('internal_error'));
		}

		$request->set('user_email', $userEmail);
		$request->set('user_login', $userEmail);

		validateUserEmail($request);
		validateUniqueUsernameAndEmail($request);
		$request->trust();
		
		$userGateway = new UserGateway();
		$user = $userGateway->getBy('twitter_id', (int)$oauthTokenParams['user_id']);
		if (is_array($user) && count($user))
		{
			Session::set('auth_user_id', $user['user_id']);
			$redirectUrl = href(array('action' => 'home'));
			$request->setRedirect($redirectUrl);
			$request->redirect();
		}

		$connection = new TwitterOAuth($consumerKey, $consumerSecret, $oauthTokenParams['oauth_token'], $oauthTokenParams['oauth_token_secret']);
		$twitterUser = $connection->get('users/show/'. $oauthTokenParams['screen_name']);
		if(
			!is_object($twitterUser)
			|| !isset($twitterUser->id)
			|| empty($twitterUser->id)
			|| !isset($twitterUser->name)
			|| empty($twitterUser->name)
			|| !isset($twitterUser->screen_name)
			|| empty($twitterUser->screen_name)
		)
		{
			$request->stop(lng('internal_error'));
		}
		$data = array(
			'twitter_id' => (int)$twitterUser->id,
			'user_title' => $twitterUser->name,
			'user_login' => $userEmail,
			'user_email' => $userEmail,
			'user_status' => 'active',
			'activation_token' => randomToken(),
			'password' => 'twitter:'. md5(uniqid(mt_rand(), true)),
			'url' => 'https://twitter.com/'. $twitterUser->screen_name,
		);
		if (!$userId = $userGateway->add($data))
		{
		        $request->stop(lng('internal_error'));
		}

		Session::set('auth_user_id', $userId);

		$redirectUrl = href(array('action' => 'home'));
		$request->setRedirect($redirectUrl);
		$request->redirect();
	}

	$oauthToken = $request->param('oauth_token');
	if(!empty($oauthToken))
	{
		$twitterRequestToken = Session::get('twitter_request_token');
		Session::drop('twitter_request_token');
		if(
			!isset($twitterRequestToken['oauth_token']) 
			|| empty($twitterRequestToken['oauth_token'])
			|| !isset($twitterRequestToken['oauth_token_secret'])
			|| empty($twitterRequestToken['oauth_token_secret'])
		)
		{
			$request->stop(lng('internal_error'));
		}

		if($oauthToken != $twitterRequestToken['oauth_token'])
		{
			$request->stop(lng('interal_error'));
		}

		$connection = new TwitterOAuth($consumerKey, $consumerSecret, $twitterRequestToken['oauth_token'], $twitterRequestToken['oauth_token_secret']);
		$oauthVerifier = $request->param('oauth_verifier');
		$oauthTokenParams = $connection->getAccessToken($oauthVerifier);

		if(
			!isset($oauthTokenParams['oauth_token'])
			|| !isset($oauthTokenParams['oauth_token_secret'])
			|| !isset($oauthTokenParams['user_id'])
			|| !isset($oauthTokenParams['screen_name'])
			|| $accessToken != $oauthTokenParams['oauth_token']
			|| $accessTokenSecret != $oauthTokenParams['oauth_token_secret']
		)
		{
			$request->stop(lng('internal_error'));
		}

		$userGateway = new UserGateway();
		$user = $userGateway->getBy('twitter_id', (int)$oauthTokenParams['user_id']);
		if (!is_array($user) || !count($user))
		{
			//print_r($accessToken);die;
			Session::set('twitter_oauth_token_params', $oauthTokenParams);
			$redirectUrl = href(array('action' => 'user.twitter.register'));
			$request->setRedirect($redirectUrl);
			$request->redirect();
		}

		Session::set('auth_user_id', $user['user_id']);
		$request->setRedirect($redirectUrl);
		$request->redirect();
	}

	$connection = new TwitterOAuth($consumerKey, $consumerSecret);
	$requestToken = $connection->getRequestToken($twitterCallbackUrl);
	if(
		!isset($requestToken['oauth_token']) 
		|| empty($requestToken['oauth_token'])
		|| !isset($requestToken['oauth_token_secret'])
		|| empty($requestToken['oauth_token_secret'])
	)
	{
		$request->stop(lng('internal_error'));
	}

	$redirectUrl = href(array('action' => 'home'));
	switch ($connection->http_code) 
	{
		case 200:
			Session::set('twitter_request_token', $requestToken);
			/* Build authorize URL and redirect user to Twitter. */
			$redirectUrl = $connection->getAuthorizeURL($requestToken['oauth_token']);
			$request->setRedirect($redirectUrl);
		break;
		default:
			$redirectUrl = href(array('action' => 'home'));
			$request->setRedirect($redirectUrl);
		break;
	}

	$request->ok();