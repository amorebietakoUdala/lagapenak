<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AppErrorController extends AbstractController {
   
    protected array $errorParameters = [];

    public function __construct(
        protected ?string $department, 
        protected ?string $contactEmail, 
        protected ?string $departmentDefault = null, 
        protected ?string $contactEmailDefault = null)
    {
        $this->errorParameters = [
            'department' => $this->department,
            'departmentDefault' => $this->departmentDefault,
            'contactEmail' => $this->contactEmail,
            'contactEmailDefault' => $this->contactEmailDefault,
        ];
    }

    public function show(Request $request, $exception): Response
    {
        $statusCode = $exception->getStatusCode();
        $statusText = $exception->getStatusText();
        $parameters = array_merge($this->errorParameters,[
            'statusCode' => $statusCode,
            'statusText' => $statusText,
            'exception' => $exception,
            'exceptionMessage' => $exception->getMessage(),
        ]);
        if ( $statusCode === 401 || $statusCode === 403 || $statusCode === 404 ) {
            $template = "@Twig\\Exception\\error$statusCode.html.twig";
        } else {
            $template = "@Twig\\Exception\\error.html.twig";
        }
        // dd($template, $parameters);
        return $this->render($template, $parameters);        
    }
}