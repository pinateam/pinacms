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

require_once PATH_DOMAIN."image.php";

require_once PATH_TABLES."person.php";
$personGateway = new PersonGateway;

if (!$personGateway->reportCountBy("person_title", "Lev Tolstoy"))
{
	$imageId = ImageDomain::saveCopy(
		PATH .'import/demo/lev-tolstoy.png',
		"lev-tolstoy.png"
	);

	$personGateway->add(array(
		"image_id" => $imageId,
		"person_title" => "Lev Tolstoy",
		"person_description" => "<p><span>Tolstoy was born in Yasnaya Polyana, the family estate in the Tula region of Russia. The Tolstoys were a well-known family of old Russian nobility. He was the fourth of five children of Count Nikolai Ilyich Tolstoy, a veteran of the Patriotic War of 1812, and Countess Mariya Tolstaya (Volkonskaya). Tolstoy's parents died when he was young, so he and his siblings were brought up by relatives. In 1844, he began studying law and oriental languages at Kazan University. His teachers described him as \"both unable and unwilling to learn.\" Tolstoy left university in the middle of his studies, returned to Yasnaya Polyana and then spent much of his time in Moscow and Saint Petersburg. In 1851, after running up heavy gambling debts, he went with his older brother to the Caucasus and joined the army. It was about this time that he started writing.</span></p>",
		"person_enabled" => "Y"
	));
}

if (!$personGateway->reportCountBy("person_title", "Ivan Goncharov"))
{
	$imageId = ImageDomain::saveCopy(
		PATH .'import/demo/ivan-goncharov.jpg',
		"ivan-goncharov.jpg"
	);

	$personGateway->add(array(
		"image_id" => $imageId,
		"person_title" => "Ivan Goncharov",
		"person_description" => "<p>Ivan Goncharov was born in Simbirsk (now Ulyanovsk); his father was a wealthy grain merchant and respected official who was elected mayor of Simbirsk several times.</p>
<p>Throughout the 1850s Goncharov was working on his second novel, but the process was slow for many reasons. In 1855 he took the post of a censor in the Saint Petersburg censorship committee. In this capacity he's done a lot of good: helped publish important works by Ivan Turgenev, Nikolay Nekrasov, Aleksey Pisemsky and Fyodor Dostoyevsky, which caused resentment by some of his bosses. According to Pisemsky, for giving a permission for his A Thousand Souls novel to be published, Goncharov has been officially reprimanded. Despite of all this, Goncharov has found himself a target of many satires and got a negative mention in Hertzen's Kolokol. \"One of the best Russian author shouldn&rsquo;t have taken upon himself this sort of a job\", critic Aleksander Druzhinin wrote in his diary. In 1856, as the official line in the publishing policy hardened, Goncharov quit the job.</p>",
		"person_enabled" => "Y"
	));
}


require_once PATH_TABLES.'menu_item.php';
$menuItemGateway = new MenuItemGateway();

require_once PATH_TABLES.'menu.php';
$menuGateway = new MenuGateway();

$mainMenuId = $menuGateway->reportIdBy("menu_key", "main");
$menuItemGateway->add(array(
	"menu_id" => $mainMenuId,
	"menu_item_title" => lng("team"),
	"url_action" => "person.home",
	"url_params" => "",
	"menu_item_enabled" => "Y",
	"menu_item_order" => 20,
));

$aboutMenuId = $menuGateway->reportIdBy("menu_key", "about_us");
$menuItemGateway->add(array(
	"menu_id" => $aboutMenuId,
	"menu_item_title" => lng("team"),
	"url_action" => "person.home",
	"url_params" => "",
	"menu_item_enabled" => "Y",
	"menu_item_order" => 20,
));