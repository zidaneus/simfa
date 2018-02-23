<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 23.02.18
 * Time: 17:56
 */

declare(strict_types=1);

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class LuckyController extends Controller
{
    /**
     * @Route("/lucky/number")
     * @return Response
     */
    public function number()
    {
        $number = mt_rand(0, 100);

        return $this->render('lucky/number.html.twig', [
            'number' => $number,
        ]);
    }

    /**
     * @Route("/lucky/{page}", name="lucky_list", requirements={"page"="\d+"})
     */
    public function list($page = 1)
    {
        return new Response('page: ' . $page);
    }

    /**
     * @Route("/lucky/{slug}", name="lucky_show")
     */
    /*public function show($slug)
    {
        return new Response('slug:' . $slug);
    }*/

    /**
     * @Route(
     *     "/lucky/{_locale}/{year}/{slug}.{_format}",
     *     defaults={"_format": "html"},
     *     requirements={
     *         "_locale": "en|ru",
     *         "_format": "html|rss",
     *         "year": "\d+"
     *     }
     * )
     */
    public function locale($_locale, $year, $slug)
    {
        return new Response('locale:' . $_locale . ' year:' . $year . ' slug:' . $slug);
    }

    /**
     * @Route("/lucky/number-with-service/{max}")
     */
    public function numberWithService($max, LoggerInterface $logger)
    {
        $logger->info('We are logging!');

        return new Response('logger');
    }

    /**
     * @Route("/lucky/index", name="lucky_index")
     * @return Response
     */
    public function index()
    {
            // retrieve the object from database
            $product = 0;
        if (!$product) {
            throw $this->createNotFoundException('The product does not exist');

            // the above is just a shortcut for:
            // throw new NotFoundHttpException('The product does not exist');
        }

        return new Response('index');
    }

    /**
     * @Route("/lucky/index2/{page}", name="lucky_index2")
     * @return Response
     */
    public function index2($page, Request $request, SessionInterface $session)
    {
        $foo = $session->get('foo');
        $host = $request->headers->get('host');

        return new Response($page . ' host: ' . $host . ' foo: ' . $foo);
    }

    /**
     * @Route("/lucky/session", name="lucky_session")
     * @return Response
     */
    public function session(SessionInterface $session): Response
    {
        // stores an attribute for reuse during a later user request
        $session->set('foo', 'bar1');

        // gets the attribute set by another controller in another request
        $foobar = $session->get('foobar');

        // uses a default value if the attribute doesn't exist
        $filters = $session->get('filters', array());

        return new Response('session');
    }

    /**
     * @Route("/lucky/flash", name="lucky_flash")
     * @return Response
     */
    public function flash()
    {
        $this->addFlash(
            'notice',
            'Your changes were saved!'
        );

        return $this->redirect('/lucky/number');
    }

    /**
     * @Route("/lucky/json")
     *
     */
    public function toJson()
    {
        // returns '{"username":"jane.doe"}' and sets the proper Content-Type header
        return $this->json(['username' => 'jane.doe']);
    }

}