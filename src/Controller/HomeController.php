<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\ArticleManager;
use App\Model\UserManager;

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

        $allArticleRandom = $articleManager->getAllArticleOrderBy("RAND()");
        $articleRandom = $articleManager->getArticleOrderBy("RAND()");
        $articleTrend = $articleManager->getArticleOrderBy('star DESC');
        $articleDate = $articleManager->getArticleOrderBy('created_at DESC');
        $articleOfWeek = $articleManager->getArticleOfWeek();

        $twigs = [
            'article_of_week' => $articleOfWeek,
            'all_article_random' => $allArticleRandom,
            'article_random' => $articleRandom,
            'article_trend' => $articleTrend,
            'article_date' => $articleDate,
        ];

        return $this->twig->render('Home/index.html.twig', $twigs);
    }
}
