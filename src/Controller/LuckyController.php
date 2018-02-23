<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 23.02.18
 * Time: 17:56
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        return new Response($page);
    }

    /**
     * @Route("/lucky/{slug}", name="lucky_show")
     */
    public function show($slug)
    {
        return new Response('slug:' . $slug);
    }

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
}