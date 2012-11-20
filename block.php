<?php

include "init.php";

// we need this header for ajax responses...
@header('Content-Type: text/html; charset='.SITE_CHARSET);

doMagicQuotesGpc();
cleanInput();

$data = ($_SERVER['REQUEST_METHOD'] == "POST")?$_POST:$_GET;

include PATH_CORE."classes/Breadcrumbs.php";
include_once PATH_CORE."request/BlockRequest.php";

$request = new BlockRequest(null, $data);

echo $request->run();

#$db = GetDB();
#$debug = $db->getDebug();
#file_put_contents(PATH."var/temp/block-".$data["action"]."-".date("Y-m-d-H-i-s").".txt", print_r($db->getDebug(), 1));