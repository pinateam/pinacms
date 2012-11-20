<?php

/* vim: set ts=4 sw=4 sts=4 et: */
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| X-Cart                                                                      |
| Copyright (c) 2001-2011 Ruslan R. Fazlyev <rrf@x-cart.com>                  |
| All rights reserved.                                                        |
+-----------------------------------------------------------------------------+
| PLEASE READ  THE FULL TEXT OF SOFTWARE LICENSE AGREEMENT IN THE "COPYRIGHT" |
| FILE PROVIDED WITH THIS DISTRIBUTION. THE AGREEMENT TEXT IS ALSO AVAILABLE  |
| AT THE FOLLOWING URL: http://www.x-cart.com/license.php                     |
|                                                                             |
| THIS  AGREEMENT  EXPRESSES  THE  TERMS  AND CONDITIONS ON WHICH YOU MAY USE |
| THIS SOFTWARE   PROGRAM   AND  ASSOCIATED  DOCUMENTATION   THAT  RUSLAN  R. |
| FAZLYEV (hereinafter  referred to as "THE AUTHOR") IS FURNISHING  OR MAKING |
| AVAILABLE TO YOU WITH  THIS  AGREEMENT  (COLLECTIVELY,  THE  "SOFTWARE").   |
| PLEASE   REVIEW   THE  TERMS  AND   CONDITIONS  OF  THIS  LICENSE AGREEMENT |
| CAREFULLY   BEFORE   INSTALLING   OR  USING  THE  SOFTWARE.  BY INSTALLING, |
| COPYING   OR   OTHERWISE   USING   THE   SOFTWARE,  YOU  AND  YOUR  COMPANY |
| (COLLECTIVELY,  "YOU")  ARE  ACCEPTING  AND AGREEING  TO  THE TERMS OF THIS |
| LICENSE   AGREEMENT.   IF  YOU    ARE  NOT  WILLING   TO  BE  BOUND BY THIS |
| AGREEMENT, DO  NOT INSTALL OR USE THE SOFTWARE.  VARIOUS   COPYRIGHTS   AND |
| OTHER   INTELLECTUAL   PROPERTY   RIGHTS    PROTECT   THE   SOFTWARE.  THIS |
| AGREEMENT IS A LICENSE AGREEMENT THAT GIVES  YOU  LIMITED  RIGHTS   TO  USE |
| THE  SOFTWARE   AND  NOT  AN  AGREEMENT  FOR SALE OR FOR  TRANSFER OF TITLE.|
| THE AUTHOR RETAINS ALL RIGHTS NOT EXPRESSLY GRANTED BY THIS AGREEMENT.      |
|                                                                             |
| The Initial Developer of the Original Code is Ruslan R. Fazlyev             |
| Portions created by Ruslan R. Fazlyev are Copyright (C) 2001-2011           |
| Ruslan R. Fazlyev. All Rights Reserved.                                     |
+-----------------------------------------------------------------------------+
\*****************************************************************************/

