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



$request->filterAllParams("trim");
$request->filterParams("filter_only_y_n", "blog_enabled");

validateNotEmpty($request, 'blog_title', lng('enter_blog_title'));
validateNotEmpty($request, 'blog_enabled', lng('enter_status'));

require_once PATH_VALIDATION .'validation.url.php';
validateUrlNotUsed($request, "blog.view", "blog_id=");

$request->trust();

require_once PATH_TABLES .'blog.php';
$blogGateway = new BlogGateway();
$blogId = $blogGateway->add($request->params("blog_title blog_enabled"));

if (!$blogId) $request->stop(lng('internal_error'));

$request->set('url_action', 'blog.view');
$request->set('url_params', 'blog_id='.$blogId);

$request->run('meta.manage.set');
$request->run('config.manage.url-set');

$request->set('menu_item_title', $request->param("blog_title"));
$request->set('menu_item_enabled', $request->param("blog_enabled"));
$request->run('menu.manage.set-show');

$request->setRedirect(href(array("action" => "blog.manage.edit", "blog_id" => $blogId)));
$request->ok();