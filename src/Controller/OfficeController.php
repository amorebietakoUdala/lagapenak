<?php

namespace App\Controller;

use App\DTO\OfficeDTO;
use App\Form\OfficeFilterType;
use SoapClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OfficeController extends AbstractController
{

    /**
     * @Route("/", name="home", methods={"GET","POST"})
     */
    public function home(): Response
    {
        return $this->redirectToRoute('office_list');
    }

    /**
     * @Route("/{_locale}/", name="office_list", methods={"GET","POST"})
     */
    public function list(Request $request): Response
    {
        $form = $this->createForm(OfficeFilterType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $url = $this->getParameter('soapServerURL');
            $client = new SoapClient($url);
            $params = [
                'filtroOficinas' => [
                    "denominacion" => $data['description'],
                ]
            ];
            $client->__soapCall("buscarOficinas", array($params));
            $response = $client->__getLastResponse();
            $xml = simplexml_load_string($response);
            $elements = $xml->xpath('.//oficinaReducidaDTO');
            $elementsArray = json_decode(json_encode($elements), true);
            $offices = [];
            foreach ($elementsArray as $element) {
                $office = new OfficeDTO();
                $office->fill($element);
                $offices[] = $office;
            }
            return $this->renderForm('office/list.html.twig', [
                'form' => $form,
                'offices' => $offices,
            ]);
        }

        return $this->renderForm('office/list.html.twig', [
            'form' => $form,
        ]);
    }
}