/**
 * General statistics page interface
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Admin interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2011 Ruslan R. Fazlyev <rrf@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    $Id: product.php,v 1.0 2011/04/28 10:50:27 anachrenus Exp $
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

include $xcart_dir. '/include/lib/Excel/reader.php';
include $xcart_dir. '/include/lib/Excel/Writer.php'; 

// products in x-cart
$pnames = array(
	'Linen Amalfi Shirt  (short-sleeve)' => 'Linen Amalfi Shirt (SS)',
	'Linen Amalfi Shirt  (long-sleeve)' => 'Linen Amalfi Shirt (LS)',
);

function func_get_product_name($product) {
	global $pnames;
	
	if (empty($product))
		return '';
		
	if ($pnames[$product])
		return trim($pnames[$product]);
		
	return trim($product);	
}

function func_get_ordered_products($month, $year) {
	global $sql_tbl;
	
	$allow_statuses = array("P", "C");
	$begin_date = mktime(0, 0, 0, $month, 1, $year);//strtotime("$month/1/$year");
	if ($month == 12) {
		$year++;
		$month = 1;
	} else {
		$month++;
	}	
	$end_date = mktime(0, 0, 0, $month, 1, $year);//strtotime("$month/1/$year");
		
	$products = func_query("SELECT $sql_tbl[order_details].* FROM $sql_tbl[orders] LEFT JOIN $sql_tbl[order_details] ON $sql_tbl[order_details].orderid=$sql_tbl[orders].orderid WHERE $sql_tbl[orders].status IN('". implode("','", $allow_statuses) ."') AND $sql_tbl[orders].date >= '$begin_date' AND $sql_tbl[orders].date < '$end_date'");
	
	$_products = array();
	if ($products) {
		foreach ($products as $k=>$product) {
			$_products[$k] = array (
								'productid' => $product['productid'],
								'amount' => $product['amount'],
				);	
				
			if (!empty($product['extra_data'])) {
				$ed = unserialize($product['extra_data']);
				$options = $ed['product_options'];
				$_products[$k]['options'] = $options;
				$_products[$k]['variantid'] = func_get_variantid($options, $product['productid']);
			}	
		}
	}
		
	return $_products;
}

function func_get_category_products($cat) {
	global $sql_tbl, $xcart_dir, $smarty;
	
	if (!$cat)
		return array();
	
	$search_data['products'] = array(
    	'categoryid'              => $cat,
    	'search_in_subcategories' => 'Y',
    	'category_main'           => 'Y',
    );

    $sort = 'title';

	$mode = 'search';
	$products = array();
	$_inner_search = true;
	$do_not_use_navigation = true;
	$objects_per_page = 0;
	$current_area = 'A';
	include $xcart_dir . '/include/search.php';

	return $products;
}

function func_compare_products_sold($productid, $variantid, $products, $products_found, $month, $year = "") {

	$amount = 0;

	if (!$year)
		$year = date('Y');
		/*
	//first check existed spredsheet data
	$found = false;
	//($month < date('n') && $year == date('Y')) ===> (mktime(0,0,0, $month, 1, $year) < mktime(0,0,0, date('n'), 1, date('Y')))
	if (!empty($products_found) && (mktime(0,0,0, $month, 1, $year) < mktime(0,0,0, date('n'), 1, date('Y'))) ) {
		foreach ($products_found as $product) {
			if ($variantid) {
				if ($product['productid'] == $productid && $product['variantid'] == $variantid) {
					$amount += $product['columns'][3 + $month];
					$found = true;
				}	
			} else {
				if ($product['productid'] == $productid && !$product['variantid']) {
					$amount += $product['columns'][3 + $month];	
					$found = true;
				}	
			}	
		}
	}
		 */
	// <= !!!
	if (!empty($products) && !$found && (mktime(0,0,0, $month, 1, $year) <= mktime(0,0,0, date('n'), 1, date('Y')))) {
		foreach ($products as $product) {
			if ($variantid) {
				if ($product['productid'] == $productid && $product['variantid'] == $variantid)
					$amount += $product['amount'];
			} else {
				if ($product['productid'] == $productid && !$product['variantid'])
					$amount += $product['amount'];	
			}
		}

		//'on_hand' report data filling if we have not any data
		//please do not enabled it if you have filled 'on hand' report data already
		/*
		if (($month == date('n') && $year == date('Y')) && $month > 1 && false)
		{
			$now_on_hand = func_query_first_cell("SELECT amount FROM xcart_report_on_hand WHERE
				`productid`='".$productid."' AND
				`variantid`='".$variantid."' AND
				`year`='".$year."' AND
				`month`='".($month)."'
			");
			$old_on_hand = $now_on_hand + $amount;
			db_query("REPLACE INTO xcart_report_on_hand SET
				`productid`='".$productid."',
				`variantid`='".$variantid."',
				`year`='".$year."',
				`month`='".($month-1)."',
				`amount`='".$old_on_hand."'
			");
		}
		 */
		 
	} elseif (!$found && (mktime(0,0,0, $month, 1, $year) > mktime(0,0,0, date('n'), 1, date('Y')))) {
		$amount = "";
	} 

		
	return $amount;
}

