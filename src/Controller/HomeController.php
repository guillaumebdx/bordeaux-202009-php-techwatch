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

        $search = $articleManager->searchBar('');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['search']) and !empty($_POST['search'])) {
                $search = $articleManager->searchBar(trim($_POST['search']));
            }
        }

        $twigs = [
            'article_of_week' => $articleOfWeek,
            'article_random' => $articleRandom,
            'article_trend' => $articleTrend,
            'article_date' => $articleDate,
            'search_data' => $search,
        ];

        return $this->twig->render('Home/index.html.twig', $twigs);
    }
}
