<?php


namespace App;

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;


class Core
{
    protected RouteCollection $routes;

    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;

    }

    public function run()
    {
        $context = RequestContext::fromUri($_SERVER['REQUEST_URI']);
        $matcher    = new UrlMatcher($this->routes, $context);
        $parameters = $matcher->match($context->getBaseUrl());

        $controllerInfo = explode('::', $parameters['_controller']);
        $controller = new $controllerInfo[0];
        $action     = $controllerInfo[1];

        return $controller->$action();
    }
}
