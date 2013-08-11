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
$menuGateway = new MenuGateway;

if (!$menuGateway->reportCountBy("menu_key", "main"))
{
	$menuGateway->add(array(
		"menu_key" => "main",
		"menu_title" => lng_key("main_menu"),
		"menu_order" => 0
	));
}

if (!$menuGateway->reportCountBy("menu_key", "help"))
{
	$menuGateway->add(array(
		"menu_key" => "help",
		"menu_title" => lng_key("help"),
		"menu_order" => 1
	));
}

if (!$menuGateway->reportCountBy("menu_key", "about_us"))
{
	$menuGateway->add(array(
		"menu_key" => "about_us",
		"menu_title" => lng_key("about_us"),
		"menu_order" => 2
	));
}

if (!$menuGateway->reportCountBy("menu_key", "featured"))
{
	$menuGateway->add(array(
		"menu_key" => "featured",
		"menu_title" => lng_key("featured"),
		"menu_order" => 3
	));
}

$mainMenuId = $menuGateway->reportIdBy("menu_key", "main");
require_once PATH_TABLES.'menu_item.php';
$menuItemGateway = new MenuItemGateway();
$menuItemGateway->add(array(
	"menu_id" => $mainMenuId,
	"menu_item_title" => lng_key("homepage"),
	"menu_item_link" => "/",
	"menu_item_enabled" => "Y",
	"menu_item_order" => 0,
));