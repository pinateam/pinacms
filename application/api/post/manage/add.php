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



$request->filterParams("intval", "blog_id");
$request->filterParams("strip_tags trim", "post_title");
$request->filterParams("filter_only_y_n", "post_enabled");

validateNotEmpty($request, 'post_title', lng('enter_post_title'));
validateNotEmpty($request, 'post_text', lng('enter_post_text'));
validateNotEmpty($request, 'post_enabled', lng('enter_status'));
validateNotEmpty($request, 'blog_id', lng('enter_blog'));

$request->trust();

require_once PATH_TABLES .'post.php';

$params = $request->params("blog_id post_title post_text post_enabled");
$params['site_id'] = Site::id();

$postGateway = new PostGateway();
$postId = $postGateway->add($params);

if(!$postId)
{
	$request->stop(lng('internal_error'));
}

require_once PATH_DOMAIN."photo.php";
PhotoDomain::updatePhotosPostId($request->param('post_text'), $postId);

$request->set('url_action', 'post.view');
$request->set('url_params', 'post_id='.$postId);

$request->set('menu_item_title', $request->param("post_title"));
$request->set('menu_item_enabled', $request->param("post_enabled"));
$request->run('menu.manage.set-show');

include PATH_LIB."twitteroauth/twitteroauth.php";

$config = getConfig();
if ($config->get('social', 'twitter_consumer_key') &&
    $config->get('social', 'twitter_consumer_secret') &&
    $config->get('social', 'twitter_oauth_token') &&
    $config->get('social', 'twitter_oauth_secret')
)
{
	$connection = new TwitterOAuth(
		$config->get('social', 'twitter_consumer_key'),
		$config->get('social', 'twitter_consumer_secret'),
		$config->get('social', 'twitter_oauth_token'),
		$config->get('social', 'twitter_oauth_secret')
	);
	$content = $connection->get('account/verify_credentials');

	$connection->post('statuses/update', array('status' =>
		strip_tags($request->param('post_title'))." ".
		href(array("action" => "post.view", "post_id" => $postId))
	));
}

$request->setRedirect(href(array("action" => "post.manage.edit", "post_id" => $postId)));
$request->ok();