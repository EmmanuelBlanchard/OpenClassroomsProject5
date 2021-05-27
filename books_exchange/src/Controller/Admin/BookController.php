<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Form\BookFormType;
use App\Service\UploaderHelper;
use App\Form\BookContactFormType;
use App\Repository\BookRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Route("/admin/book", name="admin_book_")
 * @package App\Controller\Admin
 */
class BookController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(BookRepository $bookRepo): Response
    {
        return $this->render('admin/book/index.html.twig', [
            'books' => $bookRepo->findAll()
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request, UploaderHelper $uploaderHelper): Response
    {
        $book = new Book;

        $form = $this->createForm(BookFormType::class, $book);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['imageFile']->getData();
            if ($uploadedFile) {
                $newFilename = $uploaderHelper->uploadBookImage($uploadedFile);
                $book->setImageFilename($newFilename);
            }
            
            $book->setUser($this->getUser());
            $book->setActive(true);
            $book->setExchangeRequest(false);
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('admin_book_home');
        }

        return $this->render('admin/book/add.html.twig', [
            'bookForm' => $form->createView()
        ]);
    }

    /**
    * @Route("/show/{slug}", name="show")
    */
    public function show($slug, BookRepository $bookRepo, Request $request, MailerInterface $mailer): Response
    {
        $book = $bookRepo->findOneBy(['slug' => $slug]);

        if (!$book) {
            throw new NotFoundHttpException('Pas de livre trouvé');
        }

        $form = $this->createForm(BookContactFormType::class);

        $contact = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // We create the mail
            $email = (new TemplatedEmail())
                ->from($contact->get('email')->getData())
                ->to($book->getUser()->getEmail())
                ->subject('Contact au sujet de votre livre "' . $book->getTitle() . '"')
                // path of the Twig template to render
                ->htmlTemplate('emails/contact_book.html.twig')
                // pass variables (name => value) to the template
                ->context([
                    'book' => $book,
                    'mail' => $contact->get('email')->getData(),
                    'message' => $contact->get('message')->getData()
                ]);
            // We send the mail
            $mailer->send($email);

            // We confirm and we redirect
            $this->addFlash('success', 'Votre e-mail a bien été envoyé');
            return $this->redirectToRoute('admin_book_show', ['slug' => $book->getSlug()]);
        }

        return $this->render('admin/book/show.html.twig', [
            'book' => $book,
            'contactBookForm' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/update/{id}", name="update")
     */
    public function update(Book $book, Request $request, UploaderHelper $uploaderHelper): Response
    {
        $form = $this->createForm(BookFormType::class, $book);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['imageFile']->getData();
            if ($uploadedFile) {
                $newFilename = $uploaderHelper->uploadBookImage($uploadedFile);
                $book->setImageFilename($newFilename);
            }

            $book->setUser($this->getUser());
            $book->setActive(true);
            $book->setExchangeRequest(false);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            $this->addFlash('message', 'Livre mis à jour');
            return $this->redirectToRoute('admin_book_home');
        }

        return $this->render('admin/book/update.html.twig', [
            'bookForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/add/exchange/{id}/", name="add_exchange")
     */
    public function addExchange(Book $book): Response
    {
        if ($book === null) {
            // Make a flash bag message
            $this->addFlash('error', 'Erreur : Aucun livre ne correspond');
        } else {
            $book->setActive(true);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();
            $this->addFlash('message', 'Livre ajouté aux échanges');
        }
        return $this->redirectToRoute('admin_book_home');
    }

    /**
     * @Route("/remove/exchange/{id}", name="remove_exchange")
     */
    public function removeExchange(Book $book): Response
    {
        if ($book === null) {
            // Make a flash bag message
            $this->addFlash('error', 'Erreur : Aucun livre ne correspond');
        } else {
            $book->setActive(false);
            $book->setExchangeRequest(false);
            $book->setUserexchange(null);
            $book->setExchangeRequestAt(new \DateTime('0000-00-00 00:00:00'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();
            $this->addFlash('message', 'Livre retiré des échanges');
        }
        return $this->redirectToRoute('admin_book_home');
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Book $book): Response
    {
        if ($book === null) {
            // Make a flash bag message
            $this->addFlash('error', 'Erreur : Aucun livre ne correspond');
        } else {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($book);
            $entityManager->flush();
            $this->addFlash('message', 'Livre supprimé avec succès');
        }
        return $this->redirectToRoute('admin_book_home');
    }
}
