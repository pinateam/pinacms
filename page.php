<?php

include "init.php";

if (Site::domain() && Site::domain() != $_SERVER["HTTP_HOST"])
{
	redirect(Site::baseUrl(Site::id()));
}

include PATH_CORE."core.dispatcher.php";
include PATH_CORE."classes/Breadcrumbs.php";
include PATH_CORE."request/PageRequest.php";
include PATH_CORE."request/BlockRequest.php";

$data = $_GET;

if (empty($data["action"]) && empty($data["path"]) && !empty($data["dispatch"]))
{
	$data = dispatch($data["dispatch"]);
}
elseif (empty($data["action"]) && !empty($data["path"]))
{
	$a = strstr($_SERVER["REQUEST_URI"], "?");
	parse_str(trim($a, "?"), $data);
	unset($a);
}
elseif (empty($data["action"]) && empty($data["dispatch"]))
{
	$data["action"] = "home";
}

$request = new PageRequest($data);
if (!empty($data['printable']))
{
	$request->setLayout("print");
}

if ($config->get("core", "frontend_status") == "closed" && strpos($action, "manage") === false && strpos($action, "dashboard") === false)
{
	require_once PATH_CONTROLLERS."closed.php";
	exit;
}

$request->run();

#$db = GetDB();
#$debug = $db->getDebug();
#file_put_contents(PATH."var/temp/page-".$data["action"]."-".date("Y-m-d-H-i-s").".txt", print_r($db->getDebug(), 1));
