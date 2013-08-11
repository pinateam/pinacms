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



//depends of menu
@include_once PATH_INSTALL."menu/demo.php";

require_once PATH_TABLES.'menu_item.php';
$menuItemGateway = new MenuItemGateway();

require_once PATH_TABLES.'menu.php';
$menuGateway = new MenuGateway();

require_once PATH_TABLES."blog.php";
$blogGateway = new BlogGateway();
if (!$blogGateway->reportCountBy("blog_title", lng("blog")))
{
	$blogId = $blogGateway->add(array(
	    "blog_title" => lng("blog"),
	    "blog_public" => "Y",
	    "blog_enabled" => "Y"
	));

	$mainMenuId = $menuGateway->reportIdBy("menu_key", "main");
	$menuItemGateway->add(array(
		"menu_id" => $mainMenuId,
		"menu_item_title" => lng("blog"),
		"url_action" => "blog.view",
		"url_params" => "blog_id=".$blogId,
		"menu_item_enabled" => "Y",
		"menu_item_order" => 10,
	));

	$aboutMenuId = $menuGateway->reportIdBy("menu_key", "about_us");
	$menuItemGateway->add(array(
		"menu_id" => $aboutMenuId,
		"menu_item_title" => lng("blog"),
		"url_action" => "blog.view",
		"url_params" => "blog_id=".$blogId,
		"menu_item_enabled" => "Y",
		"menu_item_order" => 10,
	));
}