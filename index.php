<?php
// Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
session_start();
error_reporting(E_ALL^E_NOTICE);

require_once(realpath(__DIR__).'/conf/index.php');

require_once(realpath(__DIR__).'/req/lib_envcheck.php');

require_once(realpath(__DIR__).'/kotta.php');
