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



validateNotEmpty($request, "url_action", lng("internal_error"));

$request->trust();

require_once PATH_TABLES."menu_item.php";

$menuItemGateway = new MenuItemGateway;
$mids = $menuItemGateway->reportMenuIdsByActionAndParams(
	$request->param("url_action"), $request->param("url_params")
);

$menuIds = mineArray("menu_show_", $request->params());

$toAdd = array();
$toRemove = array();
$toUpdate = array();
foreach ($menuIds as $menuId => $flag)
{
	if ($flag == "Y" && !in_array($menuId, $mids))
	{
		$toAdd [] = $menuId;
	}
	elseif ($flag == "N" && in_array($menuId, $mids))
	{
		$toRemove [] = $menuId;
	}
}

$order = $menuItemGateway->reportMaxOrder();

foreach ($toAdd as $menuId)
{
	$order ++;
	$menuItemGateway->add(array(
		"site_id" => Site::id(),
		"menu_id" => $menuId,
		"menu_item_title" => $request->param("menu_item_title"),
		"menu_item_link" => "",
		"url_action" => $request->param("url_action"),
		"url_params" => $request->param("url_params"),
		"menu_item_enabled" => $request->param("menu_item_enabled"),
		"menu_item_order" => $order
	));
}

foreach ($toRemove as $menuId)
{
	$menuItemGateway->removeByMenuIdAndActionAndParams(
		$menuId, $request->param("url_action"), $request->param("url_params")
	);
}

if ($request->param("menu_item_enabled"))
{
	$menuItemGateway->editByActionAndParams($request->param("url_action"), $request->param("url_params"), array("menu_item_enabled" => $request->param("menu_item_enabled")));
}