<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends Controller
{
    /**
     * @Route("/")
     *
     * @return Response
     */
    public function indexAction()
    {
        return new Response('HClinic Dubai Web Service.');
    }

    /**
     * @Route("/get/{destiny}")
     */
    public function getAction($destiny)
    {
    }

    public function postAction(Request $request)
    {
    }
}
