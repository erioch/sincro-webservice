<?php

namespace App\Controller;

use App\Application\Service\Sincro\GetSincroRequest;
use App\Application\Service\Sincro\GetSincroService;
use App\Application\Service\Sincro\PostSincroRequest;
use App\Application\Service\Sincro\PostSincroService;
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
     * @Route("/get")
     *
     * @param Request          $request
     * @param GetSincroService $getSincro
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAction(Request $request, GetSincroService $getSincro)
    {
        $destiny = $request->get('destiny');

        $result = $getSincro->execute(
            new GetSincroRequest($destiny)
        );

        return $this->render('sandbox/get.html.twig', [
            'result' => $result,
        ]);
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
        $form = $request->get('sincro');

        try {
            $result = $postSincro->execute(new PostSincroRequest(
                $form['origin'],
                $form['destiny'],
                $form['file']
            ));
        } catch (\Exception $e) {
            return new Response($e->getMessage());
        }

        return $this->render('sandbox/post.html.twig', [
            'result' => $result,
        ]);
    }
}
