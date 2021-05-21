<?php

require('vendor/autoload.php');

use SaschaS93\ConventionRouting\Router;
use SaschaS93\ConventionRouting\RouterConfiguration;

$configuration = new RouterConfiguration();
$configuration->mainPageLocation = "ui/Index"; // Redirect to this location when no path was given
$configuration->controllerNamespace = "SaschaS93\\ConventionRoutingExample\\Controller\\"; // Namespace to search controller

$router = new Router($configuration);
$router->route();