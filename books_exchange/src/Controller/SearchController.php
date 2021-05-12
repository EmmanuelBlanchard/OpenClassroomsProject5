<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="app_search")
     */
    public function index(Request $request): Response
    {
        $search = $request->query->get('q');
        $search = trim($search);

        if ($search === null || $search === '') {
            return $this->redirectToRoute('app_home');
        }
    }
}
