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



$redirectAction = $request->param('redirect_action');

if (Session::get("auth_user_id"))
{
        if(!empty($redirectAction) && isModulePermitted($redirectAction))
        {
                redirect(href(array('action' => $redirectAction)));
        }
	elseif (isModuleActive("order.cart") && isModulePermitted("order.cart"))
	{
		redirect(href(array("action" => "order.cart")));
	}
	elseif (isModuleActive("dashboard") && isModulePermitted("dashboard"))
	{
		redirect(href(array("action" => "dashboard")));
	}
	else
	{
		redirect(href(array("action" => "home")));
	}
}

$request->result('redirect_action', $redirectAction);

$config = getConfig();
$facebookAppId = $config->get('social', 'facebook_app_id');
$facebookAppSecret = $config->get('social', 'facebook_app_secret');
$facebookRedirectUrl = href(array('api' => $config->get('social', 'facebook_redirect_url')));
if(!empty($facebookAppId) && !empty($facebookAppSecret) && !empty($facebookRedirectUrl))
{
	$request->result('facebook', true);
}

$twitterConsumerKey = $config->get('social', 'twitter_consumer_key');
$twitterConsumerSecret = $config->get('social', 'twitter_consumer_secret');
$twitterCallbackUrl = href(array('api' => $config->get('social', 'twitter_callback_url')));
if(
	!empty($twitterConsumerKey) 
	&& !empty($twitterConsumerSecret) 
	&& !empty($twitterCallbackUrl)
)
{
	$request->result('twitter', true);
}

$request->ok();