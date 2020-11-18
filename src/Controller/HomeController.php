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

        $allArticleRandom = $articleManager->getAllArticleOrderBy("RAND()");
        $articleRandom = $articleManager->getArticleOrderBy("RAND()");
        $articleTrend = $articleManager->getArticleOrderBy('star DESC');
        $articleDate = $articleManager->getArticleOrderBy('created_at DESC');
        $articleOfWeek = $articleManager->getArticleOfWeek();

        $search = [];
        $error = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['search']) && !empty($_POST['search'])) {
                $_POST['search'] = trim($_POST['search']);
                $search = $articleManager->searchBar($_POST['search']);
            }
            if (isset($_POST['search']) && empty($search)) {
                $error = ['Pas de résultats pour la recherche contenant le mot clé : ' .  $_POST['search']];
            }
        }

        $twigs = [
            'article_of_week' => $articleOfWeek,
            'all_article_random' => $allArticleRandom,
            'article_random' => $articleRandom,
            'article_trend' => $articleTrend,
            'article_date' => $articleDate,
            'search_data' => $search,
            'search_error' => $error,
        ];

        return $this->twig->render('Home/index.html.twig', $twigs);
    }
}
