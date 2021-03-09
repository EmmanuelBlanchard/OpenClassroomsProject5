<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookFormType;
use App\Form\EditProfileFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig');
    }

    /**
    * @Route("/user/book", name="user_book")
    */
    public function indexBook(): Response
    {
        return $this->render('user/book/index.html.twig');
    }

    /**
     * @Route("/user/book/add", name="user_book_add")
     */
    public function addBook(Request $request): Response
    {
        $book = new Book;
        $form = $this->createForm(BookFormType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book->setUser($this->getUser());
            $book->setActive(false);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            $this->addFlash('message', 'Le livre a été ajouté à votre stock !');
            return $this->redirectToRoute('user');
        }

        return $this->render('user/book/add.html.twig', [
            'addbookForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/profile/edit", name="user_profile_edit")
     */
    public function editProfile(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('message', 'Profil mis à jour');
            return $this->redirectToRoute('user');
        }
        return $this->render('user/editprofile.html.twig', [
            'editprofileForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/password/edit", name="user_password_edit")
     */
    public function editPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        if($request->isMethod('POST')) {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            // We check if the 2 passwords are identical
            if($request->request->get('password') == $request->request->get('password2')){
                $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
                $entityManager->flush();
                $this->addFlash('message', 'Mot de passe mis à jour avec succès');
                return $this->redirectToRoute('user');
            } else {
                $this->addFlash('error', 'Les deux mots de passe ne sont pas identiques');
            }
        }
        return $this->render('user/editpassword.html.twig');
    }
}
