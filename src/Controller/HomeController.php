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
        $articleManager = new ArticleManager();

        $articleRandom = $articleManager->getArticleOrderBy("RAND()");
        $articleTrend = $articleManager->getArticleOrderBy('star DESC');
        $articleDate = $articleManager->getArticleOrderBy('created_at DESC');
        $articleOfWeek = $articleManager->getArticleOfWeek();


        return $this->twig->render('Home/index.html.twig', [
            'article_of_week' => $articleOfWeek,
            'article_random' => $articleRandom,
            'article_trend' => $articleTrend,
            'article_date' => $articleDate,
        ]);
    }

}
