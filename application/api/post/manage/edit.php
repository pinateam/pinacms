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



$request->filterParams("intval", "post_id blog_id");
$request->filterParams("strip_tags trim", "post_title");
$request->filterParams("filter_only_y_n", "post_enabled");

validateNotEmpty($request, 'post_id', lng('internal_error'));

validateNotEmpty($request, 'post_title', lng('enter_post_title'));
validateNotEmpty($request, 'post_text', lng('enter_post_text'));
validateNotEmpty($request, 'post_enabled', lng('enter_status'));
validateNotEmpty($request, 'blog_id', lng('enter_blog'));

$request->trust();

$postId = $request->param('post_id');

require_once PATH_TABLES .'post.php';
$postGateway = new PostGateway();

$postGateway->edit($postId, $request->params("blog_id post_title post_text post_enabled"));

require_once PATH_DOMAIN."photo.php";
PhotoDomain::updatePhotosPostId($request->param('post_text'), $postId);

$request->set('url_action', 'post.view');
$request->set('url_params', 'post_id='.$postId);

$request->run('meta.manage.set');
$request->run('config.manage.url-set');

$request->set('menu_item_title', $request->param("post_title"));
$request->set('menu_item_enabled', $request->param("post_enabled"));
$request->run('menu.manage.set-show');

$request->ok();