<?php

namespace Ace\CmsBundle\Controller\Blog;

use Ace\CommonBundle\Entity\Repository\BlogRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("", service="cms.controller.blog.list")
 */
class ListController extends Controller
{
    private $blogRepository;

    public function __construct(BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    /**
     * @Route("/blog", name="cms.blog.list")
     * @Template("AceCmsBundle:Blog:list.html.twig")
     */
    public function indexAction()
    {
        $result = $this->blogRepository->findAll();

        return [
            'blogs' => $result
        ];
    }
}
