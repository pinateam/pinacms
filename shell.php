<?php

    if (!empty($_SERVER["HTTP_HOST"])) die('access-denied');

    include "init.php";

    include_once PATH_CORE."request/ApiRequest.php";

    $data = array();
    if (is_array($argv))
    foreach ($argv as $v)
    {
        $param = explode('=', $v);
        if (count($param) != 2)
        {
            continue;
        }

        $data[$param[0]] = $param[1];
    }

    $request = new ApiRequest($data);
    $action = $request->getHandler();
    if (!file_exists(PATH_API.$action.".php"))
    {
        if (file_exists(PATH_CONTROLLERS."fatal-error.php"))
        {
            require_once PATH_CONTROLLERS."fatal-error.php";
        }
        exit;
    }

    require_once PATH_API.$action.".php";
