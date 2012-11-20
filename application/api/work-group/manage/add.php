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



$request->filterParams("strip_tags trim", "work_group_title");
$request->filterParams("filter_only_y_n", "work_group_enabled");

validateNotEmpty($request, "work_group_title", lng('enter_title'));

require_once PATH_VALIDATION .'validation.url.php';
validateUrlNotUsed($request, "work-group.view", "work_group_id=");

$request->trust();

$request->set("site_id", Site::id());

require_once PATH_TABLES .'work_group.php';
$workGroupGateway = new WorkGroupGateway();
$work_group_id = $workGroupGateway->add($request->params());

$request->set('work_group_id', $work_group_id);

require_once PATH_TABLES.'work_group_image.php';
$workGroupImageGateway = new WorkGroupImageGateway();

require_once PATH_DOMAIN.'image.php';
ImageDomain::save("work_group_image_".Site::id(), "work_group_image", $workGroupImageGateway, 
	$work_group_id, $request->params()
);

$request->set('url_action', 'work-group.view');
$request->set('url_params', 'work_group_id='.$work_group_id);

$request->run('meta.manage.set');
$request->run('config.manage.url-set');

$request->set('menu_item_title', $request->param("work_group_title"));
$request->set('menu_item_enabled', $request->param("work_group_enabled"));
$request->run('menu.manage.set-show');

$request->setRedirect(href(array("action" => "work-group.manage.edit", "work_group_id" => $work_group_id)));
$request->ok();
