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
* @copyright � 2010 Dobrosite ltd.
*/

if (!defined('PATH')){ exit; }


	header('Content-Type: text/plain; charset=utf-8');
	
	echo 'Please, wait...', "\r\n";
	
	$xmlFilename = './import/products-examples-big.xml';
	$categoryLogoFilepath = './images/category_logo/test.jpg';
	$productImageLargeFilepath = './images/product_image_large/test.jpg';
	$productImageSmallFilepath = './images/product_image_small/test.jpg';
	
	$productAdditionalImagesFilepaths = array(
		'./images/product_image_large/test1.jpg',
		'./images/product_image_large/test2.jpg',
		'./images/product_image_large/test3.jpg'
	);
	
	// Здесь будем накапливать кол-во добавленных категорий и продуктов
	$insertedCategoryCount = 0;
	$insertedProductCount  = 0;
	
	// Будем считывать XML-файл построчно, чтобы не расходовать много памяти
	$f = fopen($xmlFilename, 'r');
	
	if ($f)
	{
		$db = getDB('001');
		
		// Очищаем таблицы категорий и продуктов
		$truncateTables = array(
			'cody_category',
			'cody_category_count',
			'cody_category_site',
			'cody_category_logo',
			'cody_product',
			'cody_product_buywith',
			'cody_product_category',
			'cody_product_description',
			'cody_product_image_large',
			'cody_product_image_small',
			'cody_product_site',
			'cody_product_param_value',
			'cody_product_review',
			'cody_product_recommended',
			'cody_product_variant',
		);
		
		foreach ($truncateTables as $truncateTable)
		{
			$db->query('TRUNCATE TABLE '.$truncateTable);
		}
		
		$db->query('DELETE FROM cody_attachment WHERE `obj_table` = "cody_product"');

		
		// Определяем ID у типа категории "category"
		$categoryTypeId = 1;
		/*$categoryTypeId = $db->one('
			SELECT
				category_type_id
			FROM
				cody_category_type
			WHERE
				category_type = "category"
		');*/
		
		while (($s = fgets($f)) !== false)
		{
			$s = ltrim($s);
			
			if (strpos($s, '<category id=') === 0)
			{
				$xmlStr = '
					<?xml version="1.0" encoding="windows-1251"?>
					<yml_catalog>
						<shop>
							<categories>'.$s.'</categories>
						</shop>
					</yml_catalog>
				';
				
				$xmlObj = simplexml_load_string(trim($xmlStr));
				
				$categoryId       = intval($xmlObj->shop->categories->category['id']);
				$categoryParentId = intval($xmlObj->shop->categories->category['parentId']);
				$categoryTitle    = $xmlObj->shop->categories->category;
				$categoryTitle    = $db->escape(mb_substr($categoryTitle, 0, 255, 'utf-8'));
				
				if ($categoryParentId > 0)
				{
					$parentPath = $db->one('
						SELECT
							category_path
						FROM
							cody_category
						WHERE
							category_id = '.$categoryParentId
					);
					
					$categoryPath = $parentPath.'-'.$categoryId;
				} else {
					$categoryPath = $categoryId;
				}
				
				$result = $db->query("
					INSERT INTO
						cody_category (
							category_id,
							category_parent_id,
							category_path,
							category_type_id
						) VALUES (
							'$categoryId',
							'$categoryParentId',
							'$categoryPath',
							'$categoryTypeId'
						)
				");
				
				if ($result)
				{
					$success = true;
					
					$result = $db->query("
						INSERT INTO
							cody_category_site (
								site_id,
								category_id,
								category_parent_id,
								category_type_id,
								category_title,
								category_description,
								category_href_title
							) VALUES (
								'".Site::id()."',
								'$categoryId',
								'$categoryParentId',
								'$categoryTypeId',
								'$categoryTitle',
								'$categoryTitle',
								'$categoryTitle'
							)
					");
					
					if (empty($result)) $success = false;
					
					$logoInfo = getimagesize($categoryLogoFilepath);
					
					$categoryLogo = basename($categoryLogoFilepath);
					$logoWidth    = $logoInfo[0];
					$logoHeight   = $logoInfo[1];
					$logoType     = $logoInfo['mime'];
					$logoSize     = filesize($categoryLogoFilepath);
					
					$result = $db->query("
						INSERT INTO
							cody_category_logo (
								site_id,
								category_id,
								logo_filename,
								logo_width,
								logo_height,
								logo_type,
								logo_size
							) VALUES (
								'".Site::id()."',
								'$categoryId',
								'$categoryLogo',
								'$logoWidth',
								'$logoHeight',
								'$logoType',
								'$logoSize'
							)
					");
					
					if (empty($result)) $success = false;
					
					if ($success)
					{
						++$insertedCategoryCount;
					}
					else
					{
						$db->query("
							DELETE FROM
								cody_category
							WHERE
								category_id = $categoryId
						");
						
						$db->query("
							DELETE FROM
								cody_category_site
							WHERE
								category_id = $categoryId
						");
						
						$db->query("
							DELETE FROM
								cody_category_logo
							WHERE
								category_id = $categoryId
						");
					}
				}
			}
			elseif (strpos($s, '</categories>') === 0)
			{
				break;
			}
		}
		
		// Считываем все продукты и записываем информацию о них
		// в таблицы cody_product, cody_product_category, cody_product_description,
		// cody_product_site
		$xml = '';
		
		$begin = false;
		$end   = false;
		
		while (($s = fgets($f)) !== false)
		{
			$s = ltrim($s);
			
			if (strpos($s, '<offer id=') === 0)
			{
				$begin = true;
				$end   = false;
			}
			elseif (strpos($s, '</offer>') === 0)
			{
				$begin = false;
				$end   = true;
			}
			
			if ($begin || $end)
			{
				$xml .= $s;
				
				if ($end)
				{
					$end = false;
					$xmlStr = '
						<?xml version="1.0" encoding="windows-1251"?>
						<yml_catalog>
							<shop>
								<offers>'.$xml.'</offers>
							</shop>
						</yml_catalog>
					';
					$xml = '';
					
					$xmlObj = simplexml_load_string(trim($xmlStr));
					
					$productId = intval($xmlObj->shop->offers->offer['id']);
					$productSaleAvailable = $xmlObj->shop->offers->offer['available'] == 'true' ? 'Y' : 'N';
					$productPrice = intval($xmlObj->shop->offers->offer->price);
					$productPriceOld = $productPrice + 100;
					$productTitle = $db->escape(!empty($xmlObj->shop->offers->offer->title) ? $xmlObj->shop->offers->offer->title : $xmlObj->shop->offers->offer->name);
					$productDescription = $db->escape($xmlObj->shop->offers->offer->description);
					
					$productTitle = mb_substr($productTitle, 0, 255, 'utf-8');
					$productShortDescription = mb_substr($productDescription, 0, 255, 'utf-8');
					
					if (!empty($productTitle))
					{
						$productAdded = true;
						
						// Устанавливаем базовую информацию о продукте
						$result = $db->query("
							INSERT INTO
								cody_product(
									product_id,
									product_box_w,
									product_box_h,
									product_box_l,
									product_box_qty,
									product_amount,
									product_min_amount
								) VALUES (
									'$productId',
									'0',
									'0',
									'0',
									'1',
									'100',
									'10'
								)
						");
						
						if (!$result) $productAdded = false;
						
						// Устанавливаем категории продукта
						if ($productAdded)
						{
							$categoryIsMain = 'Y';
							
							foreach ($xmlObj->shop->offers->offer->categoryId as $categoryId)
							{
								$categoryId = intval($categoryId);
								
								$result = $db->query("
									INSERT INTO
										cody_product_category(
											product_id,
											category_id,
											category_is_main
										) VALUES (
											'$productId',
											'$categoryId',
											'$categoryIsMain'
										)
								");
								
								if (!$result) $productAdded = false;
								
								$categoryIsMain = 'N';
							}
						}
						
						// Устанавливаем описание продукта
						if ($productAdded)
						{
							$result = $db->query("
								INSERT INTO
									cody_product_description(
										product_id,
										site_id,
										product_description
									) VALUES (
										'$productId',
										'".Site::id()."',
										'$productDescription'
									)
							");
							
							if (!$result) $productAdded = false;
						}
						
						// Устанавливаем большое основное изображение продукта
						if ($productAdded)
						{
							$imgInfo = getimagesize($productImageLargeFilepath);
					
							$imageLargeFilename = basename($productImageLargeFilepath);
							$imageLargeWidth    = $imgInfo[0];
							$imageLargeHeight   = $imgInfo[1];
							$imageLargeType     = $imgInfo['mime'];
							$imageLargeSize     = filesize($productImageLargeFilepath);
							
							$result = $db->query("
								INSERT INTO
									cody_product_image_large(
										site_id,
										product_id,
										image_large_filename,
										image_large_width,
										image_large_height,
										image_large_type,
										image_large_size,
										image_alt,
										image_is_main
									) VALUES (
										'".Site::id()."',
										'$productId',
										'$imageLargeFilename',
										'$imageLargeWidth',
										'$imageLargeHeight',
										'$imageLargeType',
										'$imageLargeSize',
										'',
										'Y'
									)
							");
							
							if (!$result) $productAdded = false;
						}
						
						// Устанавливаем дополнительные изображения продукта
						if ($productAdded)
						{
							foreach ($productAdditionalImagesFilepaths as $productAddImageFilepath) {
								$imgInfo = getimagesize($productAddImageFilepath);
					
								$imageLargeFilename = basename($productAddImageFilepath);
								$imageLargeWidth    = $imgInfo[0];
								$imageLargeHeight   = $imgInfo[1];
								$imageLargeType     = $imgInfo['mime'];
								$imageLargeSize     = filesize($productAddImageFilepath);
								
								$result = $db->query("
									INSERT INTO
										cody_product_image_large(
											site_id,
											product_id,
											image_large_filename,
											image_large_width,
											image_large_height,
											image_large_type,
											image_large_size,
											image_alt,
											image_is_main
										) VALUES (
											'".Site::id()."',
											'$productId',
											'$imageLargeFilename',
											'$imageLargeWidth',
											'$imageLargeHeight',
											'$imageLargeType',
											'$imageLargeSize',
											'',
											'N'
										)
								");
								
								if (!$result) $productAdded = false;
							}
						}
						
						// Устанавливаем малое изображение продукта
						if ($productAdded)
						{
							$imgInfo = getimagesize($productImageSmallFilepath);
					
							$imageSmallFilename = basename($productImageSmallFilepath);
							$imageSmallWidth    = $imgInfo[0];
							$imageSmallHeight   = $imgInfo[1];
							$imageSmallType     = $imgInfo['mime'];
							$imageSmallSize     = filesize($productImageSmallFilepath);
							
							$result = $db->query("
								INSERT INTO
									cody_product_image_small(
										site_id,
										product_id,
										image_small_filename,
										image_small_width,
										image_small_height,
										image_small_type,
										image_small_size
									) VALUES (
										'".Site::id()."',
										'$productId',
										'$imageSmallFilename',
										'$imageSmallWidth',
										'$imageSmallHeight',
										'$imageSmallType',
										'$imageSmallSize'
									)
							");
							
							if (!$result) $productAdded = false;
						}
						
						// Устанавливаем языкозависимые данные о продукте
						if ($productAdded)
						{
							$result = $db->query("
								INSERT INTO
									cody_product_site(
										product_id,
										site_id,
										product_code,
										product_price,
										product_price_old,
										product_available,
										product_sale_available,
										product_min_sale_amount,
										product_title,
										product_short_description,
										product_href_title
									) VALUES (
										'$productId',
										'".Site::id()."',
										'SKU$productId',
										'$productPrice',
										'$productPriceOld',
										'Y',
										'$productSaleAvailable',
										'0',
										'$productTitle',
										'$productShortDescription',
										'$productTitle'
									)
							");
							
							if (!$result) $productAdded = false;
						}
						
						if (!$productAdded) {
							$db->query("
								DELETE FROM
									cody_product
								WHERE
									product_id = $productId
							");
							
							$db->query("
								DELETE FROM
									cody_product_category
								WHERE
									product_id = $productId
							");
							
							$db->query("
								DELETE FROM
									cody_product_description
								WHERE
									product_id = $productId
							");
							
							$db->query("
								DELETE FROM
									cody_product_image_large
								WHERE
									product_id = $productId
							");
							
							$db->query("
								DELETE FROM
									cody_product_image_small
								WHERE
									product_id = $productId
							");
							
							$db->query("
								DELETE FROM
									cody_product_site
								WHERE
									product_id = $productId
							");
						} else {
							++$insertedProductCount;
						}
					}
				}
			}
		}
		
		fclose($f);
	}
	
	echo 'Done!', "\r\n";
	echo 'Inserted category count: ', $insertedCategoryCount, "\r\n";
	echo 'Inserted product count: ', $insertedProductCount, "\r\n";