<?php

// index.php
// Defines routes for the application

require 'vendor/autoload.php';

session_start();

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__.'/');
$dotenv->load();

$dispatcher = simpleDispatcher(function(RouteCollector $r) 
{
    // Main Site Routes

    $r->addRoute('GET', '[/]', '/main/home.php');
    $r->addRoute('GET', '/premium', '/main/premium.php');
    $r->addRoute('GET', '/donate', '/main/donate.php');
    $r->addRoute('GET', '/terms', '/main/terms.php');
    $r->addRoute('GET', '/privacy', '/main/privacy.php');

    // Dashboard Routes
    
    $r->addRoute('GET', '/dashboard', '/dashboard/home.php');
    $r->addRoute('GET', '/dashboard/create-site', '/dashboard/create-site.php');
    $r->addRoute('POST', '/dashboard/create-site', '/dashboard/create-site.php');
    $r->addRoute('GET', '/dashboard/site/{siteid}', '/dashboard/site.php');
    $r->addRoute('POST', '/dashboard/site/{siteid}', '/dashboard/site.php');
    $r->addRoute('GET', '/dashboard/site/delete/{siteid}','/dashboard/deletesite.php');
    $r->addRoute('GET', '/dashboard/login', '/dashboard/login.php');
    $r->addRoute('POST', '/dashboard/login', '/dashboard/login.php');
    $r->addRoute('GET', '/dashboard/register', '/dashboard/register.php');
    $r->addRoute('POST', '/dashboard/register', '/dashboard/register.php');
    $r->addRoute('GET', '/dashboard/verify/{userid}', '/dashboard/verify.php');
    $r->addRoute('GET', '/dashboard/forgot-password', '/dashboard/forgot-password.php');
    $r->addRoute('POST', '/dashboard/forgot-password', '/dashboard/forgot-password.php');
    $r->addRoute('GET', '/dashboard/reset-password/{token}', '/dashboard/reset-password.php');
    $r->addRoute('POST', '/dashboard/reset-password/{token}', '/dashboard/reset-password.php');
    $r->addRoute('GET', '/dashboard/settings', '/dashboard/settings.php');
    $r->addRoute('POST', '/dashboard/settings', '/dashboard/settings.php');
    $r->addRoute('GET', '/dashboard/settings/delete-account/{userid}', '/dashboard/deleteaccount.php');
    $r->addRoute('GET', '/dashboard/logout', '/dashboard/logout.php');
    
});
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/');
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) 
{
    case \FastRoute\Dispatcher::FOUND:
        $page = $routeInfo[1];
        $vars = $routeInfo[2];

        foreach ($vars as $varName => $varValue) {
            ${$varName} = $varValue;
        }
        
        include(__DIR__ . '/public' . $page);
        break;

    case \FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        include(__DIR__ . '/public/404.php');
        break;

    case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        echo '<pre>Method not allowed.</pre>';
        break;
}
