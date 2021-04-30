<?php

namespace App\Controller\Admin;

use App\Entity\State;
use App\Entity\Author;
use App\Entity\Format;
use App\Entity\Category;
use App\Entity\Language;
use App\Entity\Publisher;
use App\Form\StateFormType;
use App\Form\AuthorFormType;
use App\Form\FormatFormType;
use App\Form\CategoryFormType;
use App\Form\LanguageFormType;
use App\Form\PublisherFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin", name="admin_")
 * @package App\Controller\Admin
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

}
