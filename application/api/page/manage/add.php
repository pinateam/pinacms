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



$request->filterParams("strip_tags trim", "page_title");
$request->filterParams("filter_only_y_n", "page_enabled");

validateNotEmpty($request, 'page_title', lng('enter_page_title'));
validateNotEmpty($request, 'page_text', lng('enter_page_text'));
validateNotEmpty($request, 'page_enabled', lng('enter_status'));

require_once PATH_VALIDATION .'validation.url.php';
validateUrlNotUsed($request, "post.view", "post_id=");

$request->trust();

$data = array(
	'post_title' => $request->param('page_title'),
	'post_text' => $request->param('page_text'),
	'post_enabled' => $request->param('page_enabled'),
);

require_once PATH_TABLES .'post.php';
$postGateway = new PostGateway();
$pageId = $postGateway->add($data);

if (empty($pageId)) $request->stop(lng('internal_error'));

$request->set('url_action', 'page.view');
$request->set('url_params', 'page_id='.$pageId);

$request->run('meta.manage.set');
$request->run('config.manage.url-set');

$request->set('menu_item_title', $request->param("page_title"));
$request->set('menu_item_enabled', $request->param("page_enabled"));
$request->run('menu.manage.set-show');


$request->setRedirect(href(array('action' => 'page.manage.edit', 'page_id' => $pageId)));
$request->ok();