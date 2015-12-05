<?php

namespace Ace\CmsBundle\Controller\Event;

use Ace\CommonBundle\Entity\Repository\EventRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("", service="cms.controller.event.delete")
 */
class DeleteController extends Controller
{
    private $session;
    private $eventRepository;

    public function __construct(Session $session, EventRepository $eventRepository)
    {
        $this->session = $session;
        $this->eventRepository = $eventRepository;
    }

    /**
     * @param int $id
     *
     * @Route("/event/{id}/delete", name="cms.event.delete")
     *
     * @return RedirectResponse
     */
    public function indexAction($id)
    {
        $event = $this->eventRepository->find($id);

        if (!$event) {
            $this->session->getFlashBag()->add('error', 'Item was not found');

            return $this->redirectToRoute('cms.event.list');
        }

        $this->eventRepository->delete([$event], true);
        $this->session->getFlashBag()->add('success', 'Item has been deleted');

        return $this->redirectToRoute('cms.event.list');
    }
}
