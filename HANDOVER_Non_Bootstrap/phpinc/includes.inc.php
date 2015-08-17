<?php

/**
 * FILES TO BE INCLUDES
 */
require_once 'config.inc.php';
require_once 'mvc/model.php';
require_once 'mvc/controller.php';
require_once 'mvc/controller_auth.php';
require_once 'mvc/controller_helper_functions.php';
require_once 'vendor/setup_twig.php';
require_once 'vendor/Epi/Epi.php';

/**
 * CLASS FILES
 */
require_once 'classes/Database.class.php'; # for database connectivity
require_once 'classes/DBPager.class.php'; # for paging of results
require_once 'classes/DataObject.class.php'; # for building JSON Output