<?php

include "init.php";

// we need this header for ajax responses...
header('Content-Type: text/html; charset='.SITE_CHARSET);

doMagicQuotesGpc();

if(!isset($_POST['action']) || $_POST['action'] != 'template.manage.edit')
{
    cleanInput();
}

$data = array();
if ($_SERVER['REQUEST_METHOD'] == "POST")
{
	$data = $_POST;
}
else
{
	$data = $_GET;

	if (empty($data["action"]) && !empty($data["path"]))
	{
		$a = strstr($_SERVER["REQUEST_URI"], "?");
		parse_str(trim($a, "?"), $data);
		unset($a);
	}
}

$needRedirect = true;
if ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')/* || !empty($data["force_ajax"])*/)
{
	include_once PATH_CORE."request/AjaxRequest.php";
	$request = new AjaxRequest($data);
	$needRedirect = false;
}
elseif ($_SERVER['REQUEST_METHOD'] == "POST" || $_SERVER['REQUEST_METHOD'] == "GET")
{
	include_once PATH_CORE."request/ApiRequest.php";
	$request = new ApiRequest($data);
	$needRedirect = true;
}
else
{
	die("Invalid request format");
}

if (!$request->isAvailable()) $request->set('action', 'access-denied');

$request->run();

#$db = GetDB();
#$debug = $db->getDebug();
#file_put_contents(PATH."var/temp/api-".$data["action"]."-".date("Y-m-d-H-i-s").".txt", print_r($db->getDebug(), 1));

if ($needRedirect) $request->redirect();