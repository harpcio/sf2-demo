<?php

namespace Ace\CommonBundle\Security;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\AccessMap;

class RouteAcl
{
    private $accessMap;
    private $container;

    public function __construct(AccessMap $accessMap, ContainerInterface $container)
    {
        $this->accessMap = $accessMap;
        $this->container = $container;
    }

    public function getRoles($path)
    {
        $originRequest = $this->getRequest();
        $request = Request::create($path, 'GET', [], [], [], $originRequest->server->all());
        list($roles, $channel) = $this->accessMap->getPatterns($request);

        return $roles;
    }

    private function getRequest()
    {
        return $this->container->get('request');
    }
}