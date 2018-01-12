<?php

namespace App\Controller;

use App\Application\Service\Security\TokenValidator;
use App\Application\Service\Sincro\GetSincroRequest;
use App\Application\Service\Sincro\GetSincroService;
use App\Application\Service\Sincro\PostSincroRequest;
use App\Application\Service\Sincro\PostSincroService;
use App\Application\Service\Sincro\PutSincroRequest;
use App\Application\Service\Sincro\PutSincroService;
use App\Application\Service\Sincro\ViewSincroRequest;
use App\Application\Service\Sincro\ViewSincroService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends Controller
{
    /**
     * @Route("/get/{destiny}")
     *
     * @param Request          $request
     * @param string           $destiny
     * @param GetSincroService $getSincro
     *
     * @return Response
     */
    public function getAction(Request $request, $destiny, GetSincroService $getSincro)
    {
        $this->checkValidRequest($request);

        $result = $getSincro->execute(
            new GetSincroRequest($destiny)
        );

        return new Response($result);
    }

    /**
     * @Route("/post")
     *
     * @param Request           $request
     * @param PostSincroService $postSincro
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postAction(Request $request, PostSincroService $postSincro)
    {
        $this->checkValidRequest($request);

        $form = $request->get('sincro');
        $file = $request->files->get('sincro');

        try {
            $result = $postSincro->execute(new PostSincroRequest(
                $form['origin'],
                $form['destiny'],
                $file['file']
            ));
        } catch (\Exception $e) {
            return new Response($e->getMessage());
        }

        return new Response($result);
    }

    /**
     * @Route("/put/{sincroId}")
     *
     * @param Request           $request
     * @param int               $sincroId
     * @param PutSincroService  $putSincro
     * @param ViewSincroService $viewSincro
     *
     * @return Response
     */
    public function putAction(Request $request, $sincroId, PutSincroService $putSincro, ViewSincroService $viewSincro)
    {
        $this->checkValidRequest($request);

        try {
            $putSincro->execute(new PutSincroRequest($sincroId));
        } catch (\Exception $e) {
            return new Response($e->getMessage());
        }

        $sincro = $viewSincro->execute(new ViewSincroRequest($sincroId));

        return new Response($sincro);
    }

    /**
     * @param Request $request
     */
    private function checkValidRequest(Request $request)
    {
        $this->get(TokenValidator::class)->validate(
            $request->get('token')
        );
    }
}
