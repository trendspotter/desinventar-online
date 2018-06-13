<?php
/**
 * DesInventar - http://www.desinventar.org
 * (c) Corporación OSSO
 */

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Aura\Session\SessionFactory;
use koenster\PHPLanguageDetection\BrowserLocalization;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\ErrorLogHandler;

use DesInventar\Common\Util;

require_once('../include/loader.php');
$portaltype = getParameter('portaltype', 'desinventar');
$t->assign('desinventarPortalType', $portaltype);

$app = new \Slim\App;

$container = $app->getContainer();
$container['session'] = function ($container) {
    $sessionFactory = new SessionFactory();
    return $sessionFactory->newInstance($_COOKIE);
};

$container['util'] = function ($container) {
    return new Util();
};

$container['logger'] = function () {
    $logger = new Logger('logger');
    $logger->pushHandler(new StreamHandler('php://stderr'));
    $logger->pushHandler(new ErrorLogHandler(ErrorLogHandler::OPERATING_SYSTEM, Logger::WARNING));
    return $logger;
};


$app->get('/', function (Request $request, Response $response, array $args) use ($container, $t, $config) {
    $session = $container['session']->getSegment('');
    $browser = new BrowserLocalization();
    $language = $session->get('language', $container['util']->getLangIsoCode($browser->detect()));
    $t->assign('lang', $language);
    $response->getBody()->write($t->fetch('index.tpl'));
    return $response;
});

$app->post('/change-language', function (Request $request, Response $response) use ($container) {
    $logger = $container['logger'];
    $body = $request->getParsedBody();
    $language = $body['language'];
    $session = $container['session']->getSegment('');
    $session->set('language', $language);
    return $response->withJson([]);
});

$app->run();