function func_found_sheet_products($sheet) {
	global $sql_tbl; 
	
	// define startpoint
	$startrow = 5;
	$namepos = 1;
	
	$skupos = 2;
	
	$sizepos = 2;
	$colorpos = 3;
	$monthpos = 5;

	// reading cell function   	
	if (!function_exists("cell")) {
		function cell($x, $y) {
			global $sheet;
			return trim($sheet['cells'][$x][$y]);
		} 	
	}
	
	// existed in xls products
	$products_found = array();
	$not_recognized = array();
	
	if (!empty($sheet)) {
		// reading existed data
	
		$x = $startrow;
				
		while($x <= $sheet['numRows']) {
        	if (!cell($x, $namepos)) {
	  			$x++;
				continue;  // left empty rows
	  		}			
	
      		$is_empty = true;
	   		$y = $sizepos;
	  		while($y <= $sheet['numCols']) {
        		if (cell($x, $y)) {
					$is_empty = false;
					break;
				}
				$y++;
      		} 
	  
	  		$productid = '';
	  		if (!$is_empty) {    // found product row
 	  	 		$productcode = func_get_product_name(cell($x, $skupos));
		 		// find product id and variantid
		 
		 		$productid = func_query_first_cell("SELECT productid FROM $sql_tbl[products] WHERE productcode='$productcode'");
				$variantid = func_query_first_cell("SELECT variantid FROM $sql_tbl[variants] WHERE productcode='$productcode'");
				if ($variantid)
					$productid = func_query_first_cell("SELECT productid FROM $sql_tbl[variants] WHERE variantid='$variantid'");
				
				// echo $productid."<br>";
		 
		 		if (!$productid) {
		 			$not_recognized[$x] = $product;
					$x++;
		 			continue;  // skip line
		 		} else {
		 	 		$products_found[] = array(
										'row' => $x,
										'productid' => $productid,
										'variantid' => $variantid,
										'name' => $product,
								   );
				}	
		 				  
	  		}
			$x++;
    	}
	}
	
	// collect found products monthly data
	if ($products_found) {
		foreach ($products_found as $k=>$product) {
			$y = $monthpos;
			$products_found[$k]['columns'] = array();
			while($y <= $sheet['numCols']) {
				$products_found[$k]['columns'][$y] = cell($product['row'], $y); 
				
				$y++;
			}
			
			 
		}
	}

	return $products_found;
}

function func_generate_products_list($type, $products_found, $year = '') {
	global $sql_tbl;
		
	if (empty($type))
		$type = "PS";
	
	$ordered_products = array();
	if (!$year)
		$year = date('Y');
	
	if ($type == "PS") {
		for ($i = 1; $i < 13; $i++) { 
			$ordered_products[$i] = func_get_ordered_products($i, $year);
		}
	}
	x_load('category');	
	
	$_all_products = array();
		
	$categories = func_get_categories_list(0, true, true, 1);
	$_cats = array();
	$cp = $categories;
	foreach ($categories as $catid => $cat) {
		if ($cat['parentid']) {
			$_cats[] = array(
				'categoryid' => $catid,
				'category' => $cp[$cat['parentid']]['category']. " : ".$cat['category'],
			);
		}
	} 
	$categories = $_cats;
	
	foreach ($categories as $cat=>$category) {
		$_all_products[$category['category']] = array(); 
		$prods = func_get_category_products($category['categoryid']);
		foreach($prods as $prod) {
			if ($prod['custom_item_only'] == 'Y')
				continue;
		
			$_all_products[$category['category']][$prod['productid']] = array('name' => $prod['product']);
			$variants = func_get_product_variants($prod['productid']);
						
			if (!function_exists("sort_variants")) {
				function order_by_compare($a, $b) {
					$a = intval($a);
					$b = intval($b);
					
					if ($a == $b) {
						return 0;
					} elseif ($a < $b) {
						return -1;
					} else {
						return 1;
					}		
				}
			
				function sort_variants($a, $b) {
					foreach ($a["options"] as $ka=>$va) {
						if (strpos(strtolower($va['class']), 'color') !== false) {
							foreach ($b["options"] as $kb => $vb) {
								if (strpos(strtolower($vb['class']), 'color') !== false) {
									$res = order_by_compare($va["orderby"], $vb["orderby"]);
									if ($res) return $res;
									break;
								}
							}
						}
					}
	
					foreach ($a["options"] as $ka=>$va)	{
						if (strpos(strtolower($va['class']), 'size') !== false) {
							foreach ($b["options"] as $kb => $vb) {
								if (strpos(strtolower($vb['class']), 'size') !== false) {
									$res = order_by_compare($va["orderby"], $vb["orderby"]);
									if ($res) return $res;
									break;
								}
							}
						}
					}
					return 0;
				}
			}

			@uasort($variants, "sort_variants");

			if ($variants) {
				foreach ($variants as $variantid=>$variant) {
				
						$data = array();
						$total = 0;	
						for ($i=1; $i< 13; $i++) {
							if ($type == "PS") {
								$data[$i] = func_compare_products_sold($prod['productid'], $variantid, $ordered_products[$i], $products_found, $i, $year);
							} else {
								$data[$i] = func_compare_products_onhand($prod['productid'], $variantid, $products_found, $i, $year);
							}
							$total += $data[$i];
						}
							
						$_all_products[$category['category']][$prod['productid']]['variants'][$variantid] = array(
																										'options' => $variant['options'], 
																										'data' => $data, 
																										'total' => $total, 
																										'productcode' => func_query_first_cell("SELECT productcode FROM $sql_tbl[variants] WHERE variantid='$variantid'")
																									);
				}
			} else {
				$data = array();
				$total = 0;
				for ($i=1; $i< 13; $i++) {
					if ($type == "PS") {
						$data[$i] = func_compare_products_sold($prod['productid'], 0, $ordered_products[$i], $products_found, $i, $year);
					} else {
						$data[$i] = func_compare_products_onhand($prod['productid'], 0, $products_found, $i, $year);
					}	
					$total += $data[$i];
				}
				$_all_products[$category['category']][$prod['productid']]['data'] = $data;
				$_all_products[$category['category']][$prod['productid']]['total'] = $total;
				$_all_products[$category['category']][$prod['productid']]['productcode'] = func_query_first_cell("SELECT productcode FROM $sql_tbl[products] WHERE productid='$productid'");	
			}
			
		}
	
	}
		
	return $_all_products;
}

