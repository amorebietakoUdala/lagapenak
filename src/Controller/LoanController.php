<?php

namespace App\Controller;

use App\Entity\Loan;
use App\Form\LoanSearchType;
use App\Form\LoanType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class LoanController extends BaseController
{

    public function __construct(private readonly MailerInterface $mailer, private readonly EntityManagerInterface $em)
    {
    }

    #[Route(path: '/{_locale}/loan/new', name: 'loan_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $this->loadQueryParameters($request);
        $loan = new Loan();
        $form = $this->createForm(LoanType::class, $loan, [
            'roles' => $this->getUser()->getRoles(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Loan $data */
            $data = $form->getData();
            $data->setDate(new DateTime());
            $data->setAskedBy($this->getUser());
            $this->em->persist($data);
            $this->em->flush();
            $html = $this->renderView('loan/askedLoanMail.html.twig', [
                'loan' => $loan
            ]);
            $subject = "{$loan->getAskedBy()} lagapen eskaria / Solicitud de préstamo de {$loan->getAskedBy()}";
            $this->sendEmail($this->getParameter('archiver_email'), $subject, $html);            

            if ($request->isXmlHttpRequest()) {
                return new Response(null, Response::HTTP_NO_CONTENT);
            }

            return $this->redirectToRoute('loan_index');
        }
        
        $template = $request->isXmlHttpRequest() ? '_form.html.twig' : 'new.html.twig';

        return $this->render('loan/' . $template, [
            'form' => $form,
            'readonly' => false,
        ]);
    }

    #[Route(path: '/{_locale}/loan/{id}', name: 'loan_show', methods: ['GET', 'POST'])]
    public function show(Request $request, Loan $loan): Response
    {
        $this->loadQueryParameters($request);
        $form = $this->createForm(LoanType::class, $loan, [
            'readonly' => true,
            'roles' => $this->getUser()->getRoles(),
        ]);
        $template = $request->isXmlHttpRequest() ? '_form.html.twig' : 'edit.html.twig';
        return $this->render('loan/' . $template, [
            'loan' => $loan,
            'form' => $form,
            'readonly' => true
        ]);
    }

    #[Route(path: '/{_locale}/loan/{id}/edit', name: 'loan_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Loan $loan): Response
    {
        $this->loadQueryParameters($request);
        $form = $this->createForm(LoanType::class, $loan, [
            'readonly' => false,
            'roles' => $this->getUser()->getRoles(),
        ]);
        $previousDateOfReturn = $loan->getDateOfReturn();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Loan $data */
            $data = $form->getData();
            $this->em->persist($data);
            $this->em->flush();
            $this->addFlash('success','message.loan.saved');
            if ($previousDateOfReturn === null && $data->getDateOfReturn() !== null ) {
                $html = $this->renderView('loan/returnedLoanMail.html.twig', [
                    'loan' => $loan
                ]);
                $subject = "{$loan->getId()} zenbakidun lagapena itzuli egin duzu / Ha devuelto el préstamo nº {$loan->getId()}";
                $this->sendEmail($loan->getAskedBy()->getEmail(), $subject, $html);            
            }
            return $this->redirectToRoute('loan_index');
        }

        $template = $request->isXmlHttpRequest() ? '_form.html.twig' : 'edit.html.twig';

        return $this->render('loan/' . $template, [
            'loan' => $loan,
            'form' => $form,
            'readonly' => false
        ]);
    }

    #[Route(path: '{_locale}/loan/{id}/delete', name: 'loan_delete', methods: ['POST'])]
    public function delete(Request $request, Loan $loan): Response
    {
        $this->loadQueryParameters($request);
        if ($this->isCsrfTokenValid('delete'.$loan->getId(), $request->get('_token'))) {
            $this->em->remove($loan);
            $this->em->flush();
            return $this->redirectToRoute('loan_index');
        }

        return new Response(null, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    #[Route(path: '{_locale}/loan/{id}/send', name: 'loan_send', methods: ['GET'])]
    public function send(Request $request, Loan $loan): Response
    {
        $this->loadQueryParameters($request);
        if ($this->isCsrfTokenValid('send'.$loan->getId(), $request->get('_token'))) {
            $loan->setDateOfLoan(new \DateTime());
            $this->em->persist($loan);
            $this->em->flush();
            return $this->redirectToRoute('loan_index');
        }

        return new Response(null, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    #[Route(path: '{_locale}/loan/{id}/return', name: 'loan_return', methods: ['GET'])]
    public function return(Request $request, Loan $loan): Response
    {
        $this->loadQueryParameters($request);
        if ($this->isCsrfTokenValid('return'.$loan->getId(), $request->get('_token'))) {
            $loan->setDateOfReturn(new \DateTime());
            $this->em->persist($loan);
            $this->em->flush();
            $html = $this->renderView('loan/returnedLoanMail.html.twig', [
                'loan' => $loan
            ]);
            $subject = "{$loan->getId()} zenbakidun lagapena itzuli egin duzu / Ha devuelto el préstamo nº {$loan->getId()}";
            $this->sendEmail($loan->getAskedBy()->getEmail(), $subject, $html);            
            return $this->redirectToRoute('loan_index');
        }

        return new Response(null, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    #[Route(path: '/{_locale}/loan', name: 'loan_index', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $this->loadQueryParameters($request);
        $searchFilter = $this->createForm(LoanSearchType::class);
        $user = $this->getUser();

        $searchFilter->handleRequest($request);
        if ($searchFilter->isSubmitted() && $searchFilter->isValid()) {
            $criteria = $searchFilter->getData();
            $loans = $this->em->getRepository(Loan::class)->findLoansByCriteria($criteria);

            $template = $request->query->get('ajax') || $request->isXmlHttpRequest() ? '_list.html.twig' : 'index.html.twig';

            return $this->render('loan/' . $template, [
                'loans' => $loans,
                'filter' => $searchFilter,
            ]);
        }

        if ( in_array('ROLE_ARCHIVER', $user->getRoles()) || in_array('ROLE_ADMIN', $user->getRoles())) {
            $loans = $this->em->getRepository(Loan::class)->findBy([
                'dateOfReturn' => null,
            ],[
                'date' => 'DESC'
            ]);
        } else {
            $loans = $this->em->getRepository(Loan::class)->findBy([
                'askedBy' => $user,
                // If we wan't to return only, not returned loans, add this filter
                // 'dateOfReturn' => null,
            ],[
                'date' => 'DESC'
            ]);
        }

        $template = $request->query->get('ajax') ? '_list.html.twig' : 'index.html.twig';
        return $this->render('loan/' . $template, [
            'loans' => $loans,
            'filter' => $searchFilter,
        ]);
    }

    private function sendEmail($to, $subject, $html, bool $sendToHHRR = false)
    {
        $email = (new Email())
            ->from($this->getParameter('mailerFrom'))
            ->to($to)
            ->subject($subject)
            ->html($html);
        $this->mailer->send($email);
    }

}
