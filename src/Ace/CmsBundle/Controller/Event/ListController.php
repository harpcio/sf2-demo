<?php

namespace Ace\CmsBundle\Controller\Event;

use Ace\CommonBundle\Entity\Repository\EventRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("", service="cms.controller.event.list")
 */
class ListController extends Controller
{
    private $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * @Route("/event", name="cms.event.list")
     * @Template("AceCmsBundle:Event:list.html.twig")
     */
    public function indexAction()
    {
        $result = $this->eventRepository->findAll();

        return [
            'events' => $result
        ];
    }
}