function func_save_products_data(&$excel, $_all_products, $type, $year) {
	
	if (empty($type))
		$type = "PS";
		
	if ($type == "PS")		
		$sheet =& $excel->addWorksheet('Products Sold');	
	else
		$sheet =& $excel->addWorksheet('Inventory On Hand');
	
	// set columns width
	
	$sheet->setColumn(0, 0, 40);
	$sheet->setColumn(1, 4, 20);
	$sheet->setColumn(5, 18, 12);
	
	$head =& $excel->addFormat();
	$head->setBold();
	$head->setSize(14);
	
	$title =& $excel->addFormat();
	$title->setBold();
	$title->setAlign('center');
	$title->setSize(10);
	
	$categ =& $excel->addFormat();
	$categ->setBold();
	$categ->setSize(12);
	
	$left_align =& $excel->addFormat();
	$left_align->setAlign('left');
	$left_align->setSize(10);
	
	$right_align =& $excel->addFormat();
	$right_align->setAlign('right');
	$right_align->setSize(10);
	
	$center_align =& $excel->addFormat();
	$center_align->setAlign('center');
	$center_align->setSize(10);
		
	// add data to worksheet
	if ($type == "PS")
		$sheet->write(0, 5, 'Product Sales '.$year, $head);
	else 
		$sheet->write(0, 5, 'Inventory On Hands '.$year, $head);
	
	$sheet->write(2, 0, 'Item name', $title);
	$sheet->write(2, 1, 'SKU', $title);
	$sheet->write(2, 2, '', $title);
	$sheet->write(2, 3, '', $title);
	$sheet->write(2, 4, '', $title);
	
	// draw table header
	$sheet->write(2, 5, 'January', $title);
	$sheet->write(2, 6, 'February', $title);
	$sheet->write(2, 7, 'March', $title);
	$sheet->write(2, 8, 'April', $title);
	$sheet->write(2, 9, 'May', $title);
	$sheet->write(2, 10, 'June', $title);
	$sheet->write(2, 11, 'July', $title);
	$sheet->write(2, 12, 'August', $title);
	$sheet->write(2, 13, 'September', $title);
	$sheet->write(2, 14, 'October', $title);
	$sheet->write(2, 15, 'November', $title);
	$sheet->write(2, 16, 'December', $title);
	
	if ($type == "PS")
		$sheet->write(2, 18, 'Total', $title);
		  
	// output products data	
	$crow = 4;
	foreach ($_all_products as $category=>$products) {
		if (empty($products))
			continue;
		$sheet->write($crow, 0, $category, $categ);
		$crow ++;
		foreach ($products as $productid=>$product) {
			if ($product['variants']) {
				$last_option = '';
				foreach ($product['variants'] as $variantid => $options) {
					foreach($options['options'] as $classid=>$option) {
						if (strpos(strtolower($option['class']), 'color') !== false) {
							if ($option['option_name'] != $last_option && $last_option)
								$crow++;
							$last_option = $option['option_name'];
						}		
					
					}
										
					$sheet->write($crow, 0, $product['name'], $left_align);
					$sheet->write($crow, 1, $product['variants'][$variantid]['productcode'], $left_align);
					foreach($options['options'] as $classiid=>$option) {
						if (strpos(strtolower($option['class']), 'size') !== false) {
							$sheet->write($crow, 2, $option['class'].' : '.$option['option_name'], $center_align);
						} elseif (strpos(strtolower($option['class']), 'color') !== false) {
							$sheet->write($crow, 3, $option['class'].' : '.$option['option_name'], $center_align);
						} else {
							$sheet->write($crow, 4, $option['class'].' : '.$option['option_name'], $center_align);
						}		
					
					}
					// write variants data
					$data = $options['data'];
					
					for ($i = 1; $i <=12; $i++) {
						$value = $data[$i];
						$sheet->write($crow, $i + 4, $value, $right_align);
					}
					
					// write total
					if ($type == "PS") {
						$sheet->write($crow, 18, $options['total'], $right_align);
					}
					$crow++;
				}
			} else {
				$sheet->write($crow, 0, $product['name'], $left_align);
				$sheet->write($crow, 1, $product['productcode'], $left_align);
				// write product data
				$data = $product['data'];
				
				for ($i = 1; $i <=12; $i++) {
					$value = $data[$i];
					$sheet->write($crow, $i + 4, $value, $right_align);
				}
				// write total
				if ($type == "PS") {
					$sheet->write($crow, 18, $product['total'], $right_align);
				}	
				
				$crow++;
												
			}
			$crow++;
		}
	}	
}
function func_compare_products_onhand($productid, $variantid, $products_found, $month, $year) {
	global $sql_tbl;
	
	$amount = 0;

	//first check existed spredsheet data
	$found = false;
	if (!empty($products_found) && (mktime(0,0,0, $month, 1, $year) < mktime(0,0,0, date('n'), 1, date('Y'))) ) {
		foreach ($products_found as $product) {
			if ($variantid) {
				if ($product['productid'] == $productid && $product['variantid'] == $variantid) {
					$amount = $product['columns'][3 + $month];
					$found = true;
				}	
			} else {
				if ($product['productid'] == $productid && !$product['variantid']) {
					$amount = $product['columns'][3 + $month];	
					$found = true;	
				}	
			}	
		}
	}
	
	if (!$found && (mktime(0,0,0, $month, 1, $year) == mktime(0,0,0, date('n'), 1, date('Y')))) {
		if ($variantid) {
			$amount = func_query_first_cell("SELECT avail FROM $sql_tbl[variants] WHERE variantid='$variantid' AND productid='$productid'");
		} else {
			$amount = func_query_first_cell("SELECT avail FROM $sql_tbl[products] WHERE productid='$productid'");	
		}

		db_query("REPLACE INTO xcart_report_on_hand SET
			`productid`='".$productid."',
			`variantid`='".$variantid."',
			`year`='".$year."',
			`month`='".$month."',
			`amount`='".$amount."'
		");
	} elseif (!$found && (mktime(0,0,0, $month, 1, $year) > mktime(0,0,0, date('n'), 1, date('Y')))) {
		$amount = "N/A";
	} else {
		$amount = func_query_first_cell("SELECT amount FROM xcart_report_on_hand WHERE
			`productid`='".$productid."' AND
			`variantid`='".$variantid."' AND
			`year`='".$year."' AND
			`month`='".$month."'
		");
		if (empty($amount)) $amount = '0';
	}
		
	return $amount;
}

?>