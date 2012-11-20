<?php

    include "init.php";
    include PATH_TABLES .'category.php';
    include PATH_TABLES .'product.php';

    if (Site::domain() && Site::domain() != $_SERVER["HTTP_HOST"])
    {
	    redirect(Site::baseUrl(Site::id()));
    }

    $categoryGateway = new CategoryGateway();
    $productGateway = new ProductGateway();

    switch (Site::path())
    {
        case 'radioniks-ru':
            $requestUri = $_SERVER['REQUEST_URI'];

            preg_match('#cPath=([^&]*)#', $requestUri, $matches);
            if(isset($matches[1]) && !empty($matches[1]))
            {
                $cPath = explode('_', $matches[1]);
                $importedId = array_pop($cPath);
                $catId = $categoryGateway->getIdByImortedId($importedId);
                redirect(href(array(
                        'action' => 'category.view',
                        'category_id' => $catId
                )));
            }

            preg_match('#products_id=([^&]*)#', $requestUri, $matches);
            if(isset($matches[1]) && !empty($matches[1]))
            {
                $prodId = $productGateway->getIdByImortedId($matches[1]);
                redirect(href(array(
                        'action' => 'product.view',
                        'product_id' => $prodId
                )));
            }

        break;
        default:
            redirect(Site::baseUrl(Site::id()));
        break;
    }