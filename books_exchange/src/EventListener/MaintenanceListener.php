<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Twig\Environment;

class MaintenanceListener{
    private $maintenance;
    private $twig;

    public function __construct($maintenance, Environment $twig){
        $this->maintenance = $maintenance;
        $this->twig = $twig;
    }

    public function onKernelRequest(RequestEvent $event){
        // We check if the .maintenance file does not exist.
        if(!file_exists($this->maintenance)){
            return;
        }
        // The file exists
        // We define the response
        $event->setResponse(
            new Response(
                $this->twig->render('maintenance/maintenance.html.twig'),
                Response::HTTP_SERVICE_UNAVAILABLE
            )
        );
        // We stop the processing of events
        $event->stopPropagation();
    }
}