<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;

/**
 * This Listener y is needed to show error pages in corresponding locale
 */
class LocaleEventListener
{
   public function onKernelRequest(RequestEvent $event): void
   {
      $request = $event->getRequest();
      $pattern = '/\/(es|eu)\//';
      $matches = [];
      if (preg_match($pattern,$request->getPathInfo(),$matches)) {
         $request->setLocale($matches[1]);
      }
   }
}
