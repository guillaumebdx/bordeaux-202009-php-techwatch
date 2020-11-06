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

    public function articlesByDate()
    {
        $articleManagerByDate = new ArticleManager();

        $articleViewByDate = $articleManagerByDate->getArticleOrderBy('created_at DESC');
        return $this->twig->render('articles_by_date.html.twig', [
            'article_date_view' => $articleViewByDate,
        ]);
    }

    public function articlesByTrend()
    {
        $articleManagerTrend = new ArticleManager();

        $articleViewByTrend = $articleManagerTrend->getArticleOrderBy('star DESC');
        return $this->twig->render('articles_by_trend.html.twig', [
            'article_trend_view' => $articleViewByTrend,
        ]);
    }
}
