<?php
/**
 * Created by PhpStorm.
 * User: matt
 * Date: 27/09/2014
 * Time: 08:17
 */
// Twig functions
require_once 'Twig/Autoloader.php';

// ------------------
// TWIG setup
// ------------------
// set up the templating object: $twig
Twig_Autoloader::register();
$pathToMyTwigTemplates = 'mvc/templates';
$loader = new Twig_Loader_Filesystem( $pathToMyTwigTemplates );
$cacheOptionArray = array('cache' => false);

$twig = new Twig_Environment($loader, $cacheOptionArray);

global $twig;
