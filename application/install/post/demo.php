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

//depends of blogs
@include_once PATH_INSTALL."blog/demo.php";

require_once PATH_TABLES."blog.php";
$blogGateway = new BlogGateway();
$blog_id = $blogGateway->reportIdBy("blog_enabled", 'Y');

require_once PATH_TABLES."post.php";
$postGateway = new PostGateway;

if (!$postGateway->reportCountBy("post_title", "What is PinaCart?"))
{
	$postGateway->add(array(
		"blog_id" => $blog_id,
		"post_title" => "What is PinaCart?",
		"post_text" => "<p>PinaCart is software that allows you to create and update a network of online stores. Moreover, you can use it for building your own ecommerce SaaS solution and offer your clients the power of a hosted multistore CMS. You get PinaCart complete with open source code, and it is up to you to decide whether you want to allow your clients to access it.</p>",
		"post_enabled" => "Y"
	));
}

if (!$postGateway->reportCountBy("post_title", "What makes it different?"))
{
	$postGateway->add(array(
		"blog_id" => $blog_id,
		"post_title" => "What makes it different?",
		"post_text" => "<p>Existing SaaS ecommerce systems are fully controlled by the developer, they are difficult to customize and expand. PinaCart is a quick and simple solution, which you only need to download and install to be able to start getting first clients. Develop and sell your own set of skins, templates and features.</p><p>PinaCart makes it possible to use widgets in any of your websites, not necessarily based on PinaCart or PinaCMS. Widgets are created automatically for all the active modules. They are reusable snippets of JavaScript code, which you can paste anywhere in your website code to be able to use the corresponding functionality. For example, you can display any category, page or product, a list of product reviews or a contact form on your website.</p>",
		"post_enabled" => "Y"
	));
}

if (!$postGateway->reportCountBy("post_title", "Gangman style"))
{
	$postGateway->add(array(
		"blog_id" => $blog_id,
		"post_title" => "Gangman style",
		"post_text" => '<p><iframe src="http://www.youtube.com/embed/60MQ3AG1c8o?rel=0" frameborder="0" width="853" height="480"></iframe></p>',
		"post_enabled" => "Y"
	));
}

