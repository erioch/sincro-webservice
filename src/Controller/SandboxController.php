<?php

namespace App\Controller;

use App\Application\Service\Security\TokenValidator;
use App\Application\Service\Sincro\GetSincroRequest;
use App\Application\Service\Sincro\GetSincroService;
use App\Application\Service\Sincro\PostSincroRequest;
use App\Application\Service\Sincro\PostSincroService;
use App\Application\Service\Sincro\PutSincroRequest;
use App\Application\Service\Sincro\PutSincroService;
use App\Application\Service\Sincro\SincroResponse;
use App\Application\Service\Sincro\ViewSincroRequest;
use App\Application\Service\Sincro\ViewSincroService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("sandbox")
 */
class SandboxController extends Controller
{
    /**
     * @Route("/")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('sandbox/index.html.twig');
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

        return $this->render('sandbox/post.html.twig', [
            'result' => $result,
        ]);
    }

    /**
     * @Route("/get")
     *
     * @param Request          $request
     * @param GetSincroService $getSincro
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAction(Request $request, GetSincroService $getSincro)
    {
        $this->checkValidRequest($request);

        $destiny = $request->get('destiny');

        $result = $getSincro->execute(new GetSincroRequest($destiny));
        $result = $this->get(SincroResponse::class)->fromArray($result);

        return $this->render('sandbox/get.html.twig', [
            'result' => $result,
        ]);
    }

    /**
     * @Route("/put")
     *
     * @param Request           $request
     * @param PutSincroService  $putSincro
     * @param ViewSincroService $viewSincro
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function putAction(Request $request, PutSincroService $putSincro, ViewSincroService $viewSincro)
    {
        $this->checkValidRequest($request);

        $sincroId = $request->get('sincro_id');

        try {
            $putSincro->execute(new PutSincroRequest($sincroId));
        } catch (\Exception $e) {
            return new Response($e->getMessage());
        }

        $sincro = $viewSincro->execute(new ViewSincroRequest($sincroId));
        $sincro = $this->get(SincroResponse::class)->toArray($sincro);

        return $this->render('sandbox/view.html.twig', [
            'sincro' => $sincro,
        ]);
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
