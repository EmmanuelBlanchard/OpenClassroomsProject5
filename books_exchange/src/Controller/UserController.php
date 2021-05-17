<?php

namespace App\Controller;

use App\Form\UpdateEmailFormType;
use App\Form\UpdateProfileFormType;
use App\Form\UpdatePasswordFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

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
    * @Route("/user/profile/update", name="user_profile_update")
    */
    public function updateProfile(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UpdateProfileFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('message', 'Profil mis à jour');
            return $this->redirectToRoute('user');
        }
        return $this->render('user/update_profile.html.twig', [
            'updateProfileForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/password/update", name="user_password_update")
     */
    public function updatePassword(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UpdatePasswordFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('message', 'Mot de passe mis à jour avec succès');
            return $this->redirectToRoute('user');
        }
        return $this->render('user/update_password.html.twig', [
            'updatePasswordForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/email/update", name="user_email_update")
     */
    public function updateEmail(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UpdateEmailFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setEmail(
                $form->get('email')->getData()
            );
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('message', 'L\'adresse e-mail a été mise à jour avec succès');
            return $this->redirectToRoute('user');
        }
        return $this->render('user/update_email.html.twig', [
            'updateEmailForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/data", name="user_data")
     */
    public function userData(): Response
    {
        return $this->render('user/data.html.twig');
    }

    /**
     * @Route("/user/data/download", name="user_data_download")
     */
    public function userDataDownload(): Response
    {
        // We define the PDF options
        $pdfOptions = new Options();
        // Default font
        $pdfOptions->set('defaultFont', 'Times-Roman');
        $pdfOptions->isRemoteEnabled(true);
        // We instantiate Dompdf
        $dompdf = new Dompdf($pdfOptions);
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ]
        ]);
        $dompdf->setHttpContext($context);

        // We generate the html
        $html = $this->renderView('user/download.html.twig');

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // We generate a file name
        $file = 'user-data-'. $this->getUser()->getId() .'.pdf';

        // We send the pdf to the browser
        $dompdf->stream($file, [
            'Attachment' => true
        ]);

        return new Response;
    }
}
