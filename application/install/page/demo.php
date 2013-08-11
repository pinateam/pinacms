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

$helpMenuId = $menuGateway->reportIdBy("menu_key", "help");

require_once PATH_TABLES."post.php";
$postGateway = new PostGateway;

if (!$postGateway->reportCountBy("post_title", "Privacy statement"))
{
	$postId = $postGateway->add(array(
		"blog_id" => 0,
		"post_title" => "Privacy statement",
		"post_text" => "<h3>Information Collection</h3>
	<p>We will only collect personally identifiable information (such as name, title, company name, address, telephone number, and e-mail address) that you voluntarily provide through our website. We will also collect general information (such as the type of the browser and that of the operational system you use) to improve the quality of the provided services and make them better meet your needs.</p>
	<h3>Use of Information</h3>
	<p>We use the contact information from the registration form to ship purchases, send newsletters from our company to customers and get into contact with them when necessary.</p>
	<p>Any information, files, databases, images and other property received and/or transferred from the client to Alex Yashin will be kept for development and services to the client. This information will not be used in any other way and is destroyed upon the completion of the project.</p>
	<p>External Links:This site contains links to other sites. Company is not responsible for the privacy practices or the content of such Web sites.</p>
	<p>We are reserving the right to modify this privacy policy at any time. We will promptly reflect any such modifications on our site.</p>
	<p>In the event of questions about this Privacy Statement, the practices of this site, or your dealings with this Web site, you can contact us through contact form.</p>",
		"post_enabled" => "Y"
	));


	$menuItemGateway->add(array(
		"menu_id" => $helpMenuId,
		"menu_item_title" => "Privacy statement",
		"url_action" => "page.view",
		"url_params" => "page_id=".$postId,
		"menu_item_enabled" => "Y",
		"menu_item_order" => 0,
	));
}

if (!$postGateway->reportCountBy("post_title", "Refund policy"))
{
	$postId = $postGateway->add(array(
		"blog_id" => 0,
		"post_title" => "Refund policy",
		"post_text" => "<p>Refunds are issued at the discretion of the company management within 30-days period after date of purchase. In your claim, please, include explanation of reasons for a refund, and your order information. Prior to ordering, please, make sure you have carefully read and understood the product's system requirements. If you are not sure about product compatibility, or have questions about product features, please contact our Client Support Service. All inquiries are free of charge. Upon confirmation of your request for a refund, you must also destroy all copies of the software you may have made or stored in any place, as well as uninstall the software from any computers owned or controlled by you where you have installed the software. All licenses you may have to use the software will be immediately terminated, and any further use of the software will be an infringement of copyrights as well as other intellectual property rights. No refunds are issued for provided services (including product installation, customization and software development) if provided services meet predefined specifications.</p>",
		"post_enabled" => "Y"
	));

	$menuItemGateway->add(array(
		"menu_id" => $helpMenuId,
		"menu_item_title" => "Refund policy",
		"url_action" => "page.view",
		"url_params" => "page_id=".$postId,
		"menu_item_enabled" => "Y",
		"menu_item_order" => 0,
	));
}