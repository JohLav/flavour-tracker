<?php

    namespace App\Controller;

    use App\Form\ContactType;
    use Symfony\Component\Security\Http\Attribute\IsGranted;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
    use Symfony\Component\Mailer\MailerInterface;
    use Symfony\Component\Mime\Email;
    use Symfony\Component\Routing\Annotation\Route;

    #[Route('/contact', name: 'contact_')]
class ContactController extends AbstractController
{
    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/', name: 'index')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contactData = $form->getData();
            $subject = 'Demande de contact sur votre site';
            $content = $contactData['name'] . ' vous a envoyé le message suivant: ' . $contactData['message'];

            $email = (new Email())
                ->from($contactData['email'])
                ->to('contact@trackersdesaveurs.com')
                ->subject($subject)
                ->text($content);

            $mailer->send($email);
            $this->addFlash('success', message: 'Votre message a été envoyé');
            return $this->redirectToRoute('home_index');
        }
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/reply', name: 'reply')]
    #[IsGranted('ROLE_SUPER_ADMIN')]
    public function new(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contactData = $form->getData();
            $content = $contactData['message'];

            $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to($contactData['email'])
                ->subject('Confirmation de votre demande')
                ->text($content);

            $mailer->send($email);
            return $this->redirectToRoute('home_index');
        }
        return $this->render('contact/reply.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
