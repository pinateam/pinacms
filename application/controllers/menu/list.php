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



require_once PATH_TABLES."menu.php";

$menuGateway = new MenuGateway();

$m = $menuGateway->getBy("menu_key", $request->param("menu_key"));
if (empty($m))
{
	//create menu if not exists to user can configure it in admin area
	$menuGateway->add(array(
		"menu_key" => $request->param("menu_key"),
		"menu_title" => $request->param("title")?$request->param("title"):lng($request->param("menu_key")),
	));
}

$request->result("menu", $m);

$mis = array();
if (!empty($m["menu_id"]))
{
	require_once PATH_TABLES."menu_item.php";
	$menuItemGateway = new MenuItemGateway();
	$mis = $menuItemGateway->findBy("menu_id", $m["menu_id"]);
	foreach ($mis as $k => $v)
	{
		if ($v["menu_item_enabled"] != 'Y') unset($mis[$k]);
	}
	$mis = array_values($mis);
}
$request->result("menu_items", $mis);

$request->ok();