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



ini_set("memory_limit", "128M");

require_once PATH_TABLES."url.php";
$urlGateway = new UrlGateway;

require_once PATH_CORE."core.latin.php";

$db = getDB();

$step = 1000;

$pos = 0;
$count = $db->one("SELECT count(*) FROM cody_category_site");

echo "<h1>Generate categories</h1>";

$cond = '';


$cond .= "AND site_id = '".Site::id()."'";


while ($pos < $count)
{
	$cs = $db->table("SELECT category_id, category_title FROM cody_category_site WHERE 1 ".$cond." LIMIT ".$pos.",".$step);

	foreach ($cs as $c)
	{
		$key = $urlGateway->reportKey("category.view", "category_id=".$c["category_id"]);
		if (empty($key))
		{
			$key = latin_generateToken($c["category_title"]);
			$key = strtolower($key);

			$originalKey = $key;
			$index = 1;
			while ($urlGateway->getBy("url_key", $key))
			{
				$key = $originalKey.$index;
				$index ++;
			}

			$urlGateway->add($key, "category.view", "category_id=".$c["category_id"]);
		}
	}

	echo ".";flush();
	$pos += $step;
}


echo "<h1>Generate products</h1>";

require_once PATH_MODEL."finder/product.php";
$productFinder = new ProductFinder;

$pos = 0;
$count = $db->one("SELECT count(*) FROM cody_product_site");

while ($pos < $count)
{
	$ps = $db->table("SELECT product_id, product_code, product_title FROM cody_product_site WHERE 1 ".$cond." LIMIT ".$pos.",".$step);
	$ps = $productFinder->joinManufacturer($ps);

	foreach ($ps as $p)
	{
		$key = $urlGateway->reportKey("product.view", "product_id=".$p["product_id"]);
		if (empty($key))
		{
			$key = latin_generateToken($p["manufacturer_title"]."-".$p["product_code"]."-".$p["product_title"]);
			$key = strtolower($key);
			if (strlen($key) > 60)
			{
				$key = substr($key, 0, 60);
				$i = strrpos($key, "-");
				if (!empty($i))
				{
					$key = substr($key, 0, $i);
				}
			}

			$originalKey = $key;
			$index = 1;
			while ($urlGateway->getBy("url_key", $key))
			{
				$key = $originalKey."-".$index;
				$index ++;
			}

			$urlGateway->add($key, "product.view", "product_id=".$p["product_id"]);
		}
	}

	echo ".";flush();
	$pos += $step;
}

echo 'done';