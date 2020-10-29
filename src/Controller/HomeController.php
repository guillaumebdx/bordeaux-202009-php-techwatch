<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\ArticleManager;

class HomeController extends AbstractController
{

    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {


        $articleManagerRandom = new ArticleManager();
        $articleRandom = $articleManagerRandom->getTechnologyWatchRand();

        $articleManagerTrend = new ArticleManager();
        $articleTrend = $articleManagerTrend->getTechnologyWatchByStar();

        $articleManagerDate = new ArticleManager();
        $articleDate = $articleManagerDate->getTechnologyWatchByDate();


        $articleManager = new ArticleManager();
        $articleOfWeek = $articleManager->getTechnologyWatchOfWeek();
        return $this->twig->render('Home/index.html.twig', [
            'articleOfWeek' => $articleOfWeek,
            'articleRandom' => $articleRandom,
            'articleTrend' => $articleTrend,
            'articleDate' => $articleDate,
        ]);
    }
}
