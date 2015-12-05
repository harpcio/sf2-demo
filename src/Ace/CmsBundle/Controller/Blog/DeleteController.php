<?php

namespace Ace\CmsBundle\Controller\Blog;

use Ace\CommonBundle\Entity\Repository\BlogRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("", service="cms.controller.blog.delete")
 */
class DeleteController extends Controller
{
    private $session;
    private $blogRepository;

    public function __construct(Session $session, BlogRepository $blogRepository)
    {
        $this->session = $session;
        $this->blogRepository = $blogRepository;
    }

    /**
     * @param int $id
     *
     * @Route("/blog/{id}/delete", name="cms.blog.delete")
     *
     * @return RedirectResponse
     */
    public function indexAction($id)
    {
        $blog = $this->blogRepository->find($id);

        if (!$blog) {
            $this->session->getFlashBag()->add('error', 'Item was not found');

            return $this->redirectToRoute('cms.blog.list');
        }

        $this->blogRepository->delete([$blog], true);
        $this->session->getFlashBag()->add('success', 'Item has been deleted');

        return $this->redirectToRoute('cms.blog.list');
    }
}
