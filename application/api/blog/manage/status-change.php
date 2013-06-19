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



$request->filterAllParams("strip_tags trim");
$request->filterParams("intval", "blog_id");
$request->filterParams("filter_only_y_n", "status");

validateNotEmpty($request, "status", lng("enter_status"));
validateNotEmpty($request, "blog_id", lng("access_denied"));

$request->trust();

require_once PATH_TABLES .'blog.php';
$blogGateway = new BlogGateway();	
$data = array(
	'blog_enabled' => ($request->param('status') == 'Y') ? 'Y' : 'N',
);
$blogGateway->edit($request->param('blog_id'), $data);

$request->set('menu_item_enabled', $request->param("status"));
$request->set('url_action', 'blog.view');
$request->set('url_params', 'blog_id='.$request->param('blog_id'));
$request->run('menu.manage.set-show-status');

$request->ok();